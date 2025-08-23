document.addEventListener("DOMContentLoaded", function() {

    const funcionariosTableBody = document.getElementById("funcionarios-table-body");

    // Dados estáticos de exemplo para funcionários
    async function carregarFuncionarios() {
        try {
            const response = await fetch("../../../api/listar_funcionarios.php");
            const result = await response.json();

            if (result.success) {
                const funcionarios = result.funcionarios;
                if (funcionarios.length > 0) {
                    let html = "";
                    funcionarios.forEach(func => {
                        html += `
                            <tr>
                                <td>${func.Nome}</td>
                                <td>${func.Email}</td>
                                <td>${func.EstadoCivil}</td>
                                <td>${func.DataNascimento}</td>
                                <td>${func.Funcao}</td>
                                <td>
                                    <button class="btn btn-sm btn-info mr-1" onclick="editarFuncionario(${func.Codigo})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="excluirFuncionario(${func.Codigo})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    funcionariosTableBody.innerHTML = html;
                } else {
                    funcionariosTableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center">Nenhum funcionário cadastrado.</td>
                        </tr>
                    `;
                }
            } else {
                VitaCare.showToast(`Erro ao carregar funcionários: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar funcionários:", error);
            VitaCare.showToast(`Erro de conexão ao carregar funcionários.`, "danger");
        }
    }

    let funcionarioParaExcluir = null;

    // Função para editar funcionário
    window.editarFuncionario = async function(codigo) {
        try {
            const response = await fetch(`../../../api/get_funcionario.php?codigo=${codigo}`);
            const result = await response.json();

            if (result.success) {
                const funcionario = result.funcionario;
                document.getElementById("editCodigo").value = funcionario.Codigo;
                document.getElementById("editNome").value = funcionario.Nome;
                document.getElementById("editEmail").value = funcionario.Email;
                document.getElementById("editSenha").value = '';
                document.getElementById("editEstadoCivil").value = funcionario.EstadoCivil;
                document.getElementById("editDataNascimento").value = funcionario.DataNascimento;
                document.getElementById("editFuncao").value = funcionario.Funcao;
                
                const modal = new bootstrap.Modal(document.getElementById("editarFuncionarioModal"));
                modal.show();
            } else {
                VitaCare.showToast(`Erro ao carregar dados do funcionário: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao buscar dados do funcionário:", error);
            VitaCare.showToast("Erro de conexão ao carregar dados do funcionário.", "danger");
        }
    };

    // Função para salvar edição
    window.salvarEdicao = async function() {
        const codigo = document.getElementById("editCodigo").value;
        const nome = document.getElementById("editNome").value;
        const email = document.getElementById("editEmail").value;
        const senha = document.getElementById("editSenha").value; // pegar a senha
        const estadoCivil = document.getElementById("editEstadoCivil").value;
        const dataNascimento = document.getElementById("editDataNascimento").value;
        const funcao = document.getElementById("editFuncao").value;

        if (!nome || !email || !funcao || !estadoCivil || !dataNascimento) {
            VitaCare.showToast("Por favor, preencha todos os campos obrigatórios.", "info");
            return;
        }

        const bodyData = { codigo, nome, email, funcao, estadoCivil, dataNascimento };

        // Só enviar a senha se tiver conteúdo
        if (senha && senha.trim() !== "") {
            bodyData.senha = senha;
        }

        try {
            const response = await fetch("../../../api/editar_funcionario.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(bodyData)
            });
            const result = await response.json();

            if (result.success) {
                VitaCare.showToast(`Funcionário ${nome} atualizado com sucesso!`, "success");
                carregarFuncionarios();
                const modal = bootstrap.Modal.getInstance(document.getElementById("editarFuncionarioModal"));
                modal.hide();
            } else {
                VitaCare.showToast(`Erro ao atualizar funcionário: ${result.error}`, "danger");
            }
        } catch (error) {
            console.error("Erro ao atualizar funcionário:", error);
            VitaCare.showToast("Erro de conexão ao atualizar funcionário.", "danger");
        }
    };

    // Função para excluir funcionário
    window.excluirFuncionario = async function(codigo) {
        funcionarioParaExcluir = codigo;
        const funcionarioNome = document.querySelector(`#funcionarios-table-body tr button[onclick="excluirFuncionario(${codigo})"]`).closest("tr").querySelector("td").textContent;
        document.getElementById("nomeParaExcluir").textContent = funcionarioNome;
        
        const modal = new bootstrap.Modal(document.getElementById("confirmarExclusaoModal"));
        modal.show();
    };

    // Função para confirmar exclusão
    window.confirmarExclusao = async function() {
        if (funcionarioParaExcluir) {
            try {
                const response = await fetch("../../../api/excluir_funcionario.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ codigo: funcionarioParaExcluir })
                });
                const result = await response.json();

                if (result.success) {
                    VitaCare.showToast(`Funcionário foi removido da lista.`, "info");
                    carregarFuncionarios();
                } else {
                    VitaCare.showToast(`Erro ao excluir funcionário: ${result.error}`, "danger");
                }
            } catch (error) {
                console.error("Erro ao excluir funcionário:", error);
                VitaCare.showToast("Erro de conexão ao excluir funcionário.", "danger");
            } finally {
                const modal = bootstrap.Modal.getInstance(document.getElementById("confirmarExclusaoModal"));
                modal.hide();
                funcionarioParaExcluir = null;
            }
        }
    };

    carregarFuncionarios();
});

