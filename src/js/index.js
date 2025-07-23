// JavaScript específico para a página inicial

document.addEventListener('DOMContentLoaded', function() {
    // Animação simples para elementos fade-in
    const elementosFade = document.querySelectorAll('.fade-in-up');
    elementosFade.forEach((elemento, index) => {
        setTimeout(() => {
            elemento.style.opacity = '1';
            elemento.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Efeito parallax simples no hero
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.3;
            hero.style.transform = `translateY(${rate}px)`;
        });
    }
});

// Estilos CSS adicionais via JavaScript
const estilos = document.createElement('style');
estilos.textContent = `
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }
`;
document.head.appendChild(estilos);

