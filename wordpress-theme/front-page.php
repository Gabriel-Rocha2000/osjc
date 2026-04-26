<?php
/**
 * Template Name: Página Inicial
 * 
 * Template para a página inicial do site
 * Mantém 100% do HTML original do index.html
 */

get_header();
?>

<main class="main-content">
    <!-- 1. BANNER -->
    <section class="hero">
        <div class="hero-title-mobile">
            <h1><?php bloginfo('name'); ?></h1>
        </div>
        <div class="hero-carousel hero-carousel-fullwidth">
            <div class="hero-carousel-track">
                <div class="hero-carousel-slide active">
                    <img src="<?php echo osjc_get_image_url('9.png'); ?>" alt="Banner principal 1" class="hero-carousel-image" />
                </div>
                <div class="hero-carousel-slide">
                    <img src="<?php echo osjc_get_image_url('10.png'); ?>" alt="Banner principal 2" class="hero-carousel-image" />
                </div>
                <div class="hero-carousel-slide">
                    <img src="<?php echo osjc_get_image_url('11.png'); ?>" alt="Banner principal 3" class="hero-carousel-image" />
                </div>
            </div>
            <button class="hero-nav-arrow hero-nav-prev" aria-label="Anterior">‹</button>
            <button class="hero-nav-arrow hero-nav-next" aria-label="Próximo">›</button>
            <div class="hero-carousel-dots">
                <span class="carousel-dot active" data-slide="0"></span>
                <span class="carousel-dot" data-slide="1"></span>
                <span class="carousel-dot" data-slide="2"></span>
            </div>
            <div class="hero-button-overlay">
                <a href="<?php echo esc_url(home_url('/programas')); ?>" class="hero-button"><?php _e('Conheça mais', 'osjc'); ?></a>
            </div>
        </div>
        <div class="hero-button-below">
            <a href="<?php echo esc_url(home_url('/programas')); ?>" class="hero-button"><?php _e('Conheça mais', 'osjc'); ?></a>
        </div>
        <div class="hero-content-below">
            <div class="container">
                <h1><?php _e('Educando para a vida', 'osjc'); ?></h1>
                <p class="hero-subtitle"><?php _e('Existem várias maneiras de colaborar com nossos programas assistenciais, seja doando recursos materiais, financeiros ou se tornando um voluntário.', 'osjc'); ?></p>
                <div class="hero-features">
                    <div class="hero-feature-item">
                        <span class="checkmark">✓</span>
                        <span><?php _e('Fortaleça', 'osjc'); ?></span>
                    </div>
                    <div class="hero-feature-item">
                        <span class="checkmark">✓</span>
                        <span><?php _e('Impacte', 'osjc'); ?></span>
                    </div>
                    <div class="hero-feature-item">
                        <span class="checkmark">✓</span>
                        <span><?php _e('Transforme', 'osjc'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. DEPOIMENTOS -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Ouça nossos apoiadores', 'osjc'); ?></span>
                <h2><?php _e('Vozes de impacto compartilham histórias!', 'osjc'); ?></h2>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Olá, boa tarde! Me chamo Raimundo Alves, sou empresário no ramo de confecção há 4 anos. Estou fazendo o módulo de Modelagem na Osceia, por indicação de uma modelista que trabalha comigo há bastante tempo. Estou gostando muito do curso, já conheci pessoas com quem estou começando a trabalhar e pretendo fazer outros cursos para me especializar ainda mais. Agradeço à Osceia por esta oportunidade, que tem aberto portas para muita gente. Estou achando tudo muito bom!"</p>
                    <div class="testimonial-author">
                        <strong>Raimundo Alvez</strong>
                        <span><?php _e('Modelagem', 'osjc'); ?></span>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"Estou aqui há um ano, graças à minha tia, que já participava e nos apresentou à Maura. Eu e minha irmã temos alguns problemas de saúde, como artrose e artrite, e depois de aposentadas, ficamos muito sozinhas. Estar aqui tem sido ótimo, porque podemos conviver com outras pessoas, compartilhar, trocar ideias. A Maura traz isso pra gente. O grupo é maravilhoso — fazemos orações e exercícios juntos, o que ajuda muito na mente e no corpo. Só temos a agradecer. Muito obrigada!"</p>
                    <div class="testimonial-author">
                        <strong>Orlany</strong>
                        <span><?php _e('Programa Alvorecer', 'osjc'); ?></span>
                    </div>
                </div>
            </div>
            <div class="testimonials-cta">
                <a href="#" class="btn-secondary"><?php _e('Mostrar mais depoimentos', 'osjc'); ?></a>
            </div>
        </div>
    </section>

    <!-- 3. PROGRAMAS -->
    <section class="programs-section">
        <div class="container">
            <div class="programs-list">
                <!-- 1. Texto à esquerda, Imagem à direita -->
                <div class="program-item program-item-text-left">
                    <div class="program-content">
                        <span class="program-tag"><?php _e('Programa', 'osjc'); ?></span>
                        <h3><?php _e('Jovem Aprendiz', 'osjc'); ?></h3>
                        <p><?php _e('O programa jovem aprendiz encaminha aprendizes na faixa etária de 14 a 24 anos incompletos, devidamente contratados e/ou matriculados para a realização de aprendizado prático nas empresas parceiras', 'osjc'); ?></p>
                        <a href="<?php echo esc_url(home_url('/pages/todas/portal-jovem-aprendiz/')); ?>" class="program-link"><?php _e('Acessar Jovem Aprendiz', 'osjc'); ?></a>
                    </div>
                    <div class="program-image-wrapper">
                        <img src="<?php echo osjc_get_image_url('JOVEM APRENDIZ.JPG'); ?>" alt="<?php esc_attr_e('Programa Jovem Aprendiz', 'osjc'); ?>" class="program-image" />
                    </div>
                </div>
                
                <!-- 2. Imagem à esquerda, Texto à direita -->
                <div class="program-item program-item-image-left">
                    <div class="program-image-wrapper">
                        <img src="<?php echo osjc_get_image_url('ENXOVAL MARIA DE NAZARE.JPG'); ?>" alt="<?php esc_attr_e('Colégio Allan Kardec - OSJC Sobradinho', 'osjc'); ?>" class="program-image" />
                    </div>
                    <div class="program-content">
                        <span class="program-tag"><?php _e('Programa', 'osjc'); ?></span>
                        <h3><?php _e('Enxoval Maria de Nazaré', 'osjc'); ?></h3>
                        <p><?php _e('Nosso propósito é promover os apoios necessários às pessoas com deficiência para o reconhecimento e fortalecimento de suas potencialidades e habilidades na integração ao mundo do trabalho.', 'osjc'); ?></p>
                        <a href="<?php echo esc_url(home_url('/programas')); ?>" class="program-link"><?php _e('Conheça o programa', 'osjc'); ?></a>
                    </div>
                </div>
                
                <!-- 3. Texto à esquerda, Imagem à direita -->
                <div class="program-item program-item-text-left">
                    <div class="program-content">
                        <span class="program-tag"><?php _e('Programa', 'osjc'); ?></span>
                        <h3><?php _e('Jovem Candango', 'osjc'); ?></h3>
                        <p><?php _e('Em parceria com o GDF, o programa oferece formação e qualificação profissional para jovens em situação de vulnerabilidade social, com encaminhamento ao mundo do trabalho.', 'osjc'); ?></p>
                        <a href="<?php echo esc_url(home_url('/pages/todas/vagas-jovem-candango/')); ?>" class="program-link"><?php _e('Vagas e informações do programa', 'osjc'); ?></a>
                    </div>
                    <div class="program-image-wrapper">
                        <img src="<?php echo osjc_get_image_url('JOVEM CANDANGO.JPG'); ?>" alt="<?php esc_attr_e('Programa Qualificação Profissional', 'osjc'); ?>" class="program-image" />
                    </div>
                </div>
                
                <!-- 4. Imagem à esquerda, Texto à direita -->
                <div class="program-item program-item-image-left">
                    <div class="program-image-wrapper">
                        <img src="<?php echo osjc_get_image_url('FORTALECER E APRENDER.JPG'); ?>" alt="<?php esc_attr_e('Educandário Espírita Eurípedes Barsanulfo', 'osjc'); ?>" class="program-image" />
                    </div>
                    <div class="program-content">
                        <span class="program-tag"><?php _e('Programa', 'osjc'); ?></span>
                        <h3><?php _e('Programa Fortalecer e Aprender', 'osjc'); ?></h3>
                        <p><?php _e('O Programa Fortalecer e Aprender é uma escola confessional, gratuita, que atende em média 300 alunos…', 'osjc'); ?></p>
                        <a href="<?php echo esc_url(home_url('/programas')); ?>" class="program-link"><?php _e('Conheça o programa', 'osjc'); ?></a>
                    </div>
                </div>
                
                <!-- 5. Texto à esquerda, Carrossel à direita -->
                <div class="program-item program-item-text-left">
                    <div class="program-content">
                        <span class="program-tag"><?php _e('Campanha', 'osjc'); ?></span>
                        <h3><?php _e('Campanha Apadrinhamento', 'osjc'); ?></h3>
                        <p><?php _e('No mundo, cerca de 17 milhões de crianças crescem em ambientes familiares desprotegidos, sem acesso a serviços essenciais como saúde e educação, além de viverem diariamente sob risco de violação de seus direitos.', 'osjc'); ?></p>
                        <p><?php _e('Apadrinhar é assumir um compromisso de amor e cuidado. É escolher fazer a diferença na vida de uma criança ou adolescente que precisa de apoio, atenção e oportunidades. Ao longo do apadrinhamento, nasce um vínculo profundo, e o padrinho muitas vezes se torna uma referência de afeto, proteção e amizade para toda a vida.', 'osjc'); ?></p>
                        <p><strong><?php _e('Faça parte dessa transformação. Apadrinhe.', 'osjc'); ?></strong></p>
                        <a href="<?php echo esc_url(home_url('/campanha-apadrinhamento')); ?>" class="program-link"><?php _e('Saiba mais sobre a campanha', 'osjc'); ?></a>
                    </div>
                    <div class="program-image-wrapper">
                        <div class="program-carousel" data-carousel="apadrinhamento">
                            <div class="program-carousel-track">
                                <div class="program-carousel-slide active">
                                    <img src="<?php echo osjc_get_image_url('FORTALECER E APRENDER.JPG'); ?>" alt="<?php esc_attr_e('Campanha Apadrinhamento - Imagem 1', 'osjc'); ?>" class="program-image" />
                                </div>
                                <div class="program-carousel-slide">
                                    <img src="<?php echo osjc_get_image_url('JOVEM CANDANGO.JPG'); ?>" alt="<?php esc_attr_e('Campanha Apadrinhamento - Imagem 2', 'osjc'); ?>" class="program-image" />
                                </div>
                                <div class="program-carousel-slide">
                                    <img src="<?php echo osjc_get_image_url('JOVEM APRENDIZ.JPG'); ?>" alt="<?php esc_attr_e('Campanha Apadrinhamento - Imagem 3', 'osjc'); ?>" class="program-image" />
                                </div>
                            </div>
                            <button class="program-carousel-prev" aria-label="<?php esc_attr_e('Imagem anterior', 'osjc'); ?>">‹</button>
                            <button class="program-carousel-next" aria-label="<?php esc_attr_e('Próxima imagem', 'osjc'); ?>">›</button>
                            <div class="program-carousel-dots">
                                <button class="program-carousel-dot active" aria-label="<?php esc_attr_e('Imagem 1', 'osjc'); ?>"></button>
                                <button class="program-carousel-dot" aria-label="<?php esc_attr_e('Imagem 2', 'osjc'); ?>"></button>
                                <button class="program-carousel-dot" aria-label="<?php esc_attr_e('Imagem 3', 'osjc'); ?>"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="programs-cta">
                <a href="<?php echo esc_url(home_url('/programas')); ?>" class="btn-secondary"><?php _e('Mostrar mais programas', 'osjc'); ?></a>
            </div>
        </div>
    </section>

    <!-- Portal Jovem Aprendiz (atalhos) -->
    <section class="ja-portal-home-section" aria-labelledby="ja-portal-home-heading">
        <div class="container">
            <div class="ja-portal-home-inner">
                <h2 id="ja-portal-home-heading" class="ja-portal-home-title"><?php _e('Programa Jovem Aprendiz', 'osjc'); ?></h2>
                <p class="ja-portal-lead"><?php _e('Escolha uma opção para continuar.', 'osjc'); ?></p>
                <div class="ja-portal-home-card">
                    <div class="ja-portal-duo-wrap">
                        <div class="ja-portal-duo-figure">
                            <img src="<?php echo esc_url(osjc_get_image_url('ja-portal-jovem-aprendiz-duo.png')); ?>" alt="<?php esc_attr_e('À esquerda: jovem candidato. À direita: reunião em empresa.', 'osjc'); ?>" loading="lazy" decoding="async" />
                            <div class="ja-portal-duo-links">
                                <a href="<?php echo esc_url(home_url('/pages/todas/jovem-aprendiz/')); ?>" class="ja-portal-hotspot" aria-label="<?php esc_attr_e('Sou jovem e busco uma vaga', 'osjc'); ?>"></a>
                                <a href="<?php echo esc_url(home_url('/pages/todas/empresa-jovem-aprediz/')); ?>" class="ja-portal-hotspot" aria-label="<?php esc_attr_e('Sou empresa e quero contratar', 'osjc'); ?>"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="ja-portal-more"><a href="<?php echo esc_url(home_url('/pages/todas/vagas-jovem-aprendiz/')); ?>"><?php _e('Informações gerais sobre vagas e o programa', 'osjc'); ?></a></p>
            </div>
        </div>
    </section>

    <!-- 4. NÚMEROS -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">0</div>
                    <div class="stat-label"><?php _e('Títulos de premiações', 'osjc'); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">0</div>
                    <div class="stat-label"><?php _e('Projetos Ativos', 'osjc'); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">0 +</div>
                    <div class="stat-label"><?php _e('Atendimentos diários', 'osjc'); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">0 +</div>
                    <div class="stat-label"><?php _e('Empregos direcionados', 'osjc'); ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. MISSÃO, VISÃO E VALORES -->
    <section id="missao-visao-valores" class="mission-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Nossos fundamentos', 'osjc'); ?></span>
                <h2><?php _e('Missão, Visão e Valores', 'osjc'); ?></h2>
            </div>
            <div class="mission-grid">
                <div class="mission-card">
                    <h3><?php _e('Missão', 'osjc'); ?></h3>
                    <p><?php _e('Oferecer serviços socioeducacionais, socioassistenciais e sócio profissionalizantes às comunidades vulneráveis, em diferentes níveis, englobando a formação do indivíduo consciente e participativo e contribuindo para o fortalecimento da sociedade.', 'osjc'); ?></p>
                </div>
                <div class="mission-card">
                    <h3><?php _e('Visão', 'osjc'); ?></h3>
                    <p><?php _e('Ser referência em educação e profissionalização do público em situação de vulnerabilidade, atenuando a desigualdade social e educacional.', 'osjc'); ?></p>
                </div>
                <div class="mission-card">
                    <h3><?php _e('Valores', 'osjc'); ?></h3>
                    <p><?php _e('Praticar a caridade moral e material; Prestar serviços gratuitos e permanentes aos usuários da assistência social, por todos os meios ao seu alcance e sem discriminação de clientela; Difundir a instrução e combater os vícios humanos', 'osjc'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. PARCEIROS -->
    <section class="partners-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Juntos fazemos a diferença', 'osjc'); ?></span>
                <h2><?php _e('Nossos Parceiros', 'osjc'); ?></h2>
            </div>
            <p class="partners-description"><?php _e('Agradecemos a todos os parceiros que nos ajudam a transformar vidas.', 'osjc'); ?></p>
            <div class="partners-grid">
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('Microsoft-logo_rgb_c-gray-768x344.png'); ?>" alt="<?php esc_attr_e('Parceiro 1', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('2 (1).png'); ?>" alt="<?php esc_attr_e('Parceiro 2', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('Avanade.png'); ?>" alt="<?php esc_attr_e('Parceiro 3', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('Image-empty-state.webp'); ?>" alt="<?php esc_attr_e('Parceiro 4', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('images.png'); ?>" alt="<?php esc_attr_e('Parceiro 5', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('Logo sin fondo.png'); ?>" alt="<?php esc_attr_e('Parceiro 6', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item">
                    <img src="<?php echo osjc_get_image_url('logo_supermercados-comper_FfQ89g.png'); ?>" alt="<?php esc_attr_e('Parceiro 7', 'osjc'); ?>" class="partner-image">
                </div>
                <div class="partner-item partner-item-gray-bg">
                    <img src="<?php echo osjc_get_image_url('OAS letra blanca.gif'); ?>" alt="<?php esc_attr_e('Parceiro 8', 'osjc'); ?>" class="partner-image">
                </div>
            </div>
        </div>
    </section>

    <!-- 7. BLOG -->
    <section class="blog-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Conteúdo e atualizações', 'osjc'); ?></span>
                <h2><?php _e('Nosso Blog', 'osjc'); ?></h2>
            </div>
            <div class="blog-grid">
                <article class="blog-card">
                    <h3><?php _e('Últimas publicações', 'osjc'); ?></h3>
                    <p><?php _e('Confira nossos artigos e atualizações sobre nossos programas e projetos.', 'osjc'); ?></p>
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="blog-link"><?php _e('Ver blog →', 'osjc'); ?></a>
                </article>
            </div>
            <div class="blog-cta">
                <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn-secondary"><?php _e('Ver mais posts', 'osjc'); ?></a>
            </div>
        </div>
    </section>

    <!-- 8. NOTÍCIAS -->
    <section class="news-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Histórias comoventes e acontecimentos emocionantes', 'osjc'); ?></span>
                <h2><?php _e('Fique atualizado com as últimas novidades da Osjc', 'osjc'); ?></h2>
            </div>
            <div class="news-grid">
                <article class="news-card">
                    <h3><?php _e('Natal com Jesus: O Grupo Alvorecer e a Arte do Bem', 'osjc'); ?></h3>
                    <span class="news-date">25 de novembro de 2025</span>
                    <p><?php _e('O Grupo Alvorecer iniciou a confecção de bonequinhas de pano para doar às crianças atendidas pela instituição neste Natal, espalhando amor e esperança por meio...', 'osjc'); ?></p>
                    <a href="<?php echo esc_url(home_url('/noticias')); ?>" class="news-link"><?php _e('Ler mais →', 'osjc'); ?></a>
                </article>
                <article class="news-card">
                    <h3><?php _e('Dia da Consciência Negra: Luta e Igualdade', 'osjc'); ?></h3>
                    <span class="news-date">20 de novembro de 2025</span>
                    <p><?php _e('Hoje, lembramos Zumbi dos Palmares e a luta contra a escravidão. A Osceia promove a inclusão social, trabalhando por um futuro mais justo e igualitário....', 'osjc'); ?></p>
                    <a href="<?php echo esc_url(home_url('/noticias')); ?>" class="news-link"><?php _e('Ler mais →', 'osjc'); ?></a>
                </article>
                <article class="news-card">
                    <h3><?php _e('Campanha Natal com Jesus: Doe e Espalhe Esperança', 'osjc'); ?></h3>
                    <span class="news-date">17 de novembro de 2025</span>
                    <p><?php _e('A Osceia promove a Campanha Natal com Jesus, com doações até 12/12....', 'osjc'); ?></p>
                    <a href="<?php echo esc_url(home_url('/noticias')); ?>" class="news-link"><?php _e('Ler mais →', 'osjc'); ?></a>
                </article>
            </div>
            <div class="news-cta">
                <a href="<?php echo esc_url(home_url('/noticias')); ?>" class="btn-secondary"><?php _e('Mostrar mais notícias', 'osjc'); ?></a>
            </div>
        </div>
    </section>

    <!-- 10. FEED INSTAGRAM -->
    <section class="instagram-feed-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Siga-nos no Instagram', 'osjc'); ?></span>
                <h2><?php _e('Nosso Feed', 'osjc'); ?></h2>
            </div>
            <div class="instagram-cta">
                <a href="https://www.instagram.com/jeronimocandinho.osjc?igsh=NHlmb3NxN2p0ODh1" target="_blank" rel="noopener" class="btn-secondary"><?php _e('Seguir no Instagram', 'osjc'); ?></a>
            </div>
        </div>
    </section>

    <!-- 9. SELOS -->
    <section class="badges-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Certificações e reconhecimentos', 'osjc'); ?></span>
                <h2><?php _e('Nossos Selos e Certificações', 'osjc'); ?></h2>
            </div>
            <p class="badges-description"><?php _e('Reconhecimentos que atestam nosso compromisso com a transparência, qualidade e impacto social.', 'osjc'); ?></p>
            <div class="badges-grid">
                <div class="badge-item">
                    <img src="<?php echo osjc_get_asset_url('selo-doar.png'); ?>" alt="<?php esc_attr_e('Selo Doar', 'osjc'); ?>" class="badge-image" />
                    <p class="badge-label"><?php _e('Certificação', 'osjc'); ?></p>
                </div>
                <div class="badge-item">
                    <img src="<?php echo osjc_get_asset_url('selo-phomenta.png'); ?>" alt="<?php esc_attr_e('Selo Phomenta', 'osjc'); ?>" class="badge-image" />
                    <p class="badge-label"><?php _e('Reconhecimento', 'osjc'); ?></p>
                </div>
                <div class="badge-item">
                    <img src="<?php echo osjc_get_asset_url('Selo-Empresa-Amiga-da-Juventude-JPEG.jpeg.jpg'); ?>" alt="<?php esc_attr_e('Selo Empresa Amiga da Juventude', 'osjc'); ?>" class="badge-image" />
                    <p class="badge-label"><?php _e('Premiação', 'osjc'); ?></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
