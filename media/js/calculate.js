document.addEventListener('DOMContentLoaded', () => {
    const agentCalcForm = document.getElementById('agetntcalcForm');
    agentCalcForm.addEventListener('submit', (evt) => {
        evt.preventDefault();
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
                'price': formData.get('jform[price]'),
                'prepayment': formData.get('jform[prepayment]')
            }),
            onSuccess: (response) => {
                const result = JSON.parse(response);
                console.log(result);
            }
        })
    })
});