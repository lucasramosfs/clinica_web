// JavaScript específico para a página de login

document.addEventListener('DOMContentLoaded', function() {
    const formularioLogin = document.getElementById('loginForm');
    
    if (formularioLogin) {
        formularioLogin.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const usuario = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            
            // Validações básicas
            if (!usuario || !senha) {
                mostrarMensagem('Por favor, preencha todos os campos.', 'danger');
                return;
            }
            
            // Simulação de login (substituir por autenticação real)
            if (usuario === 'joao@clinica.com' && senha === 'admin123') {
                localStorage.setItem('sessao_usuario', JSON.stringify({
                    usuario: usuario,
                    timestamp: Date.now()
                }));
                
                mostrarMensagem('Login realizado com sucesso!', 'success');
                
                // Redirecionar após 1 segundo
                setTimeout(() => {
                    window.location.href = '../restrito/dashboard.html';
                }, 1000);
            } else {
                mostrarMensagem('Usuário ou senha incorretos.', 'danger');
            }
        });
    }
});




// Script movido de login.html
document.addEventListener("DOMContentLoaded", function() {
    // Toggle mostrar/ocultar senha
    document.getElementById("togglePassword").addEventListener("click", function() {
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

    // Formulário de login (SIMULADO)
    document.getElementById("loginForm").addEventListener("submit", async function(e) {
        e.preventDefault();
        
        const alertContainer = document.getElementById("alert-container");
        const submitBtn = this.querySelector("button[type=\"submit\"]");
        
        // Mostrar loading
        submitBtn.innerHTML = 
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Entrando...`;
        submitBtn.disabled = true;
        
        // Simular sucesso no login após um pequeno atraso
        setTimeout(() => {
            alertContainer.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Login realizado com sucesso. Redirecionando...
                </div>
            `;
            
            // Redirecionar para área restrita
            setTimeout(() => {
                window.location.href = "";
            }, 500); // Atraso menor para redirecionamento
        }, 1000); // Simula um tempo de processamento
    });

    // Formulário de recuperação de senha
    document.getElementById("recuperarSenhaForm").addEventListener("submit", function(e) {
        e.preventDefault();
        
        // Simular envio
        alert("Link de recuperação enviado para seu e-mail!");
        $("#recuperarSenhaModal").modal("hide");
        this.reset();
    });
});


