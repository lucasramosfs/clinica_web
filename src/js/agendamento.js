// JavaScript específico para a página de agendamento

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('agendamentoForm');
    const especialidadeSelect = document.getElementById('especialidade');
    const medicoSelect = document.getElementById('medico');
    const campoData = document.getElementById('data');
    
    // Definir data mínima como hoje
    if (campoData) {
        const hoje = new Date().toISOString().split('T')[0];
        campoData.min = hoje;
    }
    
    // Carregar especialidades (simulado)
    function carregarEspecialidades() {
        const especialidades = [
            'Cardiologia',
            'Dermatologia', 
            'Ortopedia'
        ];
        
        especialidades.forEach(esp => {
            const opcao = document.createElement('option');
            opcao.value = esp.toLowerCase();
            opcao.textContent = esp;
            especialidadeSelect.appendChild(opcao);
        });
    }
    
    // Carregar médicos baseado na especialidade
    if (especialidadeSelect) {
        especialidadeSelect.addEventListener('change', function() {
            medicoSelect.innerHTML = '<option value="">Selecione um médico</option>';
            
            const medicos = {
                'cardiologia': ['Dr. Lucas Ramos', 'Dra. Maria Santos'],
                'dermatologia': ['Dr. Mateu Xauan', 'Dra. Ana Lima'],
                'ortopedia': ['Dr. Victor Nogueira', 'Dra. Lucia Ferreira']
            };
            
            const medicosEspecialidade = medicos[this.value] || [];
            medicosEspecialidade.forEach(medico => {
                const opcao = document.createElement('option');
                opcao.value = medico.toLowerCase().replace(/\s+/g, '-');
                opcao.textContent = medico;
                medicoSelect.appendChild(opcao);
            });
        });
    }
    
    // Máscara simples para telefone
    const telefoneInput = document.getElementById('telefone_paciente');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            if (valor.length <= 11) {
                valor = valor.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (valor.length < 14) {
                    valor = valor.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = valor;
            }
        });
    }
    
    // Validação do formulário
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const dados = new FormData(formulario);
            const especialidade = dados.get('especialidade');
            const medico = dados.get('codigo_medico');
            const data = dados.get('data');
            const hora = dados.get('hora');
            const nome = dados.get('nome_paciente');
            const email = dados.get('email_paciente');
            
            // Validações básicas
            if (!especialidade || !medico || !data || !hora || !nome || !email) {
                mostrarMensagem('Por favor, preencha todos os campos obrigatórios.', 'danger');
                return;
            }
            
            if (!validarEmail(email)) {
                mostrarMensagem('Por favor, insira um email válido.', 'danger');
                return;
            }
            
            // Simular envio
            mostrarMensagem('Agendamento realizado com sucesso! Entraremos em contato para confirmação.', 'success');
            formulario.reset();
            
            // Recarregar especialidades
            especialidadeSelect.innerHTML = '<option value="">Selecione uma especialidade</option>';
            carregarEspecialidades();
        });
    }
    
    // Inicializar
    if (especialidadeSelect) {
        carregarEspecialidades();
    }
});

