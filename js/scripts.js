document.addEventListener("DOMContentLoaded", function() {
    // Se desejar adicionar validação específica para a página de cadastro
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function(event) {
            const nome = document.querySelector('input[name="nome"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const senha = document.querySelector('input[name="senha"]').value;

            if (nome === "" || email === "" || senha === "") {
                alert("Todos os campos são obrigatórios.");
                event.preventDefault();
            }
        });
    }
});