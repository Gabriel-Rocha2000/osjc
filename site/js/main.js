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
    let scrollThreshold = 100; // Distância mínima para ativar o comportamento
    
    function handleScroll() {
        // Não esconde header se drawer estiver aberto em mobile
        if (isMobile() && siteHeader && siteHeader.classList.contains('drawer-open')) {
            return;
        }
        
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        if (siteHeader) {
            // Se estiver no topo, sempre mostra o header
            if (currentScroll < scrollThreshold) {
                siteHeader.classList.remove('scrolled');
                siteHeader.classList.remove('header-hidden');
                lastScroll = currentScroll;
                return;
            }
            
            // Adiciona classe 'scrolled' quando rola para baixo
            if (currentScroll > scrollThreshold) {
                siteHeader.classList.add('scrolled');
            } else {
                siteHeader.classList.remove('scrolled');
            }
            
            // Esconde header ao rolar para baixo, mostra ao rolar para cima
            const scrollDifference = Math.abs(currentScroll - lastScroll);
            
            // Só esconde/mostra se a diferença de scroll for significativa (evita flickering)
            if (scrollDifference > 5) {
                if (currentScroll > lastScroll && currentScroll > scrollThreshold) {
                    // Rolando para baixo - esconde
                    siteHeader.classList.add('header-hidden');
                } else if (currentScroll < lastScroll) {
                    // Rolando para cima - mostra
                    siteHeader.classList.remove('header-hidden');
                }
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
    
    // Carrossel de Programas
    initHeroCarousel('programsCarousel');
    
    // Toggle Dark/Light Mode
    initThemeToggle();
    
    // Inicializa modal de imagem
    initImageModal();
    
    // Inicializa drawers do menu
    initNavDrawers();
    
    // Inicializa carrosséis de programas
    const programCarousels = document.querySelectorAll('.program-carousel');
    programCarousels.forEach(carousel => {
        initProgramCarousel(carousel);
    });
    
    // Adiciona espaço para imagem em todos os post-items
    initPostItemImages();
    
    // Remove category-title do DOM para não interferir no grid
    fixPostsGridLayout();
    
    // Site carregado com sucesso
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

// Função para adicionar espaço de imagem em todos os post-items
function initPostItemImages() {
    const postItems = document.querySelectorAll('.post-item');
    
    postItems.forEach(postItem => {
        // Verifica se já tem a estrutura de imagem
        if (postItem.querySelector('.post-item-content')) {
            return; // Já tem, pula
        }
        
        // Cria a estrutura de conteúdo
        const content = document.createElement('div');
        content.className = 'post-item-content';
        
        // Cria o wrapper da imagem
        const imageWrapper = document.createElement('div');
        imageWrapper.className = 'post-image-wrapper';
        const img = document.createElement('img');
        img.src = 'hero-poster.jpg';
        img.alt = 'Imagem do projeto';
        img.className = 'post-image';
        imageWrapper.appendChild(img);
        
        // Cria o wrapper do texto
        const textContent = document.createElement('div');
        textContent.className = 'post-text-content';
        
        // Move todo o conteúdo existente para textContent
        while (postItem.firstChild) {
            textContent.appendChild(postItem.firstChild);
        }
        
        // Adiciona os elementos ao content
        content.appendChild(imageWrapper);
        content.appendChild(textContent);
        
        // Adiciona o content ao post-item
        postItem.appendChild(content);
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
function initHeroCarousel(carouselId) {
    // Se um ID específico foi passado, usa ele, senão usa o primeiro .hero-carousel encontrado
    const carousel = carouselId 
        ? document.getElementById(carouselId)
        : document.querySelector('.hero-carousel');
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

// Sistema de Filtros de Posts
function initPostsFilters() {
    const postItems = document.querySelectorAll('.post-item');
    const categoryFilters = document.querySelectorAll('#categoryFilters .filter-btn');
    const dateFilters = document.querySelectorAll('#dateFilters .filter-btn');
    const resetBtn = document.getElementById('resetFilters');
    const resultsText = document.getElementById('filterResultsText');
    
    if (postItems.length === 0) return;
    
    // Adiciona atributos data aos posts baseado no conteúdo
    postItems.forEach(post => {
        // Extrai categoria das tags
        const categoryTags = post.querySelectorAll('.category-tag');
        const categories = Array.from(categoryTags).map(tag => {
            let cat = tag.textContent.trim().toLowerCase();
            // Normaliza nomes de categorias
            cat = cat.replace(/\s+/g, '-');
            cat = cat.replace(/í/g, 'i');
            return cat;
        });
        if (categories.length > 0) {
            post.setAttribute('data-category', categories.join(' '));
        } else {
            post.setAttribute('data-category', 'sem-categoria');
        }
        
        // Extrai ano da data de publicação
        const metaText = post.querySelector('.post-meta')?.textContent || '';
        const yearMatch = metaText.match(/Publicado em (\d{4})/);
        if (yearMatch) {
            post.setAttribute('data-date', yearMatch[1]);
        } else {
            // Tenta extrair de outras formas
            const dateMatch = metaText.match(/(\d{4})-\d{2}-\d{2}/);
            if (dateMatch) {
                post.setAttribute('data-date', dateMatch[1]);
            }
        }
    });
    
    let activeCategory = 'all';
    let activeDate = 'all';
    
    // Função para filtrar posts
    function filterPosts() {
        let visibleCount = 0;
        
        postItems.forEach(post => {
            const postCategory = post.getAttribute('data-category') || '';
            const postDate = post.getAttribute('data-date') || '';
            
            const categoryMatch = activeCategory === 'all' || 
                postCategory.includes(activeCategory.toLowerCase().replace(/\s+/g, '-').replace(/í/g, 'i'));
            const dateMatch = activeDate === 'all' || postDate === activeDate;
            
            if (categoryMatch && dateMatch) {
                post.style.display = '';
                visibleCount++;
            } else {
                post.style.display = 'none';
            }
        });
        
        // Atualiza texto de resultados
        let resultText = '';
        if (activeCategory === 'all' && activeDate === 'all') {
            resultText = `Mostrando todos os ${visibleCount} posts`;
        } else {
            const filters = [];
            if (activeCategory !== 'all') {
                filters.push(`categoria "${activeCategory}"`);
            }
            if (activeDate !== 'all') {
                filters.push(`ano ${activeDate}`);
            }
            resultText = `Mostrando ${visibleCount} post${visibleCount !== 1 ? 's' : ''} com ${filters.join(' e ')}`;
        }
        if (resultsText) {
            resultsText.textContent = resultText;
        }
        
        // Scroll suave para o topo dos resultados
        const postsList = document.querySelector('.posts-list');
        if (postsList && visibleCount > 0) {
            postsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    
    // Event listeners para filtros de categoria
    categoryFilters.forEach(btn => {
        btn.addEventListener('click', function() {
            categoryFilters.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeCategory = this.getAttribute('data-filter');
            filterPosts();
        });
    });
    
    // Event listeners para filtros de data
    dateFilters.forEach(btn => {
        btn.addEventListener('click', function() {
            dateFilters.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeDate = this.getAttribute('data-filter');
            filterPosts();
        });
    });
    
    // Botão reset
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            categoryFilters.forEach(b => b.classList.remove('active'));
            dateFilters.forEach(b => b.classList.remove('active'));
            categoryFilters[0].classList.add('active');
            dateFilters[0].classList.add('active');
            activeCategory = 'all';
            activeDate = 'all';
            filterPosts();
        });
    }
    
    // Inicializa contagem
    filterPosts();
}

// Inicializa filtros quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.posts-filters')) {
        initPostsFilters();
    }
});

// Função para inicializar carrossel de programas
function initProgramCarousel(carouselElement) {
    if (!carouselElement) return;
    
    const slides = carouselElement.querySelectorAll('.program-carousel-slide');
    const dots = carouselElement.querySelectorAll('.program-carousel-dot');
    const prevBtn = carouselElement.querySelector('.program-carousel-prev');
    const nextBtn = carouselElement.querySelector('.program-carousel-next');
    
    if (slides.length === 0) return;
    
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
    carouselElement.addEventListener('mouseenter', () => {
        clearInterval(autoplayInterval);
    });
    
    carouselElement.addEventListener('mouseleave', () => {
        startAutoplay();
    });
    
    // Inicia autoplay
    startAutoplay();
}

// Função para corrigir layout do grid removendo category-title
function fixPostsGridLayout() {
    const postsList4Cols = document.querySelector('.posts-list-4cols');
    if (!postsList4Cols) return;
    
    // Guarda o botão de paginação e o container pai
    const pagination = postsList4Cols.querySelector('.posts-pagination');
    const parentContainer = postsList4Cols.parentNode;
    
    // Remove temporariamente o botão do DOM
    if (pagination && pagination.parentNode) {
        pagination.parentNode.removeChild(pagination);
    }
    
    // Coleta TODOS os posts ANTES de remover as seções (para garantir que nenhum seja perdido)
    const allPosts = Array.from(postsList4Cols.querySelectorAll('.post-item'));
    
    // Remove todas as seções de categoria
    const categorySections = postsList4Cols.querySelectorAll('.category-section');
    categorySections.forEach(section => {
        if (section.parentNode) {
            section.parentNode.removeChild(section);
        }
    });
    
    // Limpa o container do grid de qualquer elemento que não seja post
    const allChildren = Array.from(postsList4Cols.children);
    allChildren.forEach(child => {
        if (!child.classList.contains('post-item')) {
            if (child.parentNode) {
                child.parentNode.removeChild(child);
            }
        }
    });
    
    // Move todos os posts diretamente para o container do grid
    allPosts.forEach(post => {
        // Remove o post do seu local atual
        if (post.parentNode && post.parentNode !== postsList4Cols) {
            post.parentNode.removeChild(post);
        }
        // Adiciona no grid
        postsList4Cols.appendChild(post);
    });
    
    // Adiciona o botão de paginação FORA do grid, após o container do grid
    if (pagination && parentContainer) {
        parentContainer.appendChild(pagination);
    }
    
    // Debug: verifica se todos os 16 posts estão no grid
    const finalPosts = postsList4Cols.querySelectorAll('.post-item');
    console.log('Posts no grid:', finalPosts.length);
}

// Tornar cards de posts clicáveis
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.post-item').forEach(postItem => {
        const link = postItem.querySelector('.post-text-content h3 a, .read-more');
        if (link) {
            const postUrl = link.getAttribute('href');
            postItem.style.cursor = 'pointer';
            postItem.addEventListener('click', function(e) {
                // Não redirecionar se clicar diretamente em um link
                if (e.target.tagName === 'A' || e.target.closest('a')) {
                    return;
                }
                window.location.href = postUrl;
            });
        }
    });
});
