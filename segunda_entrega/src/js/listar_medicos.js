document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const medicosTableBody = document.getElementById("medicos-table-body");

    // Dados estáticos de exemplo para médicos


    async function carregarMedicos() {
        try {
            const response = await fetch("../../../api/listar_medicos.php");
            const result = await response.json();

            if (result.success) {
                const medicos = result.medicos;
                if (medicos.length > 0) {
                    let html = "";
                    medicos.forEach(med => {
                        html += `
                            <tr>
                                <td>${med.Nome}</td>
                                <td>${med.CRM}</td>
                                <td>${med.Especialidade}</td>
                                <td>${med.Email}</td>
                                <td>${med.Telefone}</td>
                                <td>
                                    <button class="btn btn-sm btn-info mr-1" onclick="editarMedico(${med.Codigo})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="excluirMedico(${med.Codigo})">
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
            } else {
                VitaCare.showToast(`Erro ao carregar médicos: ${result.error}`, "danger");

            }
        } catch (error) {
            console.error("Erro ao buscar médicos:", error);
            VitaCare.showToast(`Erro de conexão ao carregar médicos.`, "danger");
        }
    }

    let medicoParaExcluir = null;

    // Função para editar médico
    window.editarMedico = async function(codigo) {
        try {
            const response = await fetch(`../../../api/get_medico.php?codigo=${codigo}`);
            const result = await response.json();

            if (result.success) {
                const medico = result.medico;
                document.getElementById("editCodigo").value = medico.Codigo;
                document.getElementById("editNome").value = medico.Nome;
                document.getElementById("editCrm").value = medico.CRM;
                document.getElementById("editEspecialidade").value = medico.Especialidade;
                document.getElementById("editEmail").value = medico.Email;
                document.getElementById("editTelefone").value = medico.Telefone;
                
                const modal = new bootstrap.Modal(document.getElementById("editarMedicoModal"));
                modal.show();
            } else {
                VitaCare.showToast(`Erro ao carregar dados do médico: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar dados do médico:", error);
            VitaCare.showToast("Erro de conexão ao carregar dados do médico.", "danger");
        }
    };

    // Função para salvar edição
    window.salvarEdicao = async function() {
        const codigo = document.getElementById("editCodigo").value;
        const nome = document.getElementById("editNome").value;
        const crm = document.getElementById("editCrm").value;
        const especialidade = document.getElementById("editEspecialidade").value;
        const email = document.getElementById("editEmail").value;
        const telefone = document.getElementById("editTelefone").value;

        // Validação básica
        if (!nome || !crm || !especialidade || !email || !telefone) {
            VitaCare.showToast("Por favor, preencha todos os campos obrigatórios.", "danger");
            return;
        }

        // Validação do formato do CRM
        if (!crm.match(/^[A-Z]{2}\d{4,6}$/)) {
            VitaCare.showToast("CRM deve seguir o formato: UF + números (ex: MG123456)", "danger");
            return;
        }

        try {
            const response = await fetch("../api/editar_medico.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ codigo: codigo, nome: nome, crm: crm, especialidade: especialidade, email: email, telefone: telefone })
            });
            const result = await response.json();

            if (result.success) {
                VitaCare.showToast(`Médico foi atualizado com sucesso!`, "success");
                carregarMedicos();
                const modal = bootstrap.Modal.getInstance(document.getElementById("editarMedicoModal"));
                modal.hide();
            } else {
                VitaCare.showToast(`Erro ao atualizar médico: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao atualizar médico:", error);
            VitaCare.showToast("Erro de conexão ao atualizar médico.", "danger");
        }
    };

    // Função para excluir médico
    window.excluirMedico = async function(codigo) {
        medicoParaExcluir = codigo;
        const medicoNome = document.querySelector(`#medicos-table-body tr button[onclick="excluirMedico(${codigo})"]`).closest("tr").querySelector("td").textContent;
        document.getElementById("nomeParaExcluir").textContent = medicoNome;
        
        const modal = new bootstrap.Modal(document.getElementById("confirmarExclusaoModal"));
        modal.show();
    };

    // Função para confirmar exclusão
    window.confirmarExclusao = async function() {
        if (medicoParaExcluir) {
            try {
                const response = await fetch("../../../api/excluir_medico.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ codigo: medicoParaExcluir })
                });
                const result = await response.json();

                if (result.success) {
                    VitaCare.showToast("Médico foi removido da lista.", "warning");
                    carregarMedicos();
                } else {
                   VitaCare.showToast(`Erro ao excluir médico: ${result.error}`, "danger");
                }
            } catch (error) {
                console.error("Erro ao excluir médico:", error);
                VitaCare.showToast("Erro de conexão ao excluir médico.", "danger");
            } finally {
                const modal = bootstrap.Modal.getInstance(document.getElementById("confirmarExclusaoModal"));
                modal.hide();
                medicoParaExcluir = null;
            }
        };
    }
});