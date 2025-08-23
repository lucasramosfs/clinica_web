document.addEventListener("DOMContentLoaded", function() {

    const contatosTableBody = document.getElementById("contatos-table-body");

    // Dados estáticos de exemplo para contatos
    async function carregarContatos() {
        try {
            const response = await fetch("../../../api/listar_contatos.php");
            const result = await response.json();

            if (result.success) {
                const contatos = result.contatos;
                if (contatos.length > 0) {
                    let html = "";
                    contatos.forEach(contato => {
                        html += `
                            <tr>
                                <td>${contato.Nome}</td>
                                <td>${contato.Email}</td>
                                <td>${contato.Telefone}</td>
                                <td>${contato.Mensagem}</td>
                                <td>${VitaCare.formatDateTimeBR(contato.Datahora)}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="excluirContato(${contato.Codigo})">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    contatosTableBody.innerHTML = html;
                } else {
                    contatosTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center">Nenhuma mensagem de contato encontrada.</td>
                        </tr>
                    `;
                }
            } else {
                VitaCare.showToast(`Erro ao carregar contatos: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar contatos:", error);
            VitaCare.showToast("Erro de conexão ao carregar contatos.", "danger");
        }
    }

    let contatoParaExcluir = null;

    window.excluirContato = async function(codigo) {
        contatoParaExcluir = codigo;
        // Buscar dados do contato para exibir no modal
        try {
            const response = await fetch(`../../../api/get_contato.php?codigo=${codigo}`);
            const result = await response.json();
            if (result.success) {
                const contato = result.contato;
                document.getElementById("nomeContatoParaExcluir").textContent = contato.Nome;
                document.getElementById("emailContatoParaExcluir").textContent = contato.Email;
                document.getElementById("dataContatoParaExcluir").textContent = VitaCare.formatDateTimeBR(contato.Datahora);
                const modal = new bootstrap.Modal(document.getElementById("confirmarExclusaoContatoModal"));
                modal.show();
            } else {
                VitaCare.showToast(`Erro ao carregar dados do contato: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar dados do contato:", error);
            VitaCare.showToast("Erro de conexão ao carregar dados do contato.", "danger");
        }
    };

    window.confirmarExclusaoContato = async function() {
        if (contatoParaExcluir) {
            try {
                const response = await fetch("../../../api/excluir_contato.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ codigo: contatoParaExcluir })
                });
                const result = await response.json();

                if (result.success) {
                    VitaCare.showToast(`Contato foi removido da lista.`, "warning");
                    carregarContatos();
                } else {
                    VitaCare.showToast(`Erro ao excluir contato: ${result.error}`, "danger");
                }
            } catch (error) {
                console.error("Erro ao excluir contato:", error);
                VitaCare.showToast("Erro de conexão ao excluir contato.", "danger");
            } finally {
                const modal = bootstrap.Modal.getInstance(document.getElementById("confirmarExclusaoContatoModal"));
                modal.hide();
                contatoParaExcluir = null;
            }
        }
    };

    carregarContatos();
});
