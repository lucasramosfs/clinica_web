<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria - VitaCare Clínica Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/galeria.css">
    <link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="../../../index.html" class="logo">
                <i class="fas fa-heartbeat"></i> VitaCare
            </a>
            <div class="header-info">
                <span><i class="fas fa-phone"></i> (34) 3333-4444</span>
                <span class="ms-3"><i class="fas fa-envelope"></i> contato@vitacare.com.br</span>
            </div>
        </div>
    </header>

    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="../../../index.html">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./galeria.php">
                            <i class="fas fa-images"></i> Galeria
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./agendamento.html">
                            <i class="fas fa-calendar-plus"></i> Agendar Consulta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contato.html">
                            <i class="fas fa-envelope"></i> Contato
                        </a>
                    </li>
                </ul>

                <a href="./login.html" class="btn btn-login ms-auto">
                    <i class="fas fa-sign-in-alt"></i> Área Restrita
                </a>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h1 class="display-4 fade-in-up">Nossa Galeria</h1>
                    <p class="lead fade-in-up">Conheça nossas instalações modernas e equipamentos de última geração</p>
                </div>
            </div>

            <!-- Filtros -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" data-filter="all">
                            <i class="fas fa-th"></i> Todas
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="instalacoes">
                            <i class="fas fa-building"></i> Instalações
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="equipamentos">
                            <i class="fas fa-stethoscope"></i> Equipamentos
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="equipe">
                            <i class="fas fa-user-md"></i> Equipe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Galeria de Imagens -->
            <div class="row" id="gallery">
                <!-- Instalações -->
                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="instalacoes">
                    <div class="gallery-item">
                        <img src="../../img/clinica1.jpg" alt="Recepção VitaCare" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="text-center">
                                <h5>Recepção Principal</h5>
                                <p>Ambiente acolhedor e moderno para receber nossos pacientes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="instalacoes">
                    <div class="gallery-item">
                        <img src="../../img/clinica2.jpg" alt="Sala de Espera" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="text-center">
                                <h5>Sala de Espera</h5>
                                <p>Espaço confortável com design contemporâneo</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="instalacoes">
                    <div class="gallery-item">
                        <img src="../../img/clinica3.jpg" alt="Consultório Médico" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="text-center">
                                <h5>Consultório Médico</h5>
                                <p>Consultórios equipados com tecnologia de ponta</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="instalacoes">
                    <div class="gallery-item">
                        <img src="../../img/clinica4.jpg" alt="Área de Atendimento" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="text-center">
                                <h5>Área de Atendimento</h5>
                                <p>Espaços amplos e bem iluminados</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipamentos (usando ícones como placeholder) -->
                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="equipamentos">
                    <div class="card text-center h-100">
                        <div class="card-body text-center h-100 gallery-card-content">
                            <i class="fas fa-x-ray fa-5x text-primary mb-3"></i>
                            <h5 class="card-title">Raio-X Digital</h5>
                            <p class="card-text">Equipamento de última geração para diagnósticos precisos</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="equipamentos">
                    <div class="card text-center h-100">
                        <div class="card-body text-center h-100 gallery-card-content">
                            <i class="fas fa-heartbeat fa-5x text-danger mb-3"></i>
                            <h5 class="card-title">Eletrocardiograma</h5>
                            <p class="card-text">Monitoramento cardíaco avançado</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="equipamentos">
                    <div class="card text-center h-100">
                        <div class="card-body text-center h-100 gallery-card-content">
                            <i class="fas fa-microscope fa-5x text-success mb-3"></i>
                            <h5 class="card-title">Laboratório</h5>
                            <p class="card-text">Análises clínicas com precisão e agilidade</p>
                        </div>
                    </div>
                </div>
                
                <!-- Equipe (usando ícones como placeholder) -->
                <?php
                require_once '../../../includes/config.php'; // conexão $pdo

                try {
                    // Buscar médicos
                    $stmt = $pdo->query("SELECT nome, especialidade, crm FROM Medico");
                    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die("Erro ao buscar médicos: " . $e->getMessage());
                }

                // Possíveis cores/ícones para alternar
                $cores = ["info", "warning", "secondary", "success", "danger", "primary"];
                $icones = ["fa-user-md", "fa-stethoscope", "fa-heartbeat", "fa-notes-medical", "fa-briefcase-medical", "fa-clinic-medical"];

                foreach ($medicos as $index => $medico):
                    $cor = $cores[$index % count($cores)];
                    $icone = $icones[$index % count($icones)];
                ?>
                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="equipe">
                        <div class="card text-center h-100">
                            <div class="card-body text-center h-100 gallery-card-content">
                                <i class="fas <?= $icone ?> fa-5x text-<?= $cor ?> mb-3"></i>
                                <h5 class="card-title"><?= htmlspecialchars($medico['nome']) ?></h5>
                                <p class="card-text">
                                    <?= htmlspecialchars($medico['especialidade']) ?> - CRM <?= htmlspecialchars($medico['crm']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <!-- Certificações e Acreditações -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center mb-4">Certificações e Acreditações</h3>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="text-center">
                        <i class="fas fa-certificate fa-3x text-warning mb-2"></i>
                        <h6>ISO 9001</h6>
                        <small>Gestão da Qualidade</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="text-center">
                        <i class="fas fa-award fa-3x text-success mb-2"></i>
                        <h6>ANVISA</h6>
                        <small>Licença Sanitária</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="text-center">
                        <i class="fas fa-shield-alt fa-3x text-primary mb-2"></i>
                        <h6>CRM-MG</h6>
                        <small>Conselho Regional</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="text-center">
                        <i class="fas fa-star fa-3x text-info mb-2"></i>
                        <h6>ONA</h6>
                        <small>Acreditação Hospitalar</small>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-heartbeat"></i> VitaCare</h5>
                    <p>Cuidando da sua saúde com excelência, tecnologia e humanização. Sua vida é nossa prioridade.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contato</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Av. João Naves de Ávila, 2121<br>
                    Santa Mônica, Uberlândia - MG</p>
                    <p><i class="fas fa-phone"></i> (34) 3333-4444</p>
                    <p><i class="fas fa-envelope"></i> contato@vitacare.com.br</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Horário de Funcionamento</h5>
                    <p><strong>Segunda a Sexta:</strong> 7h às 18h</p>
                    <p><strong>Sábado:</strong> 8h às 12h</p>
                    <p><strong>Domingo:</strong> Emergências</p>
                    <p><strong>Plantão 24h:</strong> Pronto Socorro</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; 2024 VitaCare Clínica Médica. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/geral.js"></script>
    <script src="../../js/galeria.js"></script>
</body>
</html>

