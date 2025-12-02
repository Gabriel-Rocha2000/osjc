# Como Obter Imagens do Instagram para o Feed

## ⚠️ Problema: Instagram Bloqueia Acesso Direto

O Instagram bloqueia o acesso direto às imagens via CORS, então links diretos não funcionam. Use uma das soluções abaixo:

---

## ✅ SOLUÇÃO 1: Baixar e Hospedar Localmente (RECOMENDADO)

### Passo a Passo:

1. **Abra o post do Instagram no navegador**
   - Acesse: `https://www.instagram.com/p/CODIGO_DO_POST/`

2. **Baixe a imagem:**
   - Clique com botão direito na imagem
   - Selecione "Salvar imagem como..." ou "Save image as..."
   - Salve no diretório `site/` com um nome descritivo
   - Exemplo: `instagram-post-1.jpg`, `instagram-post-2.jpg`, etc.

3. **Atualize o HTML:**
   ```html
   <img src="instagram-post-1.jpg" alt="Instagram Post" />
   ```

### Vantagens:
- ✅ Funciona sempre
- ✅ Carrega rápido
- ✅ Não depende de serviços externos
- ✅ Imagens ficam no seu servidor

---

## ✅ SOLUÇÃO 2: Usar Link Direto do CDN (Temporário)

### Como obter:

1. **Abra o post no Instagram (versão web)**
2. **Pressione F12** (ou clique direito → Inspect Element)
3. **Vá para a aba Network/Network**
4. **Recarregue a página (F5)**
5. **Procure por arquivos de imagem** (filtre por "img" ou "jpg")
6. **Clique no arquivo de imagem**
7. **Copie o link completo** que aparece (geralmente começa com `https://scontent.cdninstagram.com/...`)

### Exemplo:
```html
<img src="https://scontent.cdninstagram.com/v/t51.2885-15/.../image.jpg?stp=..." alt="Instagram Post" />
```

### ⚠️ Atenção:
- Esses links podem expirar
- Podem ter restrições de acesso
- Não é uma solução permanente

---

## ✅ SOLUÇÃO 3: Usar Serviço de Embed (SnapWidget)

1. **Acesse:** https://snapwidget.com/
2. **Crie um widget gratuito**
3. **Configure com seu perfil do Instagram**
4. **Copie o código embed fornecido**
5. **Substitua a seção `instagram-feed-grid` pelo código embed**

---

## ✅ SOLUÇÃO 4: Usar API com Proxy (Avançado)

Se você tiver um servidor backend, pode criar um proxy que busca as imagens do Instagram e as serve através do seu domínio, evitando problemas de CORS.

---

## 📝 Recomendação Final

**Use a Solução 1 (Baixar e Hospedar Localmente)** porque:
- É a mais confiável
- Não depende de serviços externos
- As imagens ficam no seu controle
- Funciona perfeitamente

Basta baixar as 6 imagens mais recentes do Instagram e atualizar os nomes dos arquivos no HTML!


