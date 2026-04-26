# Tema WordPress OSJC

Tema WordPress customizado para as Obras Sociais do Centro Espírita Fraternidade Jerônimo Candinho.

## ✅ Características

- **100% do HTML original preservado** - Nenhum layout ou estrutura foi alterada
- **CSS e JS originais mantidos** - Todos os estilos e funcionalidades JavaScript preservados
- **Sem page builders** - Código limpo e profissional, sem dependências de Elementor ou editores visuais
- **Performance otimizada** - Assets enfileirados corretamente via WordPress
- **Pronto para tradução** - Textos preparados para internacionalização

## 📁 Estrutura do Tema

```
wordpress-theme/
├── style.css              # Header do tema WordPress
├── functions.php          # Funções principais e enfileiramento
├── header.php             # Cabeçalho do site
├── footer.php             # Rodapé do site
├── front-page.php         # Página inicial
├── index.php              # Template padrão (listagem de posts)
└── assets/
    ├── css/
    │   ├── style.css      # CSS principal (original)
    │   └── doe-aqui.css   # CSS da página Doe Aqui (original)
    ├── js/
    │   ├── main.js        # JavaScript principal (original)
    │   ├── doe-aqui.js    # JavaScript da página Doe Aqui (original)
    │   └── instagram-feed.js  # JavaScript do feed do Instagram (original)
    └── images/            # Todas as imagens do site original
```

## 🚀 Instalação

1. **Copie o tema para o WordPress:**
   ```bash
   cp -r wordpress-theme /caminho/para/wordpress/wp-content/themes/osjc
   ```

2. **No WordPress Admin:**
   - Vá em **Aparência > Temas**
   - Encontre o tema "OSJC Theme"
   - Clique em **Ativar**

3. **Configure o tema:**
   - Vá em **Aparência > Personalizar**
   - Configure o logo, menus e outras opções
   - Vá em **Aparência > Menus** para criar e configurar menus
   - Atribua o menu principal ao localização "Menu Principal"

## 📝 Arquivos Criados

### `style.css`
Header do tema WordPress (obrigatório). Contém informações do tema.

### `functions.php`
- Configuração do tema (`osjc_setup()`)
- Enfileiramento de CSS e JS (`osjc_scripts()`)
- Funções auxiliares para URLs de imagens
- Menu de fallback
- Suporte para logo customizado, menus, thumbnails, etc.

### `header.php`
- Cabeçalho HTML original adaptado para WordPress
- Integração com `wp_head()`
- Menu WordPress com fallback
- Logo customizado ou padrão
- Links sociais preservados

### `footer.php`
- Rodapé HTML original adaptado para WordPress
- Integração com `wp_footer()`
- Menu do rodapé
- Modal de imagem preservado
- Newsletter form preservado

### `front-page.php`
- Conteúdo completo da página inicial do site original
- Todas as seções preservadas:
  - Banner/Carrossel
  - Depoimentos
  - Programas
  - Números/Estatísticas
  - Missão, Visão e Valores
  - Parceiros
  - Blog
  - Notícias
  - Feed Instagram
  - Selos

### `index.php`
Template padrão para listagem de posts, arquivos e outras páginas dinâmicas.

## 🔧 Funcionalidades WordPress

### Enfileiramento de Assets

Todos os CSS e JS são enfileirados via `wp_enqueue_style()` e `wp_enqueue_script()` no `functions.php`:

- **CSS Principal:** Sempre carregado
- **CSS Doe Aqui:** Carregado apenas na página "Doe Aqui"
- **Font Awesome:** Carregado apenas quando necessário (páginas que precisam de ícones)
- **JavaScript:** Todos os scripts originais preservados e enfileirados corretamente

### Menus

O tema suporta 2 menus:
- **Menu Principal:** Menu de navegação no header
- **Menu Rodapé:** Menu de navegação no footer

Se nenhum menu for configurado, um menu de fallback é exibido automaticamente.

### Logo Customizado

- Suporte para logo customizado via WordPress
- Se não houver logo configurado, usa a imagem padrão do site

### Tradução

Todos os textos estão preparados para tradução usando:
- `__()` para strings
- `_e()` para strings com echo
- `esc_attr_e()` para atributos HTML
- Text Domain: `osjc`

## 📸 Imagens

Todas as imagens foram copiadas para `assets/images/` e são acessadas via:
- `osjc_get_image_url($filename)` - Para imagens principais
- `osjc_get_asset_url($filename)` - Para assets/ícones

## ⚠️ Importante

- **Nenhum código JavaScript foi alterado** - Todas as funcionalidades originais estão preservadas
- **Nenhum CSS foi alterado** - Todos os estilos originais estão preservados
- **Layout idêntico** - A estrutura HTML foi mantida 100% fiel ao original
- **Performance mantida** - Assets são carregados apenas quando necessário

## 🎯 Próximos Passos

1. Configure os menus no WordPress Admin
2. Configure o logo em Aparência > Personalizar
3. Crie as páginas necessárias (Quem Somos, Programas, Blog, etc.)
4. Configure as páginas estáticas em Configurações > Leitura
5. Teste todas as funcionalidades JavaScript

## 📚 Recursos

- [Documentação do WordPress](https://developer.wordpress.org/themes/)
- [Codex WordPress](https://codex.wordpress.org/)

---

**Desenvolvido mantendo 100% da fidelidade ao código HTML, CSS e JavaScript original.**

