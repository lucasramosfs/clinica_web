// document.addEventListener('DOMContentLoaded', () => {

//     const especialidadeSelect = document.getElementById('especialidade');
//     const medicoSelect = document.getElementById('medico');

//     // Função para carregar especialidades via AJAX
//     function carregarEspecialidades() {
//         fetch('../../../api/especialidades.php')
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     // Limpa opções anteriores
//                     especialidadeSelect.innerHTML = '<option value="" disabled selected>Selecione uma especialidade médica</option>';
//                     data.especialidades.forEach(esp => {
//                         const option = document.createElement('option');
//                         option.value = esp;
//                         option.textContent = esp;
//                         especialidadeSelect.appendChild(option);
//                     });
//                 } else {
//                     especialidadeSelect.innerHTML = '<option value="">Erro ao carregar especialidades</option>';
//                 }
//             })
//             .catch(err => {
//                 console.error('Erro ao carregar especialidades:', err);
//                 especialidadeSelect.innerHTML = '<option value="">Erro ao carregar especialidades</option>';
//             });
//     }

//     // Função para carregar médicos via AJAX
//     function carregarMedicos(especialidade) {
//         medicoSelect.innerHTML = '<option value="" disabled selected>Carregando médicos...</option>';
//         fetch(`../../../api/medicos_por_especialidade.php?especialidade=${encodeURIComponent(especialidade)}`)
//             .then(response => response.json())
//             .then(data => {
//                 medicoSelect.innerHTML = '';
//                 if (data.success && data.medicos.length > 0) {
//                     medicoSelect.innerHTML = '<option value="" disabled selected>Selecione um médico</option>';
//                     data.medicos.forEach(medico => {
//                         const option = document.createElement('option');
//                         option.value = medico.Codigo;
//                         option.textContent = medico.Nome;
//                         medicoSelect.appendChild(option);
//                     });
//                 } else {
//                     medicoSelect.innerHTML = '<option value="" disabled selected>Nenhum médico encontrado</option>';
//                 }
//             })
//             .catch(err => {
//                 console.error('Erro ao carregar médicos:', err);
//                 medicoSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar médicos</option>';
//             });
//     }

//     // Evento de mudança da especialidade
//     if (especialidadeSelect) {
//         especialidadeSelect.addEventListener('change', () => {
//             const selectedEsp = especialidadeSelect.value;
//             if (selectedEsp) {
//                 carregarMedicos(selectedEsp);
//             } else {
//                 medicoSelect.innerHTML = '<option value="" disabled selected>Selecione uma especialidade primeiro</option>';
//             }
//         });
//     }

//     const telefoneInput = document.querySelector('[type="tel"]');
//     if (telefoneInput) {
//         aplicarMascaraTelefone(telefoneInput);
//     }


//     // Inicializar carregamento de especialidades
//     if (especialidadeSelect) {
//         carregarEspecialidades();
//     }

//     const form = document.getElementById('agendamentoForm');

//     form.addEventListener('submit', async (e) => {
//         e.preventDefault();

//         const formData = new FormData(form);

//         // Combina data + hora em datahora
//         const data = formData.get('data');
//         const hora = formData.get('hora');
//         const dataHoraString = `${data} ${hora}:00`;
//         formData.set('datahora', dataHoraString);

//         // Verifica se a data e hora são superiores à atual
//         const dataHoraAgendamento = new Date(dataHoraString);
//         const dataHoraAtual = new Date();

//         if (dataHoraAgendamento <= dataHoraAtual) {
//             VitaCare.showToast("A data e hora do agendamento devem ser superiores à data e hora atual.", "danger");
//             return; // Interrompe a execução
//         }

//         try {
//             const response = await fetch('../../../api/agendar_consulta.php', {
//                 method: 'POST',
//                 body: formData
//             });

//             const result = await response.json();

//             if (response.ok && result.success) {
//                 VitaCare.showToast(result.message, "success");
//                 form.reset(); // limpa formulário
//             } else {
//                 VitaCare.showToast(`${result.error || 'Erro desconhecido'}`, "danger");
//             }

//         } catch (error) {
//             VitaCare.showToast(`Erro na requisição: ${error.message}`, "danger");
//         }
//     });

// });

document.addEventListener('DOMContentLoaded', () => {

    const especialidadeSelect = document.getElementById('especialidade');
    const medicoSelect = document.getElementById('medico');
    const dataInput = document.getElementById('data');
    const horaSelect = document.getElementById('hora');

    // Horários padrão de funcionamento (você pode ajustar conforme necessário)
    const horariosDisponiveis = [
        '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
        '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
    ];

    // Função para carregar especialidades via AJAX
    function carregarEspecialidades() {
        fetch('../../../api/especialidades.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Limpa opções anteriores
                    especialidadeSelect.innerHTML = '<option value="" disabled selected>Selecione uma especialidade médica</option>';
                    data.especialidades.forEach(esp => {
                        const option = document.createElement('option');
                        option.value = esp;
                        option.textContent = esp;
                        especialidadeSelect.appendChild(option);
                    });
                } else {
                    especialidadeSelect.innerHTML = '<option value="">Erro ao carregar especialidades</option>';
                }
            })
            .catch(err => {
                console.error('Erro ao carregar especialidades:', err);
                especialidadeSelect.innerHTML = '<option value="">Erro ao carregar especialidades</option>';
            });
    }

    // Função para carregar médicos via AJAX
    function carregarMedicos(especialidade) {
        medicoSelect.innerHTML = '<option value="" disabled selected>Carregando médicos...</option>';
        fetch(`../../../api/medicos_por_especialidade.php?especialidade=${encodeURIComponent(especialidade)}`)
            .then(response => response.json())
            .then(data => {
                medicoSelect.innerHTML = '';
                if (data.success && data.medicos.length > 0) {
                    medicoSelect.innerHTML = '<option value="" disabled selected>Selecione um médico</option>';
                    data.medicos.forEach(medico => {
                        const option = document.createElement('option');
                        option.value = medico.Codigo;
                        option.textContent = medico.Nome;
                        medicoSelect.appendChild(option);
                    });
                } else {
                    medicoSelect.innerHTML = '<option value="" disabled selected>Nenhum médico encontrado</option>';
                }
            })
            .catch(err => {
                console.error('Erro ao carregar médicos:', err);
                medicoSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar médicos</option>';
            });
    }

    // Função para carregar horários disponíveis baseado no médico e data selecionados
    function carregarHorariosDisponiveis() {
        const codigoMedico = medicoSelect.value;
        const dataSelecionada = dataInput.value;

        // Reset do select de horas
        horaSelect.innerHTML = '<option value="" disabled selected>Selecione um horário</option>';

        if (!codigoMedico || !dataSelecionada) {
            horaSelect.innerHTML = '<option value="" disabled selected>Selecione médico e data primeiro</option>';
            return;
        }

        // Verificar se a data não é no passado
        const hoje = new Date();
        hoje.setHours(0, 0, 0, 0);
        const dataEscolhida = new Date(dataSelecionada + 'T00:00:00');

        if (dataEscolhida < hoje) {
            horaSelect.innerHTML = '<option value="" disabled selected>Data deve ser futura</option>';
            return;
        }

        horaSelect.innerHTML = '<option value="" disabled selected>Carregando horários...</option>';

        // Buscar horários ocupados
        fetch(`../../../api/horarios_ocupados.php?medico=${codigoMedico}&data=${dataSelecionada}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const horariosOcupados = data.horarios_ocupados || [];
                    
                    // Filtrar horários disponíveis
                    const horariosLivres = horariosDisponiveis.filter(horario => {
                        return !horariosOcupados.includes(horario);
                    });

                    horaSelect.innerHTML = '';

                    if (horariosLivres.length > 0) {
                        horaSelect.innerHTML = '<option value="" disabled selected>Selecione um horário</option>';
                        horariosLivres.forEach(horario => {
                            const option = document.createElement('option');
                            option.value = horario;
                            option.textContent = horario;
                            horaSelect.appendChild(option);
                        });
                    } else {
                        horaSelect.innerHTML = '<option value="" disabled selected>Nenhum horário disponível nesta data</option>';
                    }

                    console.log(`Horários ocupados para ${dataSelecionada}:`, horariosOcupados);
                    console.log(`Horários livres:`, horariosLivres);
                } else {
                    console.error('Erro ao carregar horários ocupados:', data.error);
                    horaSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar horários</option>';
                }
            })
            .catch(err => {
                console.error('Erro ao carregar horários ocupados:', err);
                horaSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar horários</option>';
            });
    }

    // Evento de mudança da especialidade
    if (especialidadeSelect) {
        especialidadeSelect.addEventListener('change', () => {
            const selectedEsp = especialidadeSelect.value;
            if (selectedEsp) {
                carregarMedicos(selectedEsp);
            } else {
                medicoSelect.innerHTML = '<option value="" disabled selected>Selecione uma especialidade primeiro</option>';
            }
            // Reset horários quando especialidade muda
            horaSelect.innerHTML = '<option value="" disabled selected>Selecione médico e data primeiro</option>';
        });
    }

    // Evento de mudança do médico
    if (medicoSelect) {
        medicoSelect.addEventListener('change', () => {
            carregarHorariosDisponiveis();
        });
    }

    // Evento de mudança da data
    if (dataInput) {
        dataInput.addEventListener('change', () => {
            carregarHorariosDisponiveis();
        });
    }

    const telefoneInput = document.querySelector('[type="tel"]');
    if (telefoneInput) {
        aplicarMascaraTelefone(telefoneInput);
    }

    // Inicializar carregamento de especialidades
    if (especialidadeSelect) {
        carregarEspecialidades();
    }

    const form = document.getElementById('agendamentoForm');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        // Combina data + hora em datahora
        const data = formData.get('data');
        const hora = formData.get('hora');
        const dataHoraString = `${data} ${hora}:00`;
        formData.set('datahora', dataHoraString);

        // Verifica se a data e hora são superiores à atual
        const dataHoraAgendamento = new Date(dataHoraString);
        const dataHoraAtual = new Date();

        if (dataHoraAgendamento <= dataHoraAtual) {
            VitaCare.showToast("A data e hora do agendamento devem ser superiores à data e hora atual.", "danger");
            return; // Interrompe a execução
        }

        try {
            const response = await fetch('../../../api/agendar_consulta.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.success) {
                VitaCare.showToast(result.message, "success");
                form.reset(); // limpa formulário
                
                // Reset dos selects após sucesso
                medicoSelect.innerHTML = '<option value="" disabled selected>Selecione uma especialidade primeiro</option>';
                horaSelect.innerHTML = '<option value="" disabled selected>Selecione médico e data primeiro</option>';
            } else {
                VitaCare.showToast(`${result.error || 'Erro desconhecido'}`, "danger");
            }

        } catch (error) {
            VitaCare.showToast(`Erro na requisição: ${error.message}`, "danger");
        }
    });

});