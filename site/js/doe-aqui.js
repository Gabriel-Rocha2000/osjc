// JavaScript para a página Doe Aqui

document.addEventListener('DOMContentLoaded', function() {
    // Selecionar botões de valor
    const amountButtons = document.querySelectorAll('.donate-amount-btn');
    const customAmountInput = document.getElementById('custom-amount');
    const basketButton = document.querySelector('.donate-basket-btn');
    const submitButton = document.querySelector('.donate-submit-btn');
    
    let selectedAmount = null;
    
    // Adicionar evento de clique nos botões de valor (apenas para botões, não links)
    amountButtons.forEach(button => {
        // Verificar se é um link ou botão
        if (button.tagName === 'BUTTON') {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                // Remover seleção anterior
                amountButtons.forEach(btn => {
                    if (btn.tagName === 'BUTTON') {
                        btn.classList.remove('selected');
                    }
                });
                
                // Adicionar seleção ao botão clicado
                this.classList.add('selected');
                
                // Armazenar valor selecionado
                selectedAmount = this.dataset.amount;
                
                // Limpar input personalizado
                if (customAmountInput) {
                    customAmountInput.value = '';
                }
            });
        }
        // Links não precisam de evento, funcionam normalmente
    });
    
    // Evento para input personalizado
    if (customAmountInput) {
        customAmountInput.addEventListener('input', function() {
            // Remover seleção dos botões quando digitar valor personalizado
            amountButtons.forEach(btn => btn.classList.remove('selected'));
            
            // Armazenar valor personalizado
            if (this.value) {
                selectedAmount = this.value;
            } else {
                selectedAmount = null;
            }
        });
    }
    
    // Evento para botão de cesta básica (apenas se for botão, não link)
    if (basketButton) {
        if (basketButton.tagName === 'BUTTON') {
            basketButton.addEventListener('click', function(e) {
                e.preventDefault();
                // Remover seleção dos botões de valor
                amountButtons.forEach(btn => {
                    if (btn.tagName === 'BUTTON') {
                        btn.classList.remove('selected');
                    }
                });
                
                // Limpar input personalizado
                if (customAmountInput) {
                    customAmountInput.value = '';
                }
                
                // Armazenar seleção de cesta básica
                selectedAmount = 'basket';
                
                // Adicionar feedback visual
                this.style.background = 'rgba(255, 255, 255, 0.3)';
                setTimeout(() => {
                    this.style.background = 'rgba(255, 255, 255, 0.2)';
                }, 200);
            });
        }
        // Se for link, funciona normalmente sem JavaScript
    }
    
    // Evento para botão de enviar
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!selectedAmount && (!customAmountInput || !customAmountInput.value)) {
                alert('Por favor, selecione um valor ou digite um valor personalizado.');
                return;
            }
            
            // Aqui você pode adicionar a lógica para processar a doação
            // Por exemplo, redirecionar para um gateway de pagamento
            const finalAmount = selectedAmount === 'basket' 
                ? 'Cesta Básica' 
                : customAmountInput && customAmountInput.value 
                    ? `R$ ${customAmountInput.value}` 
                    : `R$ ${selectedAmount}`;
            
            console.log('Valor selecionado:', finalAmount);
            
            // Exemplo: redirecionar para página de pagamento
            // window.location.href = `pagamento.html?valor=${selectedAmount}`;
            
            // Por enquanto, apenas mostrar mensagem
            alert(`Obrigado! Você selecionou: ${finalAmount}\n\nEm breve você será redirecionado para finalizar a doação.`);
        });
    }
    
    // Formatação do input de valor personalizado
    if (customAmountInput) {
        customAmountInput.addEventListener('blur', function() {
            if (this.value) {
                const value = parseFloat(this.value);
                if (!isNaN(value) && value > 0) {
                    this.value = value.toFixed(2);
                }
            }
        });
    }
    
    // Copiar dados bancários ao clicar
    const bankDataContainer = document.getElementById('bankDataContainer');
    if (bankDataContainer) {
        bankDataContainer.addEventListener('click', function() {
            // Texto formatado para copiar
            const bankData = `Dados bancários para doação

BANCO: 070 - BRB BANCO DE BRASÍLIA S/A
AGÊNCIA: 050 PONTA NORTE
CONTA CORRENTE: 050.022029-8
FAVORECIDO: OBRAS SOCIAIS C E F J CANDINHO`;
            
            // Copiar para a área de transferência
            navigator.clipboard.writeText(bankData).then(function() {
                // Feedback visual
                const originalHint = bankDataContainer.querySelector('.bank-data-copy-hint');
                const originalText = originalHint.innerHTML;
                
                originalHint.innerHTML = '<i class="fa-solid fa-check"></i> Dados copiados!';
                originalHint.style.color = 'var(--green-medium)';
                
                // Restaurar texto original após 2 segundos
                setTimeout(function() {
                    originalHint.innerHTML = originalText;
                    originalHint.style.color = '';
                }, 2000);
                
                // Efeito visual adicional
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

    // Inicializar carrossel de imagens na página Doe Aqui
    // Carrossel substituído por grade de imagens

    // Inicializar formulário de contato
    initDonateContactForm();
});

// Função do carrossel removida - substituído por grade de imagens
// function initDonateCarousel() { ... }

// Função para inicializar formulário de contato
function initDonateContactForm() {
    const contactForm = document.getElementById('donateContactForm');
    if (!contactForm) return;

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const nameInput = document.getElementById('donateContactName');
        const emailInput = document.getElementById('donateContactEmail');
        const phoneInput = document.getElementById('donateContactPhone');
        
        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        
        // Validação
        if (!name) {
            alert('Por favor, digite seu nome.');
            nameInput.focus();
            return;
        }
        
        if (!email) {
            alert('Por favor, digite um e-mail válido.');
            emailInput.focus();
            return;
        }
        
        // Validação básica de e-mail
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Por favor, digite um e-mail válido.');
            emailInput.focus();
            return;
        }
        
        if (!phone) {
            alert('Por favor, digite seu telefone.');
            phoneInput.focus();
            return;
        }
        
        // Aqui você pode adicionar a lógica para enviar os dados
        // Por exemplo, fazer uma requisição AJAX para um servidor
        
        // Feedback visual
        const submitBtn = contactForm.querySelector('.donate-contact-submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Enviado!';
        submitBtn.style.background = 'var(--green-medium)';
        submitBtn.disabled = true;
        
        // Limpar campos
        nameInput.value = '';
        emailInput.value = '';
        phoneInput.value = '';
        
        // Restaurar botão após 3 segundos
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.style.background = '';
            submitBtn.disabled = false;
        }, 3000);
        
        console.log('Formulário enviado:', { name, email, phone });
        // Aqui você pode adicionar código para enviar os dados para um servidor
    });
}

