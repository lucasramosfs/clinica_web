document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const agendamentosTableBody = document.getElementById("agendamentos-table-body");

    // Dados estáticos de exemplo para agendamentos
    async function carregarAgendamentos() {
        try {
            const response = await fetch("../../../api/listar_agendamentos.php");
            const result = await response.json();

            if (result.success) {
                const agendamentos = result.agendamentos;
                if (agendamentos.length > 0) {
                    let html = "";
                    agendamentos.forEach(agendamento => {
                        html += `
                            <tr>
                                <td>${agendamento.NomePaciente}</td>
                                <td>${agendamento.EmailPaciente}</td>
                                <td>${agendamento.TelefonePaciente}</td>
                                <td>${agendamento.Especialidade}</td>
                                <td>${agendamento.NomeMedico}</td>
                                <td>${VitaCare.formatDateBR(agendamento.Datahora)}</td>
                                <td>${new Date(agendamento.Datahora).toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" })}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="cancelarAgendamento(${agendamento.Codigo})">
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
            } else {
                VitaCare.showToast(`Erro ao carregar agendamentos: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar agendamentos:", error);
            VitaCare.showToast("Erro de conexão ao carregar agendamentos.", "danger");
        }
    }

    let agendamentoParaCancelar = null;

    window.cancelarAgendamento = async function(codigo) {
        agendamentoParaCancelar = codigo;
        // Buscar dados do agendamento para exibir no modal
        try {
            const response = await fetch(`../../../api/get_agendamento.php?codigo=${codigo}`);
            const result = await response.json();
            if (result.success) {
                const agendamento = result.agendamento;
                document.getElementById("pacienteParaCancelar").textContent = agendamento.NomePaciente;
                document.getElementById("dataParaCancelar").textContent = VitaCare.formatDateBR(agendamento.Datahora);
                document.getElementById("horaParaCancelar").textContent = new Date(agendamento.Datahora).toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" });
                const modal = new bootstrap.Modal(document.getElementById("confirmarCancelamentoModal"));
                modal.show();
            } else {
                VitaCare.showToast(`Erro ao carregar dados do agendamento: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar dados do agendamento:", error);
            VitaCare.showToast("Erro de conexão ao carregar dados do agendamento.", "danger");
        }
    };

    window.confirmarCancelamento = async function() {
        if (agendamentoParaCancelar) {
            try {
                const response = await fetch("../../../api/cancelar_agendamento.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ codigo: agendamentoParaCancelar })
                });
                const result = await response.json();

                if (result.success) {
                    VitaCare.showToast(`O agendamento foi cancelado.`, "info");
                    carregarAgendamentos();
                } else {
                    VitaCare.showToast(`Erro ao cancelar agendamento: ${result.error}`, "danger");
                }
            } catch (error) {
                console.error("Erro ao cancelar agendamento:", error);
                VitaCare.showToast("Erro de conexão ao cancelar agendamento.", "danger");
            } finally {
                const modal = bootstrap.Modal.getInstance(document.getElementById("confirmarCancelamentoModal"));
                modal.hide();
                agendamentoParaCancelar = null;
            }
        }
    };

    carregarAgendamentos();
});

// // Função de logout (simulada)
// const VitaCare = {
//     logout: function() {
//         window.location.href = "../public/login.html";
//     }
// };