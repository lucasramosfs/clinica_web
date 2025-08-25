<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Médico - VitaCare Clínica Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/tabelas.css">
    <link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Header Área Restrita -->
    <?php
    session_start();
    if (!isset($_SESSION['funcionario_id'])) {
        header("Location: ../public/login.html");
        exit;
    }
    ?>
    <header class="header">
        <div class="container">
            <a href="dashboard.php" class="logo">
                <i class="fas fa-heartbeat"></i> VitaCare - Área Restrita
            </a>
            <div class="header-info">
                <span id="user-info">
                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['funcionario_nome']); ?>
                </span>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="logout" class="btn btn-outline-light btn-sm ml-3">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <?php
    // Logout
    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../public/login.html");
        exit;
    }
    ?>

    <!-- Navegação Área Restrita -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="cadastrosDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                            <i class="fas fa-plus-circle"></i> Cadastros
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="cadastrosDropdown">
                            <li><a class="dropdown-item" href="cadastro_funcionario.php">
                                <i class="fas fa-user-tie"></i> Funcionários
                            </a></li>
                            <li><a class="dropdown-item" href="cadastro_medico.php">
                                <i class="fas fa-user-md"></i> Médicos
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="listagensDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                            <i class="fas fa-list"></i> Listagens
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="listagensDropdown">
                            <li><a class="dropdown-item" href="listar_funcionarios.php">
                                <i class="fas fa-users"></i> Funcionários
                            </a></li>
                            <li><a class="dropdown-item" href="listar_medicos.php">
                                <i class="fas fa-user-md"></i> Médicos
                            </a></li>
                            <li><a class="dropdown-item" href="listar_agendamentos.php">
                                <i class="fas fa-calendar-alt"></i> Agendamentos
                            </a></li>
                            <li><a class="dropdown-item" href="listar_contatos.php">
                                <i class="fas fa-envelope"></i> Contatos
                            </a></li>
                        </ul>
                    </li>
                </ul>
                <a href="../../../index.html" class="btn btn-outline-light ms-lg-3 mt-3 mt-lg-0">
                    <i class="fas fa-globe"></i> Site Público
                </a>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h1 class="display-4 fade-in-up">Cadastro de Médico</h1>
                    <p class="lead fade-in-up">Preencha os dados para cadastrar um novo médico</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-user-md"></i> Dados do Médico</h4>
                        </div>
                        <div class="card-body">
                            
                            <form id="cadastroMedicoForm" action="../../../api/cadastrar_medico.php" method="POST">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="nome" class="form-label">Nome Completo *</label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="crm" class="form-label">CRM *</label>
                                        <input type="text" class="form-control" id="crm" name="crm" placeholder="MG999999" required>
                                    </div>

                                     <div class="col-md-6 mb-3">
                                        <label for="especialidade" class="form-label">Especialidade *</label>
                                        <select class="form-select" id="especialidade" name="especialidade" required>
                                            <option value="">Selecione a especialidade</option>
                                            <option value="Cardiologia">Cardiologia</option>
                                            <option value="Dermatologia">Dermatologia</option>
                                            <option value="Endocrinologia">Endocrinologia</option>
                                            <option value="Gastroenterologia">Gastroenterologia</option>
                                            <option value="Ginecologia">Ginecologia</option>
                                            <option value="Neurologia">Neurologia</option>
                                            <option value="Oftalmologia">Oftalmologia</option>
                                            <option value="Ortopedia">Ortopedia</option>
                                            <option value="Pediatria">Pediatria</option>
                                            <option value="Psiquiatria">Psiquiatria</option>
                                            <option value="Urologia">Urologia</option>
                                            <option value="Clínica Geral">Clínica Geral</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> Cadastrar Médico
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; 2024 VitaCare Clínica Médica - Sistema de Gestão Interno</p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/geral.js"></script>
    <script src="../../js/tabelas.js"></script>
    <script src="../../js/cadastro_medico.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>


