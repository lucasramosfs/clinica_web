document.addEventListener('DOMContentLoaded', function() {
    
    // Função para confirmar exclusão
    window.confirmarExclusao = function(id, tipo) {
        if (confirm(`Tem certeza que deseja excluir este ${tipo}?`)) {
            mostrarMensagem(`${tipo} excluído com sucesso!`, 'success');
            // Aqui seria feita a exclusão real
            const linha = document.querySelector(`tr[data-id="${id}"]`);
            if (linha) {
                linha.remove();
            }
        }
    };
    
    // Função para editar item
    window.editarItem = function(id, tipo) {
        mostrarMensagem(`Função de edição do ${tipo} será implementada.`, 'info');
    };
    
    // Busca simples na tabela
    const campoBusca = document.getElementById('busca');
    if (campoBusca) {
        campoBusca.addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            const linhas = document.querySelectorAll('tbody tr');
            
            linhas.forEach(linha => {
                const texto = linha.textContent.toLowerCase();
                if (texto.includes(termo)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    }
});

