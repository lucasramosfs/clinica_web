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

    // Funções de exemplo para editar e excluir (simuladas)
    window.editarMedico = function(codigo) {
        alert(`Simulação: Editar médico com código: ${codigo}`);
    };

    window.excluirMedico = function(codigo) {
        if (confirm(`Simulação: Tem certeza que deseja excluir o médico com código: ${codigo}?`)) {
            alert(`Simulação: Excluir médico com código: ${codigo}`);
        }
    };

    carregarMedicosEstaticos();
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};