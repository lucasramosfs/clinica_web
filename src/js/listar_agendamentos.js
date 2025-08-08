document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const agendamentosTableBody = document.getElementById("agendamentos-table-body");
    const alertContainer = document.getElementById("alert-container");

    // Dados estáticos de exemplo para agendamentos
    const agendamentos = [
        {
            codigo: 1,
            nome_paciente: "Maria Souza",
            email_paciente: "maria.souza@email.com",
            telefone_paciente: "(34) 99999-0000",
            especialidade: "Cardiologia",
            nome_medico: "Dr. Lucas Ramos",
            data_agendamento: "2024-07-15",
            hora_agendamento: "10:00",
            observacoes: "Primeira consulta"
        },
        {
            codigo: 2,
            nome_paciente: "João Pereira",
            email_paciente: "joao.pereira@email.com",
            telefone_paciente: "(34) 98888-1111",
            especialidade: "Dermatologia",
            nome_medico: "Dr. Mateu Xauan",
            data_agendamento: "2024-07-16",
            hora_agendamento: "14:30",
            observacoes: "Retorno"
        },
        {
            codigo: 3,
            nome_paciente: "Ana Clara Lima",
            email_paciente: "ana.lima@email.com",
            telefone_paciente: "(34) 97777-2222",
            especialidade: "Ortopedia",
            nome_medico: "Dr. Victor Nogueira",
            data_agendamento: "2024-07-17",
            hora_agendamento: "09:00",
            observacoes: "Dor no joelho"
        }
    ];

    function carregarAgendamentosEstaticos() {
        if (agendamentos.length > 0) {
            let html = "";
            agendamentos.forEach(agendamento => {
                html += `
                    <tr>
                        <td>${agendamento.nome_paciente}</td>
                        <td>${agendamento.email_paciente}</td>
                        <td>${agendamento.telefone_paciente}</td>
                        <td>${agendamento.especialidade}</td>
                        <td>${agendamento.nome_medico}</td>
                        <td>${agendamento.data_agendamento}</td>
                        <td>${agendamento.hora_agendamento}</td>
                        <td>${agendamento.observacoes || ""}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="cancelarAgendamento(${agendamento.codigo})">
                                <i class="fas fa-times-circle"></i> Cancelar
                            </button>
                        </td>
                    </tr>
                `;
            });
            agendamentosTableBody.innerHTML = html;
        } else {
            agendamentosTableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center">Nenhum agendamento encontrado.</td>
                </tr>
            `;
        }
    }

    let agendamentoParaCancelar = null;

    window.cancelarAgendamento = function(codigo) {
        const agendamento = agendamentos.find(a => a.codigo === codigo);
        if (agendamento) {
            agendamentoParaCancelar = agendamento;
            document.getElementById('pacienteParaCancelar').textContent = agendamento.nome_paciente;
            document.getElementById('dataParaCancelar').textContent = agendamento.data_agendamento;
            document.getElementById('horaParaCancelar').textContent = agendamento.hora_agendamento;

            const modal = new bootstrap.Modal(document.getElementById('confirmarCancelamentoModal'));
            modal.show();
        }
    };

    window.confirmarCancelamento = function() {
        if (agendamentoParaCancelar) {
            const index = agendamentos.findIndex(a => a.codigo === agendamentoParaCancelar.codigo);
            if (index !== -1) {
                const nomePaciente = agendamentos[index].nome_paciente;
                agendamentos.splice(index, 1);

                carregarAgendamentosEstaticos();

                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmarCancelamentoModal'));
                modal.hide();

                mostrarAlerta('warning', `O agendamento do(a) paciente "${nomePaciente}" foi cancelado.`);

                agendamentoParaCancelar = null;
            }
        }
    };

    function mostrarAlerta(tipo, mensagem) {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        `;
    }

    carregarAgendamentosEstaticos();
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};