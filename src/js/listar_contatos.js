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

    let contatoParaExcluir = null;

    window.excluirContato = function(codigo) {
        const contato = contatos.find(c => c.codigo === codigo);
        if (contato) {
            contatoParaExcluir = contato;
            document.getElementById('nomeContatoParaExcluir').textContent = contato.nome;
            document.getElementById('emailContatoParaExcluir').textContent = contato.email;

            const modal = new bootstrap.Modal(document.getElementById('confirmarExclusaoContatoModal'));
            modal.show();
        }
    };

    window.confirmarExclusaoContato = function() {
        if (contatoParaExcluir) {
            const index = contatos.findIndex(c => c.codigo === contatoParaExcluir.codigo);
            if (index !== -1) {
                const nomeContato = contatos[index].nome;
                contatos.splice(index, 1);

                carregarContatosEstaticos();

                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmarExclusaoContatoModal'));
                modal.hide();

                mostrarAlerta('warning', `Contato "${nomeContato}" foi removido da lista.`);

                contatoParaExcluir = null;
            }
        }
    };

    // Alerta simples reaproveitável
    function mostrarAlerta(tipo, mensagem) {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        `;
    }

    carregarContatosEstaticos();
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};