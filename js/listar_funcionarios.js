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

    // Funções de exemplo para editar e excluir (simuladas)
    window.editarFuncionario = function(codigo) {
        alert(`Simulação: Editar funcionário com código: ${codigo}`);
    };

    window.excluirFuncionario = function(codigo) {
        if (confirm(`Simulação: Tem certeza que deseja excluir o funcionário com código: ${codigo}?`)) {
            alert(`Simulação: Excluir funcionário com código: ${codigo}`);
        }
    };

    carregarFuncionariosEstaticos();
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};