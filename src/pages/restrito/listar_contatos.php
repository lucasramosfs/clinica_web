<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Contatos - VitaCare Clínica Médica</title>
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
                    <h1 class="display-4 fade-in-up">Listagem de Contatos</h1>
                    <p class="lead fade-in-up">Visualize as mensagens de contato enviadas pelos usuários</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-envelope"></i> Mensagens de Contato</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Telefone</th>
                                            <th>Mensagem</th>
                                            <th>Data Envio</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contatos-table-body">
                                        <!-- Dados dos contatos serão carregados aqui via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Confirmar Exclusão de Contato -->
    <div class="modal fade" id="confirmarExclusaoContatoModal" tabindex="-1" aria-labelledby="confirmarExclusaoContatoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmarExclusaoContatoModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5>Tem certeza que deseja excluir esta mensagem de contato?</h5>
                        <p class="text-muted mb-4">Esta ação não poderá ser desfeita.</p>
                        <div class="alert alert-light border">
                            <strong>Nome:</strong> <span id="nomeContatoParaExcluir"></span><br>
                            <strong>E-mail:</strong> <span id="emailContatoParaExcluir"></span><br>
                            <strong>Data Envio</strong> <span id="dataContatoParaExcluir"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmarExclusaoContato()">
                        <i class="fas fa-trash"></i> Excluir Contato
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <script src="../../js/listar_contatos.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>


