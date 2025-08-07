document.addEventListener("DOMContentLoaded", function() {
            // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const cadastroFuncionarioForm = document.getElementById("cadastroFuncionarioForm");
    const alertContainer = document.getElementById("alert-container");

    cadastroFuncionarioForm.addEventListener("submit", async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector("button[type=\"submit\"]");
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.innerHTML = 
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cadastrando...`;
        submitBtn.disabled = true;

        // Simular sucesso no cadastro após um pequeno atraso
        setTimeout(() => {
            alertContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> Funcionário cadastrado com sucesso (simulado).
                    <button type="button" class="btn-close" data-dismiss="alert">
                    </button>
                </div>
            `;
            cadastroFuncionarioForm.reset();
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            window.scrollTo({ top: 0, behavior: "smooth" });
        }, 1000); // Simula um tempo de processamento
    });

    const telefoneInput = document.querySelector('[type="tel"]');
    if (telefoneInput) {
        aplicarMascaraTelefone(telefoneInput);
    }

    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        aplicarMascaraCPF(cpfInput);
    }


});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};