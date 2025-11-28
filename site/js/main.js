// JavaScript principal do site

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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
    
    // Lazy loading de imagens
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Adiciona animação de fade-in aos posts
    const posts = document.querySelectorAll('.post-preview, .post-item, .page-item');
    posts.forEach((post, index) => {
        post.style.opacity = '0';
        post.style.transform = 'translateY(20px)';
        post.style.transition = 'opacity 0.5s, transform 0.5s';
        
        setTimeout(() => {
            post.style.opacity = '1';
            post.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Controle do drawer do header (mobile)
    const drawerToggle = document.getElementById('drawerToggle');
    const siteHeader = document.getElementById('siteHeader');
    
    function isMobile() {
        return window.innerWidth <= 760;
    }
    
    function toggleDrawer() {
        if (siteHeader && isMobile()) {
            siteHeader.classList.toggle('drawer-open');
            if (drawerToggle) {
                drawerToggle.classList.toggle('active');
            }
        }
    }
    
    // Toggle drawer ao clicar no botão
    if (drawerToggle) {
        drawerToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleDrawer();
        });
    }
    
    // Fechar drawer ao clicar fora (opcional)
    document.addEventListener('click', function(e) {
        if (isMobile() && siteHeader && siteHeader.classList.contains('drawer-open')) {
            // Se clicar fora do header e do botão, fecha o drawer
            if (!siteHeader.contains(e.target) && !drawerToggle.contains(e.target)) {
                siteHeader.classList.remove('drawer-open');
                if (drawerToggle) {
                    drawerToggle.classList.remove('active');
                }
            }
        }
    });
    
    // Fechar drawer ao clicar em um link do menu
    if (siteHeader) {
        const navLinks = siteHeader.querySelectorAll('.main-nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (isMobile() && siteHeader.classList.contains('drawer-open')) {
                    setTimeout(() => {
                        siteHeader.classList.remove('drawer-open');
                        if (drawerToggle) {
                            drawerToggle.classList.remove('active');
                        }
                    }, 300);
                }
            });
        });
    }
    
    // Ajustar comportamento no resize
    function handleResize() {
        if (!isMobile()) {
            // Se não for mobile, sempre mostra o header
            if (siteHeader) {
                siteHeader.classList.remove('drawer-open');
            }
            if (drawerToggle) {
                drawerToggle.classList.remove('active');
            }
        }
    }
    
    window.addEventListener('resize', handleResize);
    handleResize(); // Verifica inicialmente
    
    console.log('Site carregado com sucesso!');
});
