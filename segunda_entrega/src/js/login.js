// JavaScript específico para a página de login

document.addEventListener("DOMContentLoaded", function() {
    // const formularioLogin = document.getElementById("loginForm");
    
    // if (formularioLogin) {
    //     formularioLogin.addEventListener("submit", async function(e) {
    //         e.preventDefault();
            
    //         const email = document.getElementById("email").value;
    //         const senha = document.getElementById("senha").value;
            
    //         if (!email || !senha) {
    //             VitaCare.showToast("Por favor, preencha todos os campos.", "danger");
    //             return;
    //         }

    //         try {
    //             const formData = new URLSearchParams();
    //             formData.append("email", email);
    //             formData.append("senha", senha);

    //             const response = await fetch("../../../api/login.php", {
    //                 method: "POST",
    //                 headers: {
    //                     "Content-Type": "application/x-www-form-urlencoded"
    //                 },
    //                 body: formData.toString()
    //             });

    //             const result = await response.json();

    //             if (result.success) {
    //                 localStorage.setItem("sessao_usuario", JSON.stringify({
    //                     usuario: result.funcionario,
    //                     timestamp: Date.now()
    //                 }));
    //                 alert("Login realizado com sucesso!");
    //                 setTimeout(() => {
    //                     window.location.href = "../restrito/dashboard.php";
    //                 }, 1000);
    //             } else {
    //                 alert(`Erro no login: ${result.error}`);
    //             }
    //         } catch (error) {
    //             console.error("Erro ao tentar fazer login:", error);
    //             alert("Erro de conexão ao tentar fazer login.");
    //         }
    //     });
    // }

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


