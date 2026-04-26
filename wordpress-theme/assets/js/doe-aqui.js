// Página Doe Aqui: opções de doação são links diretos ao PagBank; aqui só copia dos dados bancários.

document.addEventListener('DOMContentLoaded', function() {
    const bankDataContainer = document.getElementById('bankDataContainer');
    if (bankDataContainer) {
        bankDataContainer.addEventListener('click', function() {
            const bankData = `Dados bancários para doação

BANCO: 070 - BRB BANCO DE BRASÍLIA S/A
AGÊNCIA: 050 PONTA NORTE
CONTA CORRENTE: 050.022029-8
FAVORECIDO: OBRAS SOCIAIS C E F J CANDINHO`;

            navigator.clipboard.writeText(bankData).then(function() {
                const originalHint = bankDataContainer.querySelector('.bank-data-copy-hint');
                const originalText = originalHint.innerHTML;

                originalHint.innerHTML = '<i class="fa-solid fa-check"></i> Dados copiados!';
                originalHint.style.color = 'var(--green-medium)';

                setTimeout(function() {
                    originalHint.innerHTML = originalText;
                    originalHint.style.color = '';
                }, 2000);

                bankDataContainer.style.background = 'var(--green-soft)';
                setTimeout(function() {
                    bankDataContainer.style.background = '';
                }, 300);
            }).catch(function(err) {
                console.error('Erro ao copiar:', err);
                alert('Não foi possível copiar. Por favor, selecione e copie manualmente.');
            });
        });
    }
});
