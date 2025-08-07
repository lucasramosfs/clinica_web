// JavaScript específico para a página de contato

document.addEventListener('DOMContentLoaded', function() {
    const formularioContato = document.getElementById('contatoForm');
    
    if (formularioContato) {
        formularioContato.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nome = document.getElementById('nome').value;
            const email = document.getElementById('email').value;
            const telefone = document.getElementById('telefone').value;
            const mensagem = document.getElementById('mensagem').value;
            
            // Validações básicas
            if (!nome || !email || !mensagem) {
                mostrarMensagem('Por favor, preencha todos os campos obrigatórios.', 'danger');
                return;
            }
            
            if (!validarEmail(email)) {
                mostrarMensagem('Por favor, insira um email válido.', 'danger');
                return;
            }
            
            // Simular envio
            mostrarMensagem('Mensagem enviada com sucesso! Entraremos em contato em breve.', 'success');
            formularioContato.reset();
        });
    }
});




// Script movido de contato.html
document.addEventListener('DOMContentLoaded', function() {
    // Formulário de contato
    document.getElementById('contatoForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const alertContainer = document.getElementById('alert-container');
        const formData = new FormData(this);
        
        try {
            const response = await fetch('../api/enviar_contato.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> ${result.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                this.reset();
            } else {
               alertContainer.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> ${result.error}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            }
        } catch (error) {
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Erro ao enviar mensagem. Tente novamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            }
        });

    // Máscara para telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            if (value.length < 14) {
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = value;
        }
    });
});


