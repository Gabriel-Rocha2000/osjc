// Instagram Feed Integration
// Este arquivo pode ser usado para integrar com a API do Instagram

document.addEventListener('DOMContentLoaded', function() {
    const feedContainer = document.getElementById('instagramFeed');
    if (!feedContainer) return;
    
    // Opção 1: Usar Instagram Basic Display API
    // Você precisará configurar um App no Facebook Developers
    // e obter um Access Token
    
    // Exemplo de função para buscar posts do Instagram
    async function loadInstagramFeed() {
        // Substitua 'YOUR_ACCESS_TOKEN' pelo token real
        const accessToken = 'YOUR_ACCESS_TOKEN';
        const userId = 'YOUR_USER_ID';
        
        try {
            // API endpoint do Instagram Basic Display
            const response = await fetch(
                `https://graph.instagram.com/${userId}/media?fields=id,media_type,media_url,permalink,thumbnail_url&access_token=${accessToken}`
            );
            
            const data = await response.json();
            
            if (data.data) {
                updateFeedGrid(data.data);
            }
        } catch (error) {
            console.error('Erro ao carregar feed do Instagram:', error);
            // Em caso de erro, mantém as imagens placeholder
        }
    }
    
    // Função para atualizar o grid com as imagens do Instagram
    function updateFeedGrid(posts) {
        feedContainer.innerHTML = '';
        
        // Limita a 6 posts mais recentes
        const recentPosts = posts.slice(0, 6);
        
        recentPosts.forEach(post => {
            const item = document.createElement('div');
            item.className = 'instagram-item';
            
            const imageUrl = post.media_type === 'VIDEO' 
                ? post.thumbnail_url 
                : post.media_url;
            
            item.innerHTML = `
                <a href="${post.permalink}" target="_blank" rel="noopener">
                    <img src="${imageUrl}" alt="Instagram Post" class="instagram-image" />
                    <div class="instagram-overlay">
                        <span class="instagram-icon">📷</span>
                    </div>
                </a>
            `;
            
            feedContainer.appendChild(item);
        });
    }
    
    // Opção 2: Usar um serviço de terceiros como Juicer.io ou SnapWidget
    // Exemplo com SnapWidget (mais simples, mas requer embed)
    
    // Opção 3: Atualização manual
    // Você pode atualizar manualmente as imagens substituindo os placeholders
    // ou usar um CMS para gerenciar o conteúdo
    
    // Para ativar a integração automática, descomente a linha abaixo:
    // loadInstagramFeed();
    
    // INSTRUÇÕES PARA INTEGRAÇÃO:
    // 
    // 1. Instagram Basic Display API (Recomendado):
    //    - Acesse: https://developers.facebook.com/
    //    - Crie um App
    //    - Configure o Instagram Basic Display
    //    - Obtenha o Access Token
    //    - Substitua YOUR_ACCESS_TOKEN e YOUR_USER_ID acima
    //    - Descomente: loadInstagramFeed();
    //
    // 2. Alternativa Simples - SnapWidget:
    //    - Acesse: https://snapwidget.com/
    //    - Crie um widget gratuito
    //    - Copie o código embed
    //    - Substitua a seção instagram-feed-grid pelo embed
    //
    // 3. Atualização Manual:
    //    - Substitua os arquivos instagram-placeholder.jpg pelas imagens reais
    //    - Atualize os links href para os posts reais do Instagram
});



