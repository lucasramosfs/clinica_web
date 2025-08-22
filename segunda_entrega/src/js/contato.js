document.addEventListener('DOMContentLoaded', function() {
    // Formulário de contato
    document.getElementById('contatoForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('../../../api/enviar_contato.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                VitaCare.showToast(`${result.message}`, "success");

                this.reset();
            } else {
                VitaCare.showToast(`${result.error}`, "danger");
            }
        } catch (error) {
            VitaCare.showToast(`Erro ao enviar mensagem. Tente novamente.`, "danger");

            }
        });

    // Máscara para telefone
    const telefoneInput = document.querySelector('[type="tel"]');
    if (telefoneInput) {
        aplicarMascaraTelefone(telefoneInput);
    }
});


