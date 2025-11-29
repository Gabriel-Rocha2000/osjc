# Configuração do GitHub Pages

## Problema Comum
O GitHub Pages por padrão procura o `index.html` na raiz do repositório, mas neste projeto os arquivos estão na pasta `site/`.

## Soluções

### Opção 1: Configurar GitHub Pages para usar a pasta `site/` (Recomendado)

1. No GitHub, vá para: **Settings** → **Pages**
2. Em **Source**, selecione: **Deploy from a branch**
3. Em **Branch**, selecione: **main** (ou **master**)
4. Em **Folder**, selecione: **/site**
5. Clique em **Save**

### Opção 2: Mover arquivos para a raiz (Alternativa)

Se a Opção 1 não funcionar, você pode mover o conteúdo da pasta `site/` para a raiz:

```bash
# Fazer backup primeiro
cp -r site site_backup

# Mover arquivos para raiz
mv site/* .
mv site/.gitignore . 2>/dev/null || true
rmdir site
```

**⚠️ Atenção:** Isso vai mudar a estrutura do projeto. Use apenas se necessário.

## Passos para Publicar

1. **Adicionar e commitar as mudanças:**
```bash
git add .
git commit -m "Atualizar site com logo e página de notícias"
```

2. **Enviar para o GitHub:**
```bash
git push origin main
```

3. **Aguardar o deploy:**
   - O GitHub Pages leva alguns minutos para fazer o deploy
   - Você pode verificar o progresso em: **Settings** → **Pages**
   - O site ficará disponível em: `https://gabriel-rocha2000.github.io/osjc/`

## Verificar se está funcionando

1. Acesse: https://github.com/Gabriel-Rocha2000/osjc/settings/pages
2. Verifique se há uma mensagem de sucesso
3. Aguarde 1-2 minutos após o push
4. Acesse: https://gabriel-rocha2000.github.io/osjc/

## Troubleshooting

### Erro 404
- Verifique se o `index.html` está na pasta configurada
- Verifique se a branch está correta
- Aguarde alguns minutos (o deploy pode demorar)

### Imagens não aparecem
- Verifique se os caminhos das imagens estão corretos
- Imagens devem usar caminhos relativos (não absolutos começando com `/`)

### CSS não carrega
- Verifique se o caminho do CSS está correto
- Use caminhos relativos: `css/style.css` (não `/css/style.css`)


