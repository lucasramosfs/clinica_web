<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Médicos - VitaCare Clínica Médica</title>
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
        // se quiser, redireciona para login se não estiver logado
        header("Location: ../../login.php");
        exit;
    }
    ?>
    <header class="header">
        <div class="container">
            <a href="dashboard.php" class="logo">
                <i class="fas fa-heartbeat"></i> VitaCare - Área Restrita
            </a>
            <div class="header-info">
                <span id="user-info"><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['funcionario_nome']); ?> </span>
                <button class="btn btn-outline-light btn-sm ml-3" onclick="VitaCare.logout()">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </div>
        </div>
    </header>

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
                    <h1 class="display-4 fade-in-up">Listagem de Médicos</h1>
                    <p class="lead fade-in-up">Visualize e gerencie os médicos cadastrados</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-user-md"></i> Médicos Cadastrados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CRM</th>
                                            <th>Especialidade</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="medicos-table-body">
                                        <!-- Dados dos médicos serão carregados aqui via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Editar Médico -->
    <div class="modal fade" id="editarMedicoModal" tabindex="-1" aria-labelledby="editarMedicoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarMedicoModalLabel">
                        <i class="fas fa-user-md"></i> Editar Médico
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarMedico">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="editNome" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="editNome" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="editCrm" class="form-label">CRM *</label>
                                <input type="text" class="form-control" id="editCrm" placeholder="Ex: CRM123456" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="editEspecialidade" class="form-label">Especialidade *</label>
                                <select class="form-select" id="editEspecialidade" required>
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
                        <input type="hidden" id="editCodigo">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="salvarEdicao()">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Exclusão -->
    <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmarExclusaoModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-user-md fa-3x text-danger mb-3"></i>
                        <h5>Tem certeza que deseja excluir este médico?</h5>
                        <p class="text-muted mb-4">Esta ação não poderá ser desfeita.</p>
                        <div class="alert alert-light border">
                            <strong>Médico:</strong> <span id="nomeParaExcluir"></span><br>
                            <strong>CRM:</strong> <span id="crmParaExcluir"></span><br>
                            <strong>Especialidade:</strong> <span id="especialidadeParaExcluir"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmarExclusao()">
                        <i class="fas fa-trash"></i> Excluir Médico
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
    <script src="../../js/listar_medicos.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>


