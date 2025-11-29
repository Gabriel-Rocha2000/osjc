#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Conversor de XML WordPress para HTML, CSS e JavaScript
"""

import xml.etree.ElementTree as ET
import os
import re
import html
from datetime import datetime
from urllib.parse import urlparse
import json

# Namespaces
NS = {
    'wp': 'http://wordpress.org/export/1.2/',
    'content': 'http://purl.org/rss/1.0/modules/content/',
    'dc': 'http://purl.org/dc/elements/1.1/',
    'excerpt': 'http://wordpress.org/export/1.2/excerpt/'
}

class WordPressConverter:
    def __init__(self, xml_file, output_dir='site'):
        self.xml_file = xml_file
        self.output_dir = output_dir
        self.posts = []
        self.pages = []
        self.categories = {}
        self.authors = {}
        self.site_title = ""
        self.site_url = ""
        
    def sanitize_filename(self, name):
        """Converte string em nome de arquivo válido"""
        name = re.sub(r'[^\w\s-]', '', name)
        name = re.sub(r'[-\s]+', '-', name)
        return name.lower()
    
    def clean_html(self, html_content):
        """Limpa e sanitiza HTML"""
        if not html_content:
            return ""
        # Remove scripts e estilos inline perigosos
        html_content = re.sub(r'<script[^>]*>.*?</script>', '', html_content, flags=re.DOTALL | re.IGNORECASE)
        html_content = re.sub(r'<style[^>]*>.*?</style>', '', html_content, flags=re.DOTALL | re.IGNORECASE)
        # Converte URLs absolutas para relativas onde possível
        html_content = html_content.replace('https://jeronimocandinho.org', '')
        html_content = html_content.replace('http://www.jeronimocandinho.org', '')
        return html_content.strip()
    
    def parse_xml(self):
        """Parse do arquivo XML"""
        print("Lendo arquivo XML...")
        tree = ET.parse(self.xml_file)
        root = tree.getroot()
        channel = root.find('channel')
        
        # Informações do site
        title_elem = channel.find('title')
        self.site_title = title_elem.text if title_elem is not None else "Site"
        
        link_elem = channel.find('link')
        self.site_url = link_elem.text if link_elem is not None else ""
        
        # Autores
        for author in channel.findall('wp:author', NS):
            author_id = author.find('wp:author_id', NS)
            login = author.find('wp:author_login', NS)
            display_name = author.find('wp:author_display_name', NS)
            if author_id is not None and login is not None:
                self.authors[author_id.text] = {
                    'login': login.text if login.text else '',
                    'display_name': display_name.text if display_name is not None and display_name.text else login.text
                }
        
        # Categorias
        for cat in channel.findall('wp:category', NS):
            term_id = cat.find('wp:term_id', NS)
            cat_name = cat.find('wp:cat_name', NS)
            nicename = cat.find('wp:category_nicename', NS)
            if term_id is not None and cat_name is not None:
                self.categories[term_id.text] = {
                    'name': cat_name.text,
                    'slug': nicename.text if nicename is not None and nicename.text else ''
                }
        
        # Itens (posts, páginas, etc)
        items = channel.findall('item')
        print(f"Processando {len(items)} itens...")
        
        for item in items:
            post_type = item.find('wp:post_type', NS)
            if post_type is None:
                continue
            
            post_type_text = post_type.text
            
            # Apenas posts e páginas publicados
            if post_type_text in ['post', 'page']:
                status = item.find('wp:status', NS)
                if status is None or status.text != 'publish':
                    continue
                
                title = item.find('title')
                title_text = title.text if title is not None and title.text else "Sem título"
                
                content = item.find('content:encoded', NS)
                content_text = self.clean_html(content.text if content is not None and content.text else "")
                
                post_id = item.find('wp:post_id', NS)
                post_id_text = post_id.text if post_id is not None else ""
                
                post_name = item.find('wp:post_name', NS)
                post_slug = post_name.text if post_name is not None and post_name.text else self.sanitize_filename(title_text)
                
                post_date = item.find('wp:post_date', NS)
                post_date_text = post_date.text if post_date is not None else ""
                
                creator = item.find('dc:creator', NS)
                author = creator.text if creator is not None else ""
                
                # Categorias do post
                post_categories = []
                for cat in item.findall('category'):
                    domain = cat.get('domain', '')
                    if domain == 'category':
                        post_categories.append(cat.text)
                
                post_data = {
                    'id': post_id_text,
                    'title': title_text,
                    'content': content_text,
                    'slug': post_slug,
                    'date': post_date_text,
                    'author': author,
                    'categories': post_categories,
                    'type': post_type_text
                }
                
                if post_type_text == 'post':
                    self.posts.append(post_data)
                elif post_type_text == 'page':
                    self.pages.append(post_data)
        
        print(f"Encontrados {len(self.posts)} posts e {len(self.pages)} páginas")
    
    def generate_html_page(self, title, content, template='default', depth=0):
        """Gera HTML para uma página
        depth: número de níveis de profundidade (0 = raiz, 1 = uma pasta abaixo, etc.)
        """
        # Calcular caminho relativo baseado na profundidade
        if depth == 0:
            css_path = "css/style.css"
            js_path = "js/main.js"
            home_path = "index.html"
            posts_path = "posts.html"
            pages_path = "pages.html"
            logo_path = "LOGO-JERONIMO-NEW-1-90x90.png"
        elif depth == 1:
            css_path = "../css/style.css"
            js_path = "../js/main.js"
            home_path = "../index.html"
            posts_path = "../posts.html"
            pages_path = "../pages.html"
            logo_path = "../LOGO-JERONIMO-NEW-1-90x90.png"
        else:
            css_path = "../" * depth + "css/style.css"
            js_path = "../" * depth + "js/main.js"
            home_path = "../" * depth + "index.html"
            posts_path = "../" * depth + "posts.html"
            pages_path = "../" * depth + "pages.html"
            logo_path = "../" * depth + "LOGO-JERONIMO-NEW-1-90x90.png"
            logo_path = "../" * depth + "LOGO-JERONIMO-NEW-1-90x90.png"
        
        html_template = f"""<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{html.escape(title)} - {html.escape(self.site_title)}</title>
    <link rel="stylesheet" href="{css_path}">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-left">
                <div class="logo-circle">
                    <img src="{logo_path}" alt="Logo Jerônimo Candinho" />
                </div>
                <h1 class="site-title"><a href="{home_path}">{html.escape(self.site_title)}</a></h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="{home_path}">Início</a></li>
                    <li><a href="{pages_path}">Quem somos</a></li>
                    <li><a href="{posts_path}">O que fazemos</a></li>
                    <li><a href="{pages_path}">Compliance</a></li>
                    <li><a href="{pages_path}">Contato</a></li>
                    <li><a href="{posts_path}">Blog</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <a href="{home_path}" class="donate-button">Doe Aqui</a>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="container">
            <article class="content-post">
                <h1 class="post-title">{html.escape(title)}</h1>
                <div class="post-content">
                    {content}
                </div>
            </article>
        </div>
    </main>
    
    <footer class="site-footer">
        <div class="container">
            <p>&copy; {datetime.now().year} {html.escape(self.site_title)}. Todos os direitos reservados.</p>
        </div>
    </footer>
    
    <script src="{js_path}"></script>
</body>
</html>"""
        return html_template
    
    def generate_index(self):
        """Gera página inicial"""
        recent_posts = sorted(self.posts, key=lambda x: x['date'], reverse=True)[:10]
        
        posts_html = ""
        for post in recent_posts:
            excerpt = post['content'][:200] + "..." if len(post['content']) > 200 else post['content']
            posts_html += f"""
            <article class="post-preview">
                <h2><a href="posts/todos/{self.sanitize_filename(post['slug'])}.html">{html.escape(post['title'])}</a></h2>
                <p class="post-meta">Publicado em {post['date'][:10]} por {post['author']}</p>
                <div class="post-excerpt">{self.clean_html(excerpt)}</div>
                <a href="posts/todos/{self.sanitize_filename(post['slug'])}.html" class="read-more">Ler mais →</a>
            </article>
            """
        
        content = f"""
        <section class="hero">
            <div class="hero-left">
                <div class="hero-left-content">
                    <h1>Transformando Vidas com Amor e Educação</h1>
                    <p class="hero-subtitle">Bem-vindo às Obras Sociais do Centro Espírita Fraternidade Jerônimo Candinho. Um espaço de acolhimento, aprendizado e transformação social.</p>
                    <a href="posts.html" class="hero-button">Conheça Nossos Projetos</a>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-image-placeholder">
                    <img src="hero-poster.jpg" alt="Obras Sociais Jerônimo Candinho - Junte-se a esse projeto do bem!" />
                </div>
            </div>
        </section>
        
        <section class="stats-section">
            <div class="container">
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-number">+60</div>
                        <div class="stat-label">Alunos na Escola</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">+150</div>
                        <div class="stat-label">Enxovais Doados em 2024</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">+549</div>
                        <div class="stat-label">Jovem Candango 2024</div>
                    </div>
                    <div class="stats-cta">
                        <a href="pages/todas/contato.html" class="contact-button">Fale Conosco</a>
                        <a href="https://wa.me/5561981691123" class="whatsapp-icon" target="_blank" rel="noopener" aria-label="WhatsApp">💬</a>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="recent-posts-cta">
            <div class="container">
                <div class="recent-posts-cta-content">
                    <h2>Últimas Notícias e Atividades</h2>
                    <p>Fique por dentro das nossas atividades, projetos e eventos mais recentes.</p>
                    <a href="ultimas-noticias.html" class="hero-button">Ver Todas as Notícias</a>
                </div>
            </div>
        </section>
        """
        
        return self.generate_html_page("Início", content)
    
    def generate_recent_news(self):
        """Gera página de últimas notícias e atividades"""
        recent_posts = sorted(self.posts, key=lambda x: x['date'], reverse=True)[:10]
        
        posts_html = ""
        for post in recent_posts:
            excerpt = post['content'][:200] + "..." if len(post['content']) > 200 else post['content']
            posts_html += f"""
            <article class="post-preview">
                <h2><a href="posts/todos/{self.sanitize_filename(post['slug'])}.html">{html.escape(post['title'])}</a></h2>
                <p class="post-meta">Publicado em {post['date'][:10]} por {post['author']}</p>
                <div class="post-excerpt">{self.clean_html(excerpt)}</div>
                <a href="posts/todos/{self.sanitize_filename(post['slug'])}.html" class="read-more">Ler mais →</a>
            </article>
            """
        
        content = f"""
        <section class="recent-posts">
            <div class="container">
                <h1>Últimas Notícias e Atividades</h1>
                <p class="section-intro">Fique por dentro das nossas atividades, projetos e eventos mais recentes.</p>
            {posts_html if posts_html else '<p>Nenhum post encontrado.</p>'}
            </div>
        </section>
        """
        
        return self.generate_html_page("Últimas Notícias e Atividades", content)
    
    def generate_posts_list(self):
        """Gera lista de posts"""
        # Agrupar por categoria para mostrar organização
        posts_by_category = {}
        for post in self.posts:
            category = self.get_post_category_folder(post['categories'])
            if category not in posts_by_category:
                posts_by_category[category] = []
            posts_by_category[category].append(post)
        
        posts_html = ""
        for category, category_posts in sorted(posts_by_category.items()):
            category_name = category.replace('-', ' ').title()
            posts_html += f"""
            <section class="category-section">
                <h2 class="category-title">
                    <a href="posts/categorias/{category}/index.html">{html.escape(category_name)}</a>
                    <span class="post-count">({len(category_posts)} posts)</span>
                </h2>
            """
            for post in sorted(category_posts, key=lambda x: x['date'], reverse=True):
                excerpt = post['content'][:150] + "..." if len(post['content']) > 150 else post['content']
                categories_html = ", ".join([f'<span class="category-tag">{html.escape(cat)}</span>' for cat in post['categories']])
                
                posts_html += f"""
                <article class="post-item">
                    <h3><a href="posts/todos/{self.sanitize_filename(post['slug'])}.html">{html.escape(post['title'])}</a></h3>
                    <p class="post-meta">
                        Publicado em {post['date'][:10]} por {post['author']}
                        {f' | {categories_html}' if categories_html else ''}
                    </p>
                    <div class="post-excerpt">{self.clean_html(excerpt)}</div>
                    <a href="posts/todos/{self.sanitize_filename(post['slug'])}.html" class="read-more">Ler mais →</a>
                </article>
                """
            posts_html += "</section>"
        
        content = f"""
        <h1>Todos os Posts</h1>
        <div class="organization-links">
            <p><strong>Navegação:</strong></p>
            <ul>
                <li><a href="posts/categorias/">Ver por Categorias</a></li>
                <li><a href="posts/datas/">Ver por Data</a></li>
                <li><a href="posts/todos/">Ver Todos os Posts</a></li>
            </ul>
        </div>
        <div class="posts-list">
            {posts_html if posts_html else '<p>Nenhum post encontrado.</p>'}
        </div>
        """
        
        return self.generate_html_page("Posts", content)
    
    def generate_pages_list(self):
        """Gera lista de páginas"""
        pages_html = ""
        for page in sorted(self.pages, key=lambda x: x['title']):
            pages_html += f"""
            <article class="page-item">
                <h2><a href="pages/todas/{self.sanitize_filename(page['slug'])}.html">{html.escape(page['title'])}</a></h2>
                <a href="pages/todas/{self.sanitize_filename(page['slug'])}.html" class="read-more">Ver página →</a>
            </article>
            """
        
        content = f"""
        <h1>Todas as Páginas</h1>
        <div class="pages-list">
            {pages_html if pages_html else '<p>Nenhuma página encontrada.</p>'}
        </div>
        """
        
        return self.generate_html_page("Páginas", content)
    
    def generate_css(self):
        """Gera arquivo CSS"""
        css = """/* Estilos principais do site */

:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --accent-color: #e74c3c;
    --text-color: #333;
    --bg-color: #fff;
    --light-bg: #f8f9fa;
    --border-color: #dee2e6;
    --font-main: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font-main);
    color: var(--text-color);
    line-height: 1.6;
    background-color: var(--bg-color);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.site-header {
    background: var(--primary-color);
    color: white;
    padding: 1.5rem 0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.site-title {
    font-size: 1.8rem;
    margin-bottom: 1rem;
}

.site-title a {
    color: white;
    text-decoration: none;
}

.main-nav ul {
    list-style: none;
    display: flex;
    gap: 2rem;
}

.main-nav a {
    color: white;
    text-decoration: none;
    transition: opacity 0.3s;
}

.main-nav a:hover {
    opacity: 0.8;
}

/* Main Content */
.main-content {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

/* Hero Section */
.hero {
    text-align: center;
    padding: 4rem 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    margin-bottom: 3rem;
    border-radius: 8px;
}

.hero h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.hero p {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* Posts */
.post-preview, .post-item, .page-item {
    background: white;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.post-preview:hover, .post-item:hover, .page-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.post-title {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.post-title a {
    color: inherit;
    text-decoration: none;
}

.post-title a:hover {
    color: var(--secondary-color);
}

.post-meta {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.post-content {
    margin-top: 1.5rem;
    line-height: 1.8;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.post-content a {
    color: var(--secondary-color);
    text-decoration: none;
}

.post-content a:hover {
    text-decoration: underline;
}

.post-excerpt {
    color: #555;
    margin-bottom: 1rem;
}

.read-more {
    display: inline-block;
    color: var(--secondary-color);
    text-decoration: none;
    font-weight: 600;
    margin-top: 1rem;
    transition: color 0.3s;
}

.read-more:hover {
    color: var(--accent-color);
}

.category-tag {
    display: inline-block;
    background: var(--light-bg);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    margin-right: 0.5rem;
}

/* Category Sections */
.category-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
}

.category-title {
    font-size: 1.8rem;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--secondary-color);
}

.category-title a {
    color: inherit;
    text-decoration: none;
}

.category-title a:hover {
    color: var(--secondary-color);
}

.post-count {
    font-size: 1rem;
    color: #666;
    font-weight: normal;
}

.organization-links {
    background: var(--light-bg);
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.organization-links ul {
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
}

.organization-links a {
    color: var(--secondary-color);
    text-decoration: none;
    padding: 0.5rem 1rem;
    background: white;
    border-radius: 4px;
    border: 1px solid var(--border-color);
    transition: all 0.3s;
}

.organization-links a:hover {
    background: var(--secondary-color);
    color: white;
    border-color: var(--secondary-color);
}

/* Content Post */
.content-post {
    background: white;
    padding: 3rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Footer */
.site-footer {
    background: var(--primary-color);
    color: white;
    text-align: center;
    padding: 2rem 0;
    margin-top: 3rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero h1 {
        font-size: 1.8rem;
    }
    
    .hero p {
        font-size: 1rem;
    }
    
    .main-nav ul {
        flex-direction: column;
        gap: 1rem;
    }
    
    .content-post {
        padding: 1.5rem;
    }
    
    .post-preview, .post-item, .page-item {
        padding: 1.5rem;
    }
}
"""
        return css
    
    def generate_js(self):
        """Gera arquivo JavaScript"""
        js = """// JavaScript principal do site

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
    
    console.log('Site carregado com sucesso!');
});
"""
        return js
    
    def get_post_year_month(self, post_date):
        """Extrai ano e mês da data do post"""
        try:
            if post_date and len(post_date) >= 7:
                year = post_date[:4]
                month = post_date[5:7]
                return year, month
        except:
            pass
        return "sem-data", "sem-data"
    
    def get_post_category_folder(self, post_categories):
        """Retorna a pasta da categoria principal do post"""
        if post_categories:
            # Pega a primeira categoria (principal)
            main_cat = self.sanitize_filename(post_categories[0])
            return main_cat
        return "sem-categoria"
    
    def save_files(self):
        """Salva todos os arquivos gerados"""
        # Criar diretórios base
        os.makedirs(self.output_dir, exist_ok=True)
        os.makedirs(os.path.join(self.output_dir, 'css'), exist_ok=True)
        os.makedirs(os.path.join(self.output_dir, 'js'), exist_ok=True)
        
        # Criar estrutura de pastas para posts (por categoria e data)
        posts_by_category = {}
        posts_by_date = {}
        
        for post in self.posts:
            # Organizar por categoria
            category_folder = self.get_post_category_folder(post['categories'])
            if category_folder not in posts_by_category:
                posts_by_category[category_folder] = []
            posts_by_category[category_folder].append(post)
            
            # Organizar por data (ano/mês)
            year, month = self.get_post_year_month(post['date'])
            date_key = f"{year}/{month}"
            if date_key not in posts_by_date:
                posts_by_date[date_key] = []
            posts_by_date[date_key].append(post)
        
        # Criar pastas de categorias
        for category in posts_by_category.keys():
            os.makedirs(os.path.join(self.output_dir, 'posts', 'categorias', category), exist_ok=True)
        
        # Criar pastas por data
        for date_key in posts_by_date.keys():
            os.makedirs(os.path.join(self.output_dir, 'posts', 'datas', date_key), exist_ok=True)
        
        # Criar pasta geral de posts
        os.makedirs(os.path.join(self.output_dir, 'posts', 'todos'), exist_ok=True)
        
        # Criar estrutura de pastas para páginas
        os.makedirs(os.path.join(self.output_dir, 'pages', 'todas'), exist_ok=True)
        
        # Salvar CSS
        print("Gerando CSS...")
        with open(os.path.join(self.output_dir, 'css', 'style.css'), 'w', encoding='utf-8') as f:
            f.write(self.generate_css())
        
        # Salvar JavaScript
        print("Gerando JavaScript...")
        with open(os.path.join(self.output_dir, 'js', 'main.js'), 'w', encoding='utf-8') as f:
            f.write(self.generate_js())
        
        # Salvar index.html
        print("Gerando página inicial...")
        with open(os.path.join(self.output_dir, 'index.html'), 'w', encoding='utf-8') as f:
            f.write(self.generate_index())
        
        # Salvar posts.html (lista geral)
        print("Gerando lista de posts...")
        with open(os.path.join(self.output_dir, 'posts.html'), 'w', encoding='utf-8') as f:
            f.write(self.generate_posts_list())
        
        # Salvar pages.html
        print("Gerando lista de páginas...")
        with open(os.path.join(self.output_dir, 'pages.html'), 'w', encoding='utf-8') as f:
            f.write(self.generate_pages_list())
        
        # Salvar ultimas-noticias.html
        print("Gerando página de últimas notícias...")
        with open(os.path.join(self.output_dir, 'ultimas-noticias.html'), 'w', encoding='utf-8') as f:
            f.write(self.generate_recent_news())
        
        # Salvar posts por categoria
        print(f"Gerando posts organizados por categoria...")
        for category, category_posts in posts_by_category.items():
            for post in category_posts:
                filename = self.sanitize_filename(post['slug']) + '.html'
                filepath = os.path.join(self.output_dir, 'posts', 'categorias', category, filename)
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(self.generate_html_page(post['title'], post['content'], depth=2))
        
        # Salvar posts por data
        print(f"Gerando posts organizados por data...")
        for date_key, date_posts in posts_by_date.items():
            for post in date_posts:
                filename = self.sanitize_filename(post['slug']) + '.html'
                filepath = os.path.join(self.output_dir, 'posts', 'datas', date_key, filename)
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(self.generate_html_page(post['title'], post['content'], depth=3))
        
        # Salvar posts na pasta geral (todos)
        print(f"Gerando {len(self.posts)} posts na pasta geral...")
        for post in self.posts:
            filename = self.sanitize_filename(post['slug']) + '.html'
            filepath = os.path.join(self.output_dir, 'posts', 'todos', filename)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(self.generate_html_page(post['title'], post['content'], depth=2))
        
        # Salvar páginas individuais
        print(f"Gerando {len(self.pages)} páginas individuais...")
        for page in self.pages:
            filename = self.sanitize_filename(page['slug']) + '.html'
            filepath = os.path.join(self.output_dir, 'pages', 'todas', filename)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(self.generate_html_page(page['title'], page['content'], depth=2))
        
        # Gerar páginas de índice por categoria
        print("Gerando índices por categoria...")
        for category, category_posts in posts_by_category.items():
            category_name = category.replace('-', ' ').title()
            content = f"""
            <h1>Posts da categoria: {html.escape(category_name)}</h1>
            <div class="posts-list">
            """
            for post in sorted(category_posts, key=lambda x: x['date'], reverse=True):
                excerpt = post['content'][:150] + "..." if len(post['content']) > 150 else post['content']
                content += f"""
                <article class="post-item">
                    <h2><a href="{self.sanitize_filename(post['slug'])}.html">{html.escape(post['title'])}</a></h2>
                    <p class="post-meta">Publicado em {post['date'][:10]} por {post['author']}</p>
                    <div class="post-excerpt">{self.clean_html(excerpt)}</div>
                    <a href="{self.sanitize_filename(post['slug'])}.html" class="read-more">Ler mais →</a>
                </article>
                """
            content += "</div>"
            
            filepath = os.path.join(self.output_dir, 'posts', 'categorias', category, 'index.html')
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(self.generate_html_page(f"Categoria: {category_name}", content, depth=2))
        
        # Gerar páginas de índice por data
        print("Gerando índices por data...")
        for date_key, date_posts in posts_by_date.items():
            year, month = date_key.split('/')
            month_names = {
                '01': 'Janeiro', '02': 'Fevereiro', '03': 'Março', '04': 'Abril',
                '05': 'Maio', '06': 'Junho', '07': 'Julho', '08': 'Agosto',
                '09': 'Setembro', '10': 'Outubro', '11': 'Novembro', '12': 'Dezembro'
            }
            month_name = month_names.get(month, month)
            
            content = f"""
            <h1>Posts de {month_name} de {year}</h1>
            <div class="posts-list">
            """
            for post in sorted(date_posts, key=lambda x: x['date'], reverse=True):
                excerpt = post['content'][:150] + "..." if len(post['content']) > 150 else post['content']
                content += f"""
                <article class="post-item">
                    <h2><a href="{self.sanitize_filename(post['slug'])}.html">{html.escape(post['title'])}</a></h2>
                    <p class="post-meta">Publicado em {post['date'][:10]} por {post['author']}</p>
                    <div class="post-excerpt">{self.clean_html(excerpt)}</div>
                    <a href="{self.sanitize_filename(post['slug'])}.html" class="read-more">Ler mais →</a>
                </article>
                """
            content += "</div>"
            
            filepath = os.path.join(self.output_dir, 'posts', 'datas', date_key, 'index.html')
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(self.generate_html_page(f"Posts de {month_name} de {year}", content, depth=3))
        
        print(f"\n✓ Conversão concluída!")
        print(f"✓ Arquivos salvos em: {self.output_dir}/")
        print(f"✓ {len(self.posts)} posts gerados")
        print(f"✓ {len(self.pages)} páginas geradas")
        print(f"✓ Organizados em {len(posts_by_category)} categorias")
        print(f"✓ Organizados em {len(posts_by_date)} períodos (ano/mês)")
    
    def convert(self):
        """Executa a conversão completa"""
        self.parse_xml()
        self.save_files()

if __name__ == '__main__':
    xml_file = 'obrassociaisdocentroespritafraternidadejernimocandinho.WordPress.2025-11-27.xml'
    converter = WordPressConverter(xml_file)
    converter.convert()

