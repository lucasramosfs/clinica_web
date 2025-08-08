document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const medicosTableBody = document.getElementById("medicos-table-body");
    const alertContainer = document.getElementById("alert-container");

    // Dados estáticos de exemplo para médicos
    const medicos = [
        {
            codigo: 1,
            nome: "Dr. Lucas Ramos",
            crm: "MG123456",
            especialidade: "Cardiologia",
            email: "lucas.ramos@vitacare.com.br",
            telefone: "(34) 99999-1111"
        },
        {
            codigo: 2,
            nome: "Dr. Mateu Xauan",
            crm: "MG654321",
            especialidade: "Dermatologia",
            email: "mateu.xauan@vitacare.com.br",
            telefone: "(34) 98888-2222"
        },
        {
            codigo: 3,
            nome: "Dr. Victor Nogueira",
            crm: "MG789012",
            especialidade: "Ortopedia",
            email: "victor.nogueira@vitacare.com.br",
            telefone: "(34) 97777-3333"
        }
    ];

    function carregarMedicosEstaticos() {
        if (medicos.length > 0) {
            let html = "";
            medicos.forEach(med => {
                html += `
                    <tr>
                        <td>${med.nome}</td>
                        <td>${med.crm}</td>
                        <td>${med.especialidade}</td>
                        <td>${med.email}</td>
                        <td>${med.telefone}</td>
                        <td>
                            <button class="btn btn-sm btn-info mr-1" onclick="editarMedico(${med.codigo})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="excluirMedico(${med.codigo})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            medicosTableBody.innerHTML = html;
        } else {
            medicosTableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">Nenhum médico cadastrado.</td>
                </tr>
            `;
        }
    }

    // Função para editar médico
    window.editarMedico = function(codigo) {
        const medico = medicos.find(m => m.codigo === codigo);
        if (medico) {
            document.getElementById('editCodigo').value = medico.codigo;
            document.getElementById('editNome').value = medico.nome;
            document.getElementById('editCrm').value = medico.crm;
            document.getElementById('editEspecialidade').value = medico.especialidade;
            document.getElementById('editEmail').value = medico.email;
            document.getElementById('editTelefone').value = medico.telefone;
            
            const modal = new bootstrap.Modal(document.getElementById('editarMedicoModal'));
            modal.show();
        }
    };

    // Função para salvar edição
    window.salvarEdicao = function() {
        const codigo = parseInt(document.getElementById('editCodigo').value);
        const nome = document.getElementById('editNome').value;
        const crm = document.getElementById('editCrm').value;
        const especialidade = document.getElementById('editEspecialidade').value;
        const email = document.getElementById('editEmail').value;
        const telefone = document.getElementById('editTelefone').value;

        // Validação básica
        if (!nome || !crm || !especialidade || !email || !telefone) {
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        // Validação do formato do CRM
        if (!crm.match(/^[A-Z]{2}\d{4,6}$/)) {
            alert('CRM deve seguir o formato: UF + números (ex: MG123456)');
            return;
        }

        // Encontrar e atualizar o médico
        const index = medicos.findIndex(m => m.codigo === codigo);
        if (index !== -1) {
            medicos[index] = {
                codigo: codigo,
                nome: nome,
                crm: crm.toUpperCase(),
                especialidade: especialidade,
                email: email,
                telefone: telefone
            };
            
            // Recarregar tabela
            carregarMedicosEstaticos();
            
            // Fechar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editarMedicoModal'));
            modal.hide();
            
            // Mostrar mensagem de sucesso
            mostrarAlerta('success', `${nome} foi atualizado com sucesso!`);
        }
    };

    // Função para excluir médico
    window.excluirMedico = function(codigo) {
        const medico = medicos.find(m => m.codigo === codigo);
        if (medico) {
            medicoParaExcluir = medico;
            document.getElementById('nomeParaExcluir').textContent = medico.nome;
            document.getElementById('crmParaExcluir').textContent = medico.crm;
            document.getElementById('especialidadeParaExcluir').textContent = medico.especialidade;
            
            const modal = new bootstrap.Modal(document.getElementById('confirmarExclusaoModal'));
            modal.show();
        }
    };

    // Função para confirmar exclusão
    window.confirmarExclusao = function() {
        if (medicoParaExcluir) {
            const index = medicos.findIndex(m => m.codigo === medicoParaExcluir.codigo);
            if (index !== -1) {
                const nomeMedico = medicos[index].nome;
                medicos.splice(index, 1);
                
                // Recarregar tabela
                carregarMedicosEstaticos();
                
                // Fechar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmarExclusaoModal'));
                modal.hide();
                
                // Mostrar mensagem de sucesso
                mostrarAlerta('warning', `${nomeMedico} foi removido da lista.`);
                
                medicoParaExcluir = null;
            }
        }
    };

    // Carregar médicos na inicialização
    carregarMedicosEstaticos();

    const telefoneInput = document.getElementById('editTelefone');
    if (telefoneInput) {
        aplicarMascaraTelefone(telefoneInput);
    }

    const crmInput = document.getElementById('editCrm');
    if (crmInput) {
        aplicarMascaraCRM(crmInput);
    }
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};