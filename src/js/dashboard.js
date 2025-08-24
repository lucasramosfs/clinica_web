document.addEventListener('DOMContentLoaded', function() {

    // Atualizar data/hora atual
    function atualizarDataHora() {
        const agora = new Date();
        const dataHora = agora.toLocaleString('pt-BR');
        const elementoDataHora = document.getElementById('dataHoraAtual');
        if (elementoDataHora) {
            elementoDataHora.textContent = dataHora;
        }
    }
    
    atualizarDataHora();
    setInterval(atualizarDataHora, 1000);
    // Atualizar último acesso
    document.getElementById("ultimo-acesso").textContent = new Date().toLocaleString("pt-BR");
    

    carregarEstatisticas();
    carregarAgendamentosRecentes();

});
// Carregar estatísticas
async function carregarEstatisticas() {
    try {
        const response = await fetch("../../../api/estatisticas.php");
        const result = await response.json();
        
        if (result.success) {
            const stats = result.estatisticas;
            
            // Atualizar números
            animarNumero(document.querySelector(".stat-card.funcionarios .stat-number"), stats.total_funcionarios);
            animarNumero(document.querySelector(".stat-card.medicos .stat-number"), stats.total_medicos);
            animarNumero(document.querySelector(".stat-card.agendamentos .stat-number"), stats.total_agendamentos);
            animarNumero(document.querySelector(".stat-card.contatos .stat-number"), stats.total_contatos);
            animarNumero(document.querySelector(".stat-card.hoje .stat-number"), stats.agendamentos_hoje);
            animarNumero(document.querySelector(".stat-card.especialidades .stat-number"), stats.especialidades);
            
            // // Atualizar especialidades populares
            const especialidadesContainer = document.getElementById("especialidades-populares");
            if (stats.especialidades_populares && stats.especialidades_populares.length > 0) {
                let html = "";
                stats.especialidades_populares.forEach((esp, index) => {
                    const percentage = index === 0 ? 100 : Math.round((esp.total_agendamentos / stats.especialidades_populares[0].total_agendamentos) * 100);
                    html += `
                        <div class="mb-3">
                            <div class="especialidade-item">
                                <span>${esp.Especialidade}</span>
                                <span class="badge badge-primary" style="color: #000;">${esp.total_agendamentos}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                    `;
                });
                especialidadesContainer.innerHTML = html;
            } else {
                especialidadesContainer.innerHTML = 
                    `<p class="text-muted">Nenhum dado disponível</p>`;
            }
        }
    } catch (error) {
        console.error("Erro ao carregar estatísticas:", error);
    }
}

function animarNumero(elemento, valorFinal) {
    const duracao = 1000; 
    const intervalo = 60; 
    const passos = duracao / intervalo;
    const incremento = valorFinal / passos;

    let valorAtual = 0;

    const timer = setInterval(() => {
        valorAtual += incremento;
        if (valorAtual >= valorFinal) {
            elemento.textContent = valorFinal;
            clearInterval(timer);
        } else {
            elemento.textContent = Math.floor(valorAtual);
        }
    }, intervalo);
}
// Carregar agendamentos recentes
async function carregarAgendamentosRecentes() {
    try {
        const response = await fetch("../../../api/listar_agendamentos.php");
        const result = await response.json();
        
        if (result.success) {
            const agendamentos = result.agendamentos.slice(0, 5); // Últimos 5
            const container = document.getElementById("agendamentos-recentes");
            
            if (agendamentos.length > 0) {
                let html = 
                    `<div class="list-group list-group-flush">`;
                agendamentos.forEach(agendamento => {
                    const data = new Date(agendamento.Datahora).toLocaleString("pt-BR");
                    html += `
                        <div class="list-group-item">
                            <div class="list-group-item-content">
                                <h6 class="mb-1">${agendamento.NomePaciente}</h6>
                                <small>${data}</small>
                            </div>
                            <p class="mb-1">${agendamento.NomeMedico} - ${agendamento.Especialidade}</p>
                            <small class="text-muted">${agendamento.EmailPaciente}</small>
                        </div>
                    `;
                });
                html += `</div>`;
                container.innerHTML = html;
            } else {
                container.innerHTML = 
                    `<p class="text-muted">Nenhum agendamento encontrado</p>`;
            }
        }
    } catch (error) {
        console.error("Erro ao carregar agendamentos:", error);
        document.getElementById("agendamentos-recentes").innerHTML = 
            `<p class="text-danger">Erro ao carregar dados</p>`;
    }
}
