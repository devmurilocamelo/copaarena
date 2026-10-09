const telefone = document.getElementById('telefone');
if (telefone) {
    telefone.addEventListener('input', () => {
        let n = telefone.value.replace(/\D/g, '').slice(0, 11);
        if (n.length > 6)      telefone.value = `(${n.slice(0, 2)}) ${n.slice(2, n.length - 4)}-${n.slice(-4)}`;
        else if (n.length > 2) telefone.value = `(${n.slice(0, 2)}) ${n.slice(2)}`;
        else if (n.length > 0) telefone.value = `(${n}`;
        else                   telefone.value = '';
    });
}

document.querySelectorAll('.campo-erro input').forEach((input) => {
    input.addEventListener('input', () => {
        input.closest('.campo').classList.remove('campo-erro');
    }, { once: true });
});

const primeiroErro = document.querySelector('.campo-erro input');
if (primeiroErro) primeiroErro.focus();

const sucesso = document.querySelector('.alerta-sucesso');
if (sucesso) {
    history.replaceState(null, '', 'index.php');
    setTimeout(() => sucesso.classList.add('sumindo'), 5000);
    setTimeout(() => sucesso.remove(), 5600);
}
