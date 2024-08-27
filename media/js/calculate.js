document.addEventListener('DOMContentLoaded', () => {
    jQuery(function() {
        document.formvalidator.setHandler('prepayment',
            function (value) {
                let priceValue = 0;
                let price = document.getElementById(`jform_price`);
                let floatVal = parseFloat(value.replace(' ', '')) ?? 0;
                if(price) {
                    priceValue = parseFloat(price.value.replace(' ', '')) ?? 0;
                }
                if (priceValue < 15000) {
                    let regex = /\d{1,3}(\s\d{0,3}){0,2}\.\d{2}/;
                    return regex.test(value) && floatVal < priceValue;
                } else {
                    return floatVal >= .15 * priceValue && floatVal < priceValue;
                }
            }
        );
        document.formvalidator.setHandler('price',function (value) {
            let priceValue = parseFloat(value.replace(' ', '')) ?? 0;
            let prepayment = document.getElementById(`jform_prepayment`);
            let prepaymentValue = parseFloat(prepayment.value.replace(' ', '')) ?? 0;
            let regex = /([1-9]+(\d{0,2})?(\s\d{0,3}){0,2}\.\d{2})|(0\.(0[1-9]|[1-9]0|[1-9]{2}))/;
            return regex.test(value) && priceValue > prepaymentValue;
        });
    });
    const agentCalcForm = document.getElementById('agetntcalcForm');
    const calcForm = document.getElementById('calcForm');
    const calcTable = document.getElementById('credit-table');
    const tabs = document.querySelectorAll('.agentcalc__tabs a');
    const company = parseInt(agentCalcForm.dataset.company);

    if(company === 5) {
        let prepayment = document.getElementById(`jform_prepayment`)
        prepayment.classList.add('validate-prepayment');
        prepayment.classList.add('required');
        prepayment.removeAttribute('pattern');
        prepayment.dataset.validationText = 'Аванс должен составлять не менее 15% от стоимости предмета лизинга';
    }

    tabs.forEach((tab) => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            tabs.forEach(item => item.classList.remove('active'));
            tab.classList.add('active');
            if(tab.dataset.target === 'main') {
                calcForm.classList.add('is-hidden');
                agentCalcForm.classList.remove('is-hidden');
            } else if(tab.dataset.target === 'reverse') {
                agentCalcForm.classList.add('is-hidden');
                calcForm.classList.remove('is-hidden');
            }
        });
    });

    [agentCalcForm, calcForm].forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if(calcTable.classList?.contains('is-filled')) {
                calcTable.classList.remove('is-filled');
            }
            const tableBody = calcTable.tBodies[0];
            tableBody.innerHTML = '';
            if (document.formvalidator.isValid(form)) {
                let formData = new FormData(form);
                const uri = encodeURI(form.getAttribute('action')) ?? 'index.php?option=com_pcpartners&view=pcleads&format=json';
                let price = formData.get('jform[price]');
                let payment = formData.get('jform[payment]');
                Joomla.request({
                    url: uri,
                    method: 'POST',
                    headers: {
                        'Cache-Control': 'no-cache',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        'price': price ? price.replaceAll(' ', '') : 0,
                        'payment': payment ? payment.replaceAll(' ', '') : 0,
                        'prepayment': formData.get('jform[prepayment]').replaceAll(' ', '')
                    }),
                    onSuccess: (response) => {
                        const result = JSON.parse(response);
                        if (result.success) {
                            calcTable.classList.add('is-filled');
                            tableBody.innerHTML = result.data?.tbody !== '' ? result.data.tbody : '<tr><td colspan="5">Произошла ошибка</td></tr>';
                        }
                    }
                })
            }
        })
    })

    if(typeof  Cleave === 'function') {
        let inputs = document.querySelectorAll(`fieldset .inputbox.number`);
        inputs.forEach(input => {
            new Cleave(input, {
                numeral: true,
                numeralDecimalMark: '.',
                delimiter: ' ',
                onValueChanged: (e) => {
                    if(e.target.value ==='') {
                        input.rawValue = '0';
                        input.value = '0';
                    }
                    if (!e.target.rawValue.includes('.')) {
                        input.rawValue += '.00';
                        input.value += '.00';
                        let pos = input.value.length - 3;
                        input.setSelectionRange(pos, pos);
                    }
                }
            });
        })
    }
});