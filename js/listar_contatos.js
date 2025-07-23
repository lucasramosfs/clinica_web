document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const contatosTableBody = document.getElementById("contatos-table-body");
    const alertContainer = document.getElementById("alert-container");

    // Dados estáticos de exemplo para contatos
    const contatos = [
        {
            codigo: 1,
            nome: "Fulano de Tal",
            email: "fulano@example.com",
            telefone: "(34) 91111-2222",
            assunto: "Dúvida sobre agendamento",
            mensagem: "Gostaria de saber se é possível agendar uma consulta para o próximo sábado.",
            data_envio: "2024-07-10 10:30:00"
        },
        {
            codigo: 2,
            nome: "Ciclana da Silva",
            email: "ciclana@example.com",
            telefone: "(34) 93333-4444",
            assunto: "Sugestão de melhoria",
            mensagem: "Achei o site muito bom, mas seria interessante ter um chat online para dúvidas rápidas.",
            data_envio: "2024-07-09 15:00:00"
        },
        {
            codigo: 3,
            nome: "Beltrano Souza",
            email: "beltrano@example.com",
            telefone: "(34) 95555-6666",
            assunto: "Reclamação sobre atendimento",
            mensagem: "Tive um problema com o agendamento e não consegui contato por telefone.",
            data_envio: "2024-07-08 09:00:00"
        }
    ];

    function carregarContatosEstaticos() {
        if (contatos.length > 0) {
            let html = "";
            contatos.forEach(contato => {
                html += `
                    <tr>
                        <td>${contato.nome}</td>
                        <td>${contato.email}</td>
                        <td>${contato.telefone}</td>
                        <td>${contato.assunto}</td>
                        <td>${contato.mensagem}</td>
                        <td>${contato.data_envio}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="excluirContato(${contato.codigo})">
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
    }

    // Função de exemplo para excluir contato (simulada)
    window.excluirContato = function(codigo) {
        if (confirm(`Simulação: Tem certeza que deseja excluir a mensagem de contato com código: ${codigo}?`)) {
            alert(`Simulação: Mensagem de contato ${codigo} excluída.`);
        }
    };

    carregarContatosEstaticos();
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};