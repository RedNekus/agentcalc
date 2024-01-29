document.addEventListener('DOMContentLoaded', () => {
    const agentCalcForm = document.getElementById('agetntcalcForm');
    const calcForm = document.getElementById('calcForm');
    const calcTable = document.getElementById('credit-table');
    const tabs = document.querySelectorAll('.agentcalc__tabs a');
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
                data:  JSON.stringify({
                    'price': price? price.replaceAll(' ', '') : 0,
                    'payment': payment? payment.replaceAll(' ', '') : 0,
                    'prepayment': formData.get('jform[prepayment]').replaceAll(' ', '')
                }),
                onSuccess: (response) => {
                    const result = JSON.parse(response);
                    if(result.success) {
                        calcTable.classList.add('is-filled');
                        tableBody.innerHTML = result.data?.tbody !== '' ? result.data.tbody : '<tr><td colspan="5">Произошла ошибка</td></tr>';
                    }
                }
            })
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