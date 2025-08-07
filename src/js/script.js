// JavaScript customizado para VitaCare Clínica Médica

// Animações e efeitos visuais
document.addEventListener('DOMContentLoaded', function() {
    // Animação fade-in para elementos
    const fadeElements = document.querySelectorAll('.fade-in-up');
    fadeElements.forEach((element, index) => {
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Smooth scroll para links internos
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Destacar link ativo na navegação
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Efeito parallax no hero (se existir)
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            hero.style.transform = `translateY(${rate}px)`;
        });
    }

    // Contador animado para estatísticas
    const counters = document.querySelectorAll('.stat-number');
    const animateCounters = () => {
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-bs-target') || counter.textContent);
            const count = parseInt(counter.textContent);
            const increment = target / 100;

            if (count < target) {
                counter.textContent = Math.ceil(count + increment);
                setTimeout(animateCounters, 20);
            } else {
                counter.textContent = target;
            }
        });
    };

    // Iniciar contador quando elemento estiver visível
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        observer.observe(counter);
    });
});

// Função para mostrar loading
function showLoading(element) {
    if (element) {
        element.innerHTML = '<div class="spinner"></div>';
    }
}

// Função para esconder loading
function hideLoading(element, originalContent) {
    if (element) {
        element.innerHTML = originalContent;
    }
}

// Função para mostrar notificação toast
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} toast-notification`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()">
        </button>
    `;
    
    // Adicionar estilos para o toast
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    document.body.appendChild(toast);
    
    // Remover automaticamente após 5 segundos
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Função para validar email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Função para validar telefone brasileiro
function validatePhone(phone) {
    const re = /^\(\d{2}\)\s\d{4,5}-\d{4}$/;
    return re.test(phone);
}

// Função para sanitizar entrada (prevenção XSS básica)
function sanitizeInput(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

// Função para formatar data brasileira
function formatDateBR(date) {
    return new Date(date).toLocaleDateString('pt-BR');
}

// Função para formatar data e hora brasileira
function formatDateTimeBR(datetime) {
    return new Date(datetime).toLocaleString('pt-BR');
}

// Debounce function para otimizar eventos
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Função para verificar se elemento está visível na tela
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Adicionar animações CSS via JavaScript
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }
    
    .toast-notification {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: none;
        border-radius: 8px;
    }
    
    .navbar-toggler {
        border: none;
        padding: 4px 8px;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    /* Melhorias de responsividade */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem !important;
        }
        
        .hero p {
            font-size: 1.1rem !important;
        }
        
        .display-4 {
            font-size: 2rem !important;
        }
        
        .card {
            margin-bottom: 1rem;
        }
        
        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }
        
        .toast-notification {
            right: 10px;
            left: 10px;
            min-width: auto;
        }
    }
    
    @media (max-width: 576px) {
        .hero {
            padding: 2rem 0 !important;
        }
        
        .hero h1 {
            font-size: 2rem !important;
        }
        
        .hero .btn {
            display: block;
            margin: 0.5rem 0;
        }
        
        .section-title .step-number {
            width: 25px;
            height: 25px;
            line-height: 25px;
            font-size: 0.9rem;
        }
    }
`;
document.head.appendChild(style);

// Função para lidar com erros de rede
function handleNetworkError(error) {
    console.error('Erro de rede:', error);
    showToast('Erro de conexão. Verifique sua internet e tente novamente.', 'error');
}

// Função para fazer requisições fetch com tratamento de erro
async function fetchWithErrorHandling(url, options = {}) {
    try {
        const response = await fetch(url, {
            ...options,
            headers: {
                'Content-Type': 'application/json',
                ...options.headers
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        handleNetworkError(error);
        throw error;
    }
}

// Inicialização de tooltips do Bootstrap (se disponível)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

// Função para logout (área restrita)
function logout() {
    if (confirm('Tem certeza que deseja sair?')) {
        // Limpar sessão (implementar conforme necessário)
        localStorage.removeItem('user_session');
        sessionStorage.clear();
        
        // Redirecionar para login
        window.location.href = '../public/login.html';
    }
}

// Exportar funções para uso global
window.VitaCare = {
    showToast,
    validateEmail,
    validatePhone,
    sanitizeInput,
    formatDateBR,
    formatDateTimeBR,
    debounce,
    isElementInViewport,
    fetchWithErrorHandling,
    logout
};

