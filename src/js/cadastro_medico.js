document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const cadastroMedicoForm = document.getElementById("cadastroMedicoForm");
    const alertContainer = document.getElementById("alert-container");

    cadastroMedicoForm.addEventListener("submit", async function(e) {
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
                    <i class="fas fa-check-circle"></i> Médico cadastrado com sucesso (simulado).
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            cadastroMedicoForm.reset();
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            window.scrollTo({ top: 0, behavior: "smooth" });
        }, 1000); // Simula um tempo de processamento
    });
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        // Em um ambiente real, aqui você faria uma requisição para o backend para encerrar a sessão
        // Por enquanto, apenas redireciona para a página de login
        window.location.href = "../public/login.html";
    }
};