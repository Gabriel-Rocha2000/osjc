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
    
    // Inicializa modal de imagem
    initImageModal();
    
    // Inicializa drawers do menu
    initNavDrawers();
    
    console.log('Site carregado com sucesso!');
});

// Função para inicializar drawers do menu
function initNavDrawers() {
    // Conteúdo dos drawers por item do menu
    const drawerContent = {
        'Quem Somos': {
            links: [
                { text: 'História', href: 'quem-somos.html' },
                { text: 'Missão, Visão e Valores', href: '#missao-visao-valores' },
                { text: 'Sobre nós', href: 'pages.html' },
                { text: 'Quem é quem', href: 'pages.html' }
            ]
        },
        'Programas': {
            links: [
                { text: 'O que fazemos', href: 'posts.html' },
                { text: 'Projetos', href: 'posts.html' }
            ]
        },
        'Vagas': {
            links: [
                { text: 'Vagas no Colégio Allan Kardec', href: 'pages.html' },
                { text: 'Programas Jovem Aprendiz', href: 'posts.html' },
                { text: 'Jovem Candango', href: 'posts.html' }
            ]
        }
    };
    
    const navLinks = document.querySelectorAll('.main-nav .nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const linkText = this.textContent.trim();
            
            // Verifica se este item tem drawer
            const hasDrawer = drawerContent[linkText];
            
            if (hasDrawer) {
                // Previne navegação para abrir o drawer
                e.preventDefault();
                
                // Remove drawers abertos de outros links
                document.querySelectorAll('.nav-drawer').forEach(drawer => {
                    if (drawer !== this.nextElementSibling) {
                        drawer.classList.remove('active');
                    }
                });
                
                // Cria ou mostra drawer abaixo do link
                let drawer = this.nextElementSibling;
                
                if (!drawer || !drawer.classList.contains('nav-drawer')) {
                    drawer = document.createElement('div');
                    drawer.className = 'nav-drawer';
                    
                    // Cria o conteúdo do drawer
                    let linksHTML = '';
                    hasDrawer.links.forEach(linkItem => {
                        linksHTML += `<a href="${linkItem.href}" class="nav-drawer-link">${linkItem.text}</a>`;
                    });
                    
                    drawer.innerHTML = `
                        <button class="nav-drawer-close" aria-label="Fechar">←</button>
                        <div class="nav-drawer-content">
                            ${linksHTML}
                        </div>
                    `;
                    this.parentElement.appendChild(drawer);
                    
                    // Adiciona evento ao botão de fechar
                    const closeBtn = drawer.querySelector('.nav-drawer-close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            drawer.classList.remove('active');
                            document.body.style.overflow = 'auto';
                        });
                    }
                }
                
                // Bloqueia scroll do body quando drawer está aberto em mobile
                if (window.innerWidth <= 760) {
                    if (drawer.classList.contains('active')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                }
                
                // Alterna o drawer
                drawer.classList.toggle('active');
            } else {
                // Se não tem drawer, permite navegação normal
                // Não previne o comportamento padrão
            }
        });
    });
    
    // Fecha drawers ao clicar fora
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.main-nav li') && !e.target.closest('.nav-drawer-close')) {
            document.querySelectorAll('.nav-drawer').forEach(drawer => {
                drawer.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        }
    });
    
    // Fecha drawer ao clicar em um link dentro dele (em mobile)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('nav-drawer-link') && window.innerWidth <= 760) {
            setTimeout(() => {
                document.querySelectorAll('.nav-drawer').forEach(drawer => {
                    drawer.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            }, 300);
        }
    });
}

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

// Função para inicializar o modal de imagem
function initImageModal() {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const closeBtn = document.querySelector('.image-modal-close');
    const carouselImages = document.querySelectorAll('.hero-carousel-image');
    
    if (!modal || !modalImg) return;
    
    // Abre o modal ao clicar nas imagens do carrossel
    carouselImages.forEach(img => {
        img.addEventListener('click', function() {
            modal.style.display = 'block';
            modalImg.src = this.src;
            modalImg.alt = this.alt;
            document.body.style.overflow = 'hidden'; // Previne scroll do body
        });
    });
    
    // Fecha o modal ao clicar no X
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restaura scroll do body
        });
    }
    
    // Fecha o modal ao clicar fora da imagem
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Fecha o modal com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Newsletter Form
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterEmail = document.getElementById('newsletterEmail');
    const newsletterMessage = document.getElementById('newsletterMessage');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = newsletterEmail.value.trim();
            
            if (!email) {
                showNewsletterMessage('Por favor, insira um email válido.', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNewsletterMessage('Por favor, insira um email válido.', 'error');
                return;
            }
            
            // Aqui você pode integrar com um serviço de newsletter (Mailchimp, SendGrid, etc.)
            // Por enquanto, apenas mostra mensagem de sucesso
            showNewsletterMessage('Obrigado! Você foi inscrito na nossa newsletter.', 'success');
            newsletterEmail.value = '';
            
            // Exemplo de integração (descomente e configure conforme necessário):
            /*
            fetch('/api/newsletter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNewsletterMessage('Obrigado! Você foi inscrito na nossa newsletter.', 'success');
                    newsletterEmail.value = '';
                } else {
                    showNewsletterMessage('Erro ao inscrever. Tente novamente.', 'error');
                }
            })
            .catch(error => {
                showNewsletterMessage('Erro ao inscrever. Tente novamente.', 'error');
            });
            */
        });
    }
    
    function showNewsletterMessage(message, type) {
        if (newsletterMessage) {
            newsletterMessage.textContent = message;
            newsletterMessage.className = 'newsletter-message ' + type;
            
            setTimeout(() => {
                newsletterMessage.textContent = '';
                newsletterMessage.className = 'newsletter-message';
            }, 5000);
        }
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
}
