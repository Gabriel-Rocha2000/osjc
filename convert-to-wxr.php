<?php
/**
 * Script para converter HTML estático em XML WXR (WordPress eXtended RSS)
 * 
 * Converte todos os posts e páginas HTML em formato XML para importação no WordPress
 */

// Configurações
$site_dir = __DIR__ . '/site';
$output_file = __DIR__ . '/wordpress-import.xml';
$base_url = 'https://osjc.org.br';

// Iniciar XML com indentação
$xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
$xml .= '<rss version="2.0"';
$xml .= ' xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"';
$xml .= ' xmlns:content="http://purl.org/rss/1.0/modules/content/"';
$xml .= ' xmlns:wfw="http://wellformedweb.org/CommentAPI/"';
$xml .= ' xmlns:dc="http://purl.org/dc/elements/1.1/"';
$xml .= ' xmlns:wp="http://wordpress.org/export/1.2/">' . "\n";
$xml .= '<channel>' . "\n";

// Informações básicas do channel
$xml .= "\t<title>Obras Sociais do Centro Espírita Fraternidade Jerônimo Candinho</title>\n";
$xml .= "\t<link>" . escape_xml($base_url) . "</link>\n";
$xml .= "\t<description>Site das Obras Sociais do Centro Espírita Fraternidade Jerônimo Candinho</description>\n";
$xml .= "\t<pubDate>" . date('r') . "</pubDate>\n";
$xml .= "\t<language>pt-BR</language>\n";
$xml .= "\t<wp:wxr_version>1.2</wp:wxr_version>\n";
$xml .= "\t<wp:base_site_url>" . escape_xml($base_url) . "</wp:base_site_url>\n";
$xml .= "\t<wp:base_blog_url>" . escape_xml($base_url) . "</wp:base_blog_url>\n";
$xml .= "\t<generator>https://wordpress.org/?v=6.4</generator>\n";

// Adicionar autor padrão (necessário para o WordPress)
$xml .= "\t<wp:author>\n";
$xml .= "\t\t<wp:author_id>1</wp:author_id>\n";
$xml .= "\t\t<wp:author_login>admin</wp:author_login>\n";
$xml .= "\t\t<wp:author_email>admin@example.com</wp:author_email>\n";
$xml .= "\t\t<wp:author_display_name><![CDATA[admin]]></wp:author_display_name>\n";
$xml .= "\t\t<wp:author_first_name><![CDATA[]]></wp:author_first_name>\n";
$xml .= "\t\t<wp:author_last_name><![CDATA[]]></wp:author_last_name>\n";
$xml .= "\t</wp:author>\n";

$post_id = 1;
$page_id = 1000;

/**
 * Função para escapar XML
 */
function escape_xml($text) {
    return htmlspecialchars($text, ENT_XML1, 'UTF-8');
}

/**
 * Função para fechar tags HTML não fechadas
 */
function close_html_tags($html) {
    // Lista de tags que não precisam fechamento
    $void_tags = array('area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr');
    
    // Remover comentários HTML
    $html = preg_replace('/<!--.*?-->/s', '', $html);
    
    // Encontrar todas as tags abertas
    preg_match_all('/<([a-z][a-z0-9]*)\b[^>]*>/i', $html, $open_tags);
    preg_match_all('/<\/([a-z][a-z0-9]*)>/i', $html, $close_tags);
    
    $open = array();
    $close = array();
    
    foreach ($open_tags[1] as $tag) {
        $tag_lower = strtolower($tag);
        if (!in_array($tag_lower, $void_tags)) {
            $open[] = $tag_lower;
        }
    }
    
    foreach ($close_tags[1] as $tag) {
        $close[] = strtolower($tag);
    }
    
    // Reverter array de fechamento para empilhar corretamente
    $close = array_reverse($close);
    
    // Criar pilha de tags abertas
    $stack = array();
    foreach ($open as $tag) {
        // Se a tag está na lista de fechamento, remove da pilha
        $key = array_search($tag, $close);
        if ($key !== false) {
            unset($close[$key]);
        } else {
            // Adiciona na pilha
            $stack[] = $tag;
        }
    }
    
    // Fechar tags que ficaram abertas
    $closing_tags = '';
    $stack = array_reverse($stack);
    foreach ($stack as $tag) {
        $closing_tags .= "</$tag>";
    }
    
    return $html . $closing_tags;
}

/**
 * Função para extrair conteúdo de HTML
 */
function extract_content($html) {
    // Remove header, footer, nav, scripts
    $html = preg_replace('/<header.*?<\/header>/is', '', $html);
    $html = preg_replace('/<footer.*?<\/footer>/is', '', $html);
    $html = preg_replace('/<nav.*?<\/nav>/is', '', $html);
    $html = preg_replace('/<script.*?<\/script>/is', '', $html);
    $html = preg_replace('/<style.*?<\/style>/is', '', $html);
    
    // Extrai conteúdo do post
    $content = '';
    if (preg_match('/<div class="post-content">(.*?)<\/div>/is', $html, $matches)) {
        $content = $matches[1];
    } elseif (preg_match('/<main[^>]*>(.*?)<\/main>/is', $html, $matches)) {
        $content = $matches[1];
        // Remove título do conteúdo se presente
        $content = preg_replace('/<h1[^>]*>.*?<\/h1>/is', '', $content);
    }
    
    // Limpa o conteúdo (mas mantém estrutura HTML válida)
    $content = preg_replace('/<!-- wp:.*?-->/is', '', $content);
    
    // Corrige tags não fechadas comuns
    $content = preg_replace('/<p([^>]*)>(?!\s*<\/p>)/is', '<p$1>', $content);
    
    // Remove divs vazios (mas preserva conteúdo)
    $content = preg_replace('/<div[^>]*>\s*<\/div>/is', '', $content);
    
    // Normaliza espaços em branco (mas preserva quebras de linha em HTML)
    $content = preg_replace('/\s+/', ' ', $content);
    $content = str_replace('> ', '>', $content);
    $content = str_replace(' <', '<', $content);
    
    $content = trim($content);
    
    // Fecha tags não fechadas
    if (!empty($content)) {
        $content = close_html_tags($content);
    }
    
    return $content;
}

/**
 * Função para extrair título
 */
function extract_title($html, $filename) {
    // Tenta pegar do título da página
    if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
        $title = trim(strip_tags($matches[1]));
        // Remove sufixo do título do site
        $title = preg_replace('/\s*-\s*Obras Sociais.*$/i', '', $title);
        if (!empty($title)) {
            return $title;
        }
    }
    
    // Tenta pegar do h1
    if (preg_match('/<h1[^>]*class="post-title"[^>]*>(.*?)<\/h1>/is', $html, $matches)) {
        return trim(strip_tags($matches[1]));
    }
    
    // Se não encontrar, usa o nome do arquivo
    $title = basename($filename, '.html');
    $title = str_replace('-', ' ', $title);
    $title = ucwords($title);
    
    return $title;
}

/**
 * Função para extrair data do nome do arquivo ou caminho
 */
function extract_date($filepath) {
    // Tenta extrair data do caminho (ex: posts/datas/2024/11/arquivo.html)
    if (preg_match('#posts/datas/(\d{4})/(\d{2})/#', $filepath, $matches)) {
        $year = $matches[1];
        $month = $matches[2];
        $day = '01';
        return "$year-$month-$day 12:00:00";
    }
    
    // Se não encontrar, usa data atual
    return date('Y-m-d H:i:s');
}

/**
 * Função para criar item XML
 */
function create_item($title, $content, $date, $type, $id, $slug, $base_url) {
    // Garantir que o slug não esteja vazio
    if (empty($slug)) {
        $slug = 'post-' . $id;
    }
    
    // Garantir que o título não esteja vazio
    if (empty($title) || trim($title) === '' || trim($title) === 'Sem título') {
        $title = 'Post ' . $id;
    }
    
    // Criar URL completa para link e guid
    $permalink = $base_url . '/' . $slug . '/';
    $guid_url = $base_url . '/?p=' . $id;
    
    // Formatar data corretamente
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        $timestamp = time();
    }
    $post_date = date('Y-m-d H:i:s', $timestamp);
    $post_date_gmt = gmdate('Y-m-d H:i:s', $timestamp);
    $pub_date_rfc = date('r', $timestamp);
    
    $item = "\t<item>\n";
    $item .= "\t\t<title>" . escape_xml($title) . "</title>\n";
    $item .= "\t\t<link>" . escape_xml($permalink) . "</link>\n";
    $item .= "\t\t<pubDate>" . $pub_date_rfc . "</pubDate>\n";
    $item .= "\t\t<dc:creator><![CDATA[admin]]></dc:creator>\n";
    $item .= "\t\t<guid isPermaLink=\"false\">" . escape_xml($guid_url) . "</guid>\n";
    $item .= "\t\t<description></description>\n";
    $item .= "\t\t<content:encoded><![CDATA[" . $content . "]]></content:encoded>\n";
    $item .= "\t\t<excerpt:encoded><![CDATA[]]></excerpt:encoded>\n";
    $item .= "\t\t<wp:post_id>" . $id . "</wp:post_id>\n";
    $item .= "\t\t<wp:post_date>" . $post_date . "</wp:post_date>\n";
    $item .= "\t\t<wp:post_date_gmt>" . $post_date_gmt . "</wp:post_date_gmt>\n";
    $item .= "\t\t<wp:post_modified>" . $post_date . "</wp:post_modified>\n";
    $item .= "\t\t<wp:post_modified_gmt>" . $post_date_gmt . "</wp:post_modified_gmt>\n";
    $item .= "\t\t<wp:comment_status>closed</wp:comment_status>\n";
    $item .= "\t\t<wp:ping_status>closed</wp:ping_status>\n";
    $item .= "\t\t<wp:post_name>" . escape_xml($slug) . "</wp:post_name>\n";
    $item .= "\t\t<wp:status>publish</wp:status>\n";
    $item .= "\t\t<wp:post_parent>0</wp:post_parent>\n";
    $item .= "\t\t<wp:menu_order>0</wp:menu_order>\n";
    $item .= "\t\t<wp:post_type>" . escape_xml($type) . "</wp:post_type>\n";
    $item .= "\t\t<wp:post_password></wp:post_password>\n";
    $item .= "\t\t<wp:is_sticky>0</wp:is_sticky>\n";
    $item .= "\t</item>\n";
    
    return $item;
}

/**
 * Função para criar slug
 */
function create_slug($filename) {
    $slug = basename($filename, '.html');
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

echo "🔄 Processando posts...\n";

// Processar posts
$posts_dir = $site_dir . '/posts/todos';
$posts_count = 0;

if (is_dir($posts_dir)) {
    $files = glob($posts_dir . '/*.html');
    
    foreach ($files as $file) {
        $html = @file_get_contents($file);
        if ($html === false) continue;
        
        $title = extract_title($html, $file);
        $content = extract_content($html);
        
        if (empty($title) || empty($content)) {
            continue;
        }
        
        $date = extract_date($file);
        $slug = create_slug($file);
        
        // Garantir que o slug não esteja vazio
        if (empty($slug)) {
            $slug = 'post-' . $post_id;
        }
        
        $xml .= create_item($title, $content, $date, 'post', $post_id, $slug, $base_url);
        
        $post_id++;
        $posts_count++;
    }
}

// Processar posts por data (se existirem)
$posts_datas_dir = $site_dir . '/posts/datas';
if (is_dir($posts_datas_dir)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($posts_datas_dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'html' && basename($file->getFilename()) !== 'index.html') {
            $filepath = $file->getPathname();
            $html = @file_get_contents($filepath);
            if ($html === false) continue;
            
            $title = extract_title($html, $filepath);
            $content = extract_content($html);
            
            if (empty($title) || empty($content)) {
                continue;
            }
            
            $date = extract_date($filepath);
            $slug = create_slug(basename($filepath));
            
            // Garantir que o slug não esteja vazio
            if (empty($slug)) {
                $slug = 'post-' . $post_id;
            }
            
            $xml .= create_item($title, $content, $date, 'post', $post_id, $slug, $base_url);
            
            $post_id++;
            $posts_count++;
        }
    }
}

// Processar posts por categoria (se existirem)
$posts_cat_dir = $site_dir . '/posts/categorias';
if (is_dir($posts_cat_dir)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($posts_cat_dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'html' && basename($file->getFilename()) !== 'index.html') {
            $filepath = $file->getPathname();
            $html = @file_get_contents($filepath);
            if ($html === false) continue;
            
            $title = extract_title($html, $filepath);
            $content = extract_content($html);
            
            if (empty($title) || empty($content)) {
                continue;
            }
            
            $date = extract_date($filepath);
            $slug = create_slug(basename($filepath));
            
            // Garantir que o slug não esteja vazio
            if (empty($slug)) {
                $slug = 'post-' . $post_id;
            }
            
            $xml .= create_item($title, $content, $date, 'post', $post_id, $slug, $base_url);
            
            $post_id++;
            $posts_count++;
        }
    }
}

echo "✅ Encontrados {$posts_count} posts.\n";
echo "🔄 Processando páginas...\n";

// Processar páginas
$pages_dir = $site_dir . '/pages/todas';
$pages_count = 0;

if (is_dir($pages_dir)) {
    $files = glob($pages_dir . '/*.html');
    
    foreach ($files as $file) {
        $html = @file_get_contents($file);
        if ($html === false) continue;
        
        $title = extract_title($html, $file);
        $content = extract_content($html);
        
        if (empty($title) || empty($content)) {
            continue;
        }
        
        $date = extract_date($file);
        $slug = create_slug($file);
        
        // Garantir que o slug não esteja vazio
        if (empty($slug)) {
            $slug = 'page-' . $page_id;
        }
        
        $xml .= create_item($title, $content, $date, 'page', $page_id, $slug, $base_url);
        
        $page_id++;
        $pages_count++;
    }
}

// Processar páginas principais (quem-somos.html, doe-aqui.html, etc.)
$main_pages = ['quem-somos.html', 'doe-aqui.html'];
foreach ($main_pages as $page_file) {
    $file = $site_dir . '/' . $page_file;
    if (file_exists($file)) {
        $html = @file_get_contents($file);
        if ($html === false) continue;
        
        $title = extract_title($html, $file);
        $content = extract_content($html);
        
        if (!empty($title) && !empty($content)) {
            $date = extract_date($file);
            $slug = create_slug($file);
            
            // Garantir que o slug não esteja vazio
            if (empty($slug)) {
                $slug = 'page-' . $page_id;
            }
            
            $xml .= create_item($title, $content, $date, 'page', $page_id, $slug, $base_url);
            
            $page_id++;
            $pages_count++;
        }
    }
}

echo "✅ Encontradas {$pages_count} páginas.\n";

// Fechar XML
$xml .= "</channel>\n";
$xml .= "</rss>\n";

// Salvar arquivo com BOM UTF-8 (alguns sistemas podem precisar)
// Remover BOM para compatibilidade máxima
$xml_final = $xml;
// Adicionar quebra de linha final
$xml_final .= "\n";

// Salvar arquivo
file_put_contents($output_file, $xml_final);

// Verificar se o arquivo foi salvo corretamente
if (filesize($output_file) === 0) {
    die("❌ Erro: Arquivo XML está vazio!\n");
}

echo "\n✅ Conversão concluída!\n";
echo "📄 Arquivo gerado: {$output_file}\n";
echo "📊 Estatísticas:\n";
echo "   - Posts: " . ($post_id - 1) . "\n";
echo "   - Páginas: " . ($page_id - 1000) . "\n";
echo "\n📋 Próximos passos:\n";
echo "1. Acesse o WordPress\n";
echo "2. Vá em Ferramentas > Importar > WordPress\n";
echo "3. Faça upload do arquivo: {$output_file}\n";
echo "4. Siga as instruções de importação\n";

?>
