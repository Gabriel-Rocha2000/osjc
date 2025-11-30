# Como Obter Links Diretos de Imagens do Instagram

## Método 1: Via Navegador (Mais Fácil)

1. **Abra o post do Instagram no navegador** (versão web)
   - Acesse: `https://www.instagram.com/p/CODIGO_DO_POST/`
   - Ou abra o post e copie a URL da barra de endereços

2. **Obtenha o link da imagem:**
   - **Opção A**: Clique com botão direito na imagem → "Copiar endereço da imagem"
   - **Opção B**: Pressione F12 (ou clique direito → Inspect Element)
     - Procure pela tag `<img>` na aba Elements/Inspector
     - Copie o valor do atributo `src`

3. **Cole o link no HTML:**
   - Substitua `SEU_POST_ID_X` pelo código do post
   - Ou substitua diretamente o `src` da imagem pelo link copiado

## Método 2: Usando Ferramentas Online

1. **Acesse ferramentas como:**
   - https://www.instadownloader.com/
   - https://downloadgram.com/
   - https://instafinsta.com/

2. Cole a URL do post do Instagram
3. Copie o link direto da imagem
4. Use no HTML

## Método 3: Via URL do Post (Formato Padrão)

O Instagram permite acessar imagens através de URLs no formato:
```
https://instagram.com/p/CODIGO_DO_POST/media/?size=l
```

Onde:
- `CODIGO_DO_POST` é o código único do post (ex: `C1xYz2AbC3d`)
- `size=l` significa "large" (grande)
- Outros tamanhos: `size=m` (medium), `size=t` (thumbnail)

## Exemplo Prático:

1. Post do Instagram: `https://www.instagram.com/p/C1xYz2AbC3d/`
2. Link da imagem: `https://instagram.com/p/C1xYz2AbC3d/media/?size=l`
3. No HTML:
   ```html
   <a href="https://www.instagram.com/p/C1xYz2AbC3d/" target="_blank">
       <img src="https://instagram.com/p/C1xYz2AbC3d/media/?size=l" alt="Post Instagram" />
   </a>
   ```

## Dicas:

- ✅ Use `size=l` para melhor qualidade
- ✅ Sempre atualize o `href` com o link completo do post
- ✅ O atributo `onerror` garante que uma imagem placeholder apareça se o link falhar
- ⚠️ Links do Instagram podem expirar, então atualize periodicamente
- ⚠️ Alguns posts podem ter restrições de acesso

## Atualização Rápida:

Para atualizar o feed, basta:
1. Abrir os 6 posts mais recentes do Instagram
2. Copiar os links das imagens
3. Substituir no arquivo `index.html` nas tags `<img src="...">`
4. Atualizar também os links `<a href="...">` com os links completos dos posts

