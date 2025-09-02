document.addEventListener("DOMContentLoaded", function() {

    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('../../../api/login.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                VitaCare.showToast(`${result.message}`, "success");
                setTimeout(() => {
                    window.location.href = result.redirect;
                },1500); //Espera 1,5 segundo e redireciona ao dashboard

                this.reset();
            } else {
                VitaCare.showToast(`${result.error}`, "danger");
            }
        } catch (error) {
            VitaCare.showToast(`Erro ao enviar mensagem. Tente novamente.`, "danger");

            }
        });

    // Toggle mostrar/ocultar senha
    const togglePassword = document.getElementById("togglePassword");
    if (togglePassword) {
        togglePassword.addEventListener("click", function() {
            const senhaInput = document.getElementById("senha");
            const icon = this.querySelector("i");
            
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                senhaInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    }

    // Formulário de recuperação de senha
    const recuperarSenhaForm = document.getElementById("recuperarSenhaForm");
    if (recuperarSenhaForm) {
        recuperarSenhaForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Simular envio
            VitaCare.showToast("Link de recuperação enviado para seu e-mail! (Simulado)", "info");
            const modal = document.getElementById("recuperarSenhaModal");
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
            this.reset();
        });
    }
});


