document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const funcionariosTableBody = document.getElementById("funcionarios-table-body");
    const alertContainer = document.getElementById("alert-container");

    // Dados estáticos de exemplo para funcionários
    const funcionarios = [
        {
            codigo: 1,
            nome: "Ana Paula Silva",
            cpf: "111.222.333-44",
            email: "ana.silva@vitacare.com.br",
            telefone: "(34) 98765-4321",
            cargo: "Recepcionista",
            data_contratacao: "2023-01-15"
        },
        {
            codigo: 2,
            nome: "Carlos Eduardo Santos",
            cpf: "555.666.777-88",
            email: "carlos.santos@vitacare.com.br",
            telefone: "(34) 99887-6655",
            cargo: "Enfermeiro",
            data_contratacao: "2022-05-20"
        },
        {
            codigo: 3,
            nome: "Mariana Oliveira",
            cpf: "999.888.777-66",
            email: "mariana.o@vitacare.com.br",
            telefone: "(34) 97777-1111",
            cargo: "Auxiliar Administrativo",
            data_contratacao: "2023-11-01"
        }
    ];

    function carregarFuncionariosEstaticos() {
        if (funcionarios.length > 0) {
            let html = "";
            funcionarios.forEach(func => {
                html += `
                    <tr>
                        <td>${func.nome}</td>
                        <td>${func.cpf}</td>
                        <td>${func.email}</td>
                        <td>${func.telefone}</td>
                        <td>${func.cargo}</td>
                        <td>${func.data_contratacao}</td>
                        <td>
                            <button class="btn btn-sm btn-info mr-1" onclick="editarFuncionario(${func.codigo})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="excluirFuncionario(${func.codigo})">
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
                    <td colspan="7" class="text-center">Nenhum funcionário cadastrado.</td>
                </tr>
            `;
        }
    }
    let funcionarioParaExcluir = null;

    // Função para editar funcionário
    window.editarFuncionario = function(codigo) {
        const funcionario = funcionarios.find(f => f.codigo === codigo);
        if (funcionario) {
            document.getElementById('editCodigo').value = funcionario.codigo;
            document.getElementById('editNome').value = funcionario.nome;
            document.getElementById('editCpf').value = funcionario.cpf;
            document.getElementById('editEmail').value = funcionario.email;
            document.getElementById('editTelefone').value = funcionario.telefone;
            document.getElementById('editCargo').value = funcionario.cargo;
            document.getElementById('editDataContratacao').value = funcionario.data_contratacao;
            
            const modal = new bootstrap.Modal(document.getElementById('editarFuncionarioModal'));
            modal.show();
        }
    };

    // Função para salvar edição
    window.salvarEdicao = function() {
        const codigo = parseInt(document.getElementById('editCodigo').value);
        const nome = document.getElementById('editNome').value;
        const cpf = document.getElementById('editCpf').value;
        const email = document.getElementById('editEmail').value;
        const telefone = document.getElementById('editTelefone').value;
        const cargo = document.getElementById('editCargo').value;
        const dataContratacao = document.getElementById('editDataContratacao').value;

        // Validação básica
        if (!nome || !cpf || !email || !telefone || !cargo || !dataContratacao) {
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        // Encontrar e atualizar o funcionário
        const index = funcionarios.findIndex(f => f.codigo === codigo);
        if (index !== -1) {
            funcionarios[index] = {
                codigo: codigo,
                nome: nome,
                cpf: cpf,
                email: email,
                telefone: telefone,
                cargo: cargo,
                data_contratacao: dataContratacao
            };
            
            // Recarregar tabela
            carregarFuncionariosEstaticos();
            
            // Fechar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editarFuncionarioModal'));
            modal.hide();
            
            // Mostrar mensagem de sucesso
            mostrarAlerta('success', `Funcionário ${nome} atualizado com sucesso!`);
        }
    };

    // Função para excluir funcionário
    window.excluirFuncionario = function(codigo) {
        const funcionario = funcionarios.find(f => f.codigo === codigo);
        if (funcionario) {
            funcionarioParaExcluir = funcionario;
            document.getElementById('nomeParaExcluir').textContent = funcionario.nome;
            document.getElementById('cpfParaExcluir').textContent = funcionario.cpf;
            
            const modal = new bootstrap.Modal(document.getElementById('confirmarExclusaoModal'));
            modal.show();
        }
    };

    // Função para confirmar exclusão
    window.confirmarExclusao = function() {
        if (funcionarioParaExcluir) {
            const index = funcionarios.findIndex(f => f.codigo === funcionarioParaExcluir.codigo);
            if (index !== -1) {
                const nomeFuncionario = funcionarios[index].nome;
                funcionarios.splice(index, 1);
                
                // Recarregar tabela
                carregarFuncionariosEstaticos();
                
                // Fechar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmarExclusaoModal'));
                modal.hide();
                
                // Mostrar mensagem de sucesso
                mostrarAlerta('warning', `Funcionário ${nomeFuncionario} foi removido da lista.`);
                
                funcionarioParaExcluir = null;
            }
        }
    };

    // Carregar funcionários na inicialização
    carregarFuncionariosEstaticos();

    const telefoneInput = document.getElementById('editTelefone');
    if (telefoneInput) {
        aplicarMascaraTelefone(telefoneInput);
    }

    const cpfInput = document.getElementById('editCpf');
    if (cpfInput) {
        aplicarMascaraCPF(cpfInput);
    }

});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};
