document.addEventListener('DOMContentLoaded', () => {
    const agentCalcForm = document.getElementById('agetntcalcForm');
    const calcTable = document.getElementById('credit-table');

    agentCalcForm.addEventListener('submit', (evt) => {
        evt.preventDefault();
        if(calcTable.classList?.contains('is-filled')) {
            calcTable.classList.remove('is-filled');
        }
        const tableBody = calcTable.tBodies[0];
        tableBody.innerHTML = '';

        let formData = new FormData(agentCalcForm);
        const uri = encodeURI(agentCalcForm.getAttribute('action')) ?? 'index.php?option=com_pcpartners&view=pcleads&format=json';
        Joomla.request({
            url: uri,
            method: 'POST',
            headers: {
                'Cache-Control': 'no-cache',
                'Content-Type': 'application/json'
            },
            data:  JSON.stringify({
                'price': formData.get('jform[price]').replace(' ', ''),
                'prepayment': formData.get('jform[prepayment]').replace(' ', '')
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

    if(typeof  Cleave === 'function') {
        let inputs = agentCalcForm.querySelectorAll('.agentcalc__fieldset .inputbox');
        inputs.forEach(input => {
            new Cleave(input, {
                numeral: true,
                numeralDecimalMark: '.',
                delimiter: ' ',
                onValueChanged: (e) => {
                    if(!e.target.value) {
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