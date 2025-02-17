const cpf = document.getElementById('cpf')

cpf.addEventListener('keypress', () => {
    let cpfLength = cpf.value.length

    if (cpfLength === 3 || cpfLength === 7) {
        cpf.value += '.'
    } else if (cpfLength === 11) {
        cpf.value += '-'
    }
})


//TELEFONE:

const telefone = document.getElementById('telefone');

telefone.addEventListener('input', () => {
    let telefoneValue = telefone.value.replace(/\D/g, '');

    if (telefoneValue.length > 2) {
        telefoneValue = `(${telefoneValue.substring(0, 2)}) ${telefoneValue.substring(2)}`;
    }
    if (telefoneValue.length > 10) {
        telefoneValue = `${telefoneValue.substring(0, 10)}-${telefoneValue.substring(10)}`;
    }

    telefone.value = telefoneValue;
});

// CEP:

const cep = document.getElementById('cep')

cep.addEventListener('input', () => {
    let cepLength = cep.value.length

    if (cepLength === 5) {
        cep.value += '-'

    }
})


