# Como Executar o Site

Este é um site estático HTML que pode ser visualizado de várias formas:

## Método 1: Abrir Diretamente no Navegador (Mais Simples)

1. Navegue até a pasta `site/`
2. Clique duas vezes no arquivo `index.html`
3. O site abrirá no seu navegador padrão

**Ou via terminal:**
```bash
cd site
xdg-open index.html  # Linux
# ou
open index.html      # macOS
# ou simplesmente arraste o arquivo para o navegador
```

## Método 2: Servidor HTTP Local (Recomendado)

Para uma experiência mais próxima de um servidor real, use um servidor HTTP local:

### Python 3 (já instalado)
```bash
cd site
python3 -m http.server 8000
```
Depois acesse: http://localhost:8000

### Python 2
```bash
cd site
python -m SimpleHTTPServer 8000
```

### Node.js (se tiver instalado)
```bash
cd site
npx http-server -p 8000
```

### PHP (se tiver instalado)
```bash
cd site
php -S localhost:8000
```

## Método 3: Regenerar o Site

Se você modificou o arquivo XML original e quer regenerar o site:

```bash
cd /home/gabriel/Área\ de\ trabalho/osjc
python3 convert_to_html.py
```

## Estrutura do Site

```
site/
├── index.html          # Página inicial - COMECE AQUI!
├── posts.html          # Lista de todos os posts
├── pages.html          # Lista de todas as páginas
├── css/
│   └── style.css       # Estilos
├── js/
│   └── main.js        # JavaScript
├── posts/
│   ├── categorias/    # Posts organizados por categoria
│   ├── datas/         # Posts organizados por data (ano/mês)
│   └── todos/         # Todos os posts
└── pages/
    └── todas/         # Todas as páginas
```

## Hospedagem Online

Este site pode ser hospedado gratuitamente em:

- **GitHub Pages**: Faça upload da pasta `site/` para um repositório GitHub
- **Netlify**: Arraste a pasta `site/` para netlify.com
- **Vercel**: Use o CLI do Vercel para fazer deploy
- **Qualquer servidor web**: Faça upload dos arquivos via FTP/SFTP

## Notas Importantes

- Todos os links são relativos, então o site funciona mesmo offline
- Não é necessário banco de dados ou servidor especial
- Funciona em qualquer navegador moderno
- Os arquivos podem ser editados diretamente se necessário

## Solução de Problemas

**Links não funcionam?**
- Certifique-se de abrir o `index.html` da pasta `site/`, não de subpastas
- Use um servidor HTTP local (Método 2) para melhor compatibilidade

**CSS não carrega?**
- Verifique se a pasta `css/` está no mesmo nível que `index.html`
- Use um servidor HTTP local para evitar problemas de CORS

**Quer modificar algo?**
- Edite os arquivos HTML diretamente
- Ou modifique `convert_to_html.py` e regenere o site
