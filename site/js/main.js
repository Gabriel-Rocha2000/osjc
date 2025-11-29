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
    
    // Controle do header ao fazer scroll (siteHeader já foi declarado acima)
    let lastScroll = 0;
    
    function handleScroll() {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        if (siteHeader) {
            // Adiciona classe 'scrolled' quando rola para baixo
            if (currentScroll > 100) {
                siteHeader.classList.add('scrolled');
            } else {
                siteHeader.classList.remove('scrolled');
            }
        }
        
        lastScroll = currentScroll;
    }
    
    // Throttle para melhor performance
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Verifica posição inicial
    handleScroll();
    
    // Carrossel do Banner
    initHeroCarousel();
    
    // Toggle Dark/Light Mode
    initThemeToggle();
    
    console.log('Site carregado com sucesso!');
});

// Função para inicializar o toggle de tema
function initThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('.theme-icon');
    const body = document.body;
    
    // Verifica se há preferência salva
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        if (themeIcon) themeIcon.textContent = '☀️';
    }
    
    // Adiciona evento de clique
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            
            // Atualiza o ícone
            if (themeIcon) {
                if (body.classList.contains('dark-mode')) {
                    themeIcon.textContent = '☀️';
                    localStorage.setItem('theme', 'dark');
                } else {
                    themeIcon.textContent = '🌙';
                    localStorage.setItem('theme', 'light');
                }
            }
        });
    }
}

// Função para inicializar o carrossel do banner
function initHeroCarousel() {
    const carousel = document.querySelector('.hero-carousel');
    if (!carousel) return;
    
    const slides = carousel.querySelectorAll('.hero-carousel-slide');
    const dots = carousel.querySelectorAll('.carousel-dot');
    const prevBtn = carousel.querySelector('.hero-nav-prev');
    const nextBtn = carousel.querySelector('.hero-nav-next');
    
    let currentSlide = 0;
    let autoplayInterval;
    
    // Função para mostrar slide específico
    function showSlide(index) {
        // Remove active de todos os slides e dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Adiciona active no slide e dot atual
        if (slides[index]) {
            slides[index].classList.add('active');
        }
        if (dots[index]) {
            dots[index].classList.add('active');
        }
        
        currentSlide = index;
    }
    
    // Função para próximo slide
    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }
    
    // Função para slide anterior
    function prevSlide() {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    }
    
    // Event listeners para botões
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetAutoplay();
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetAutoplay();
        });
    }
    
    // Event listeners para dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            resetAutoplay();
        });
    });
    
    // Autoplay
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            nextSlide();
        }, 5000); // Muda a cada 5 segundos
    }
    
    function resetAutoplay() {
        clearInterval(autoplayInterval);
        startAutoplay();
    }
    
    // Pausa autoplay ao passar o mouse
    carousel.addEventListener('mouseenter', () => {
        clearInterval(autoplayInterval);
    });
    
    carousel.addEventListener('mouseleave', () => {
        startAutoplay();
    });
    
    // Inicia autoplay
    startAutoplay();
}
