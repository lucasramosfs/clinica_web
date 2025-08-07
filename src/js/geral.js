// JavaScript geral - Funções compartilhadas

// Funções básicas de validação
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validarTelefone(telefone) {
    const regex = /^\(\d{2}\)\s\d{4,5}-\d{4}$/;
    return regex.test(telefone);
}

// Função para mostrar mensagens
function mostrarMensagem(texto, tipo = 'info') {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo}`;
    alerta.innerHTML = `
        ${texto}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()">
        </button>
    `;
    
    alerta.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    `;
    
    document.body.appendChild(alerta);
    
    // Remover após 5 segundos
    setTimeout(() => {
        if (alerta.parentElement) {
            alerta.remove();
        }
    }, 5000);
}

// Navegação ativa
document.addEventListener('DOMContentLoaded', function() {
    const paginaAtual = window.location.pathname.split('/').pop();
    const linksNav = document.querySelectorAll('.navbar-nav .nav-link');
    
    linksNav.forEach(link => {
        if (link.getAttribute('href') === paginaAtual || 
            link.getAttribute('href').includes(paginaAtual)) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});

// Scroll suave para links internos
document.addEventListener('DOMContentLoaded', function() {
    const linksInternos = document.querySelectorAll('a[href^="#"]');
    linksInternos.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const destino = document.querySelector(this.getAttribute('href'));
            if (destino) {
                destino.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Função de logout
function logout() {
    if (confirm('Tem certeza que deseja sair?')) {
        localStorage.removeItem('sessao_usuario');
        window.location.href = '../public/login.html';
    }
}

