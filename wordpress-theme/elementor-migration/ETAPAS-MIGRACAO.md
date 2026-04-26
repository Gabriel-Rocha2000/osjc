# Migracao HTML -> WordPress + Elementor

Este pacote inicia a migracao do site HTML para WordPress + Elementor, preservando layout, CSS e estrutura original.

## ETAPA 1: mapa completo das paginas encontradas

O mapa completo e gerado automaticamente em:

- `wordpress-theme/elementor-migration/page-map.csv`
- `wordpress-theme/elementor-migration/internal-links.csv`

Para gerar/atualizar:

```bash
python3 wordpress-theme/elementor-migration/generate_migration_artifacts.py
```

## ETAPA 2: paginas convertidas

Conversao iniciada com base em tema WordPress compatibilizado com Elementor:

- `front-page.php` preserva a Home original
- `page.php` renderiza conteudo de paginas (necessario para Elementor)
- `single.php` renderiza posts individuais
- Importador WP-CLI para criar/atualizar paginas a partir dos HTML:
  - `wordpress-theme/elementor-migration/wp-import-pages.sh`

## ETAPA 3: templates globais

Header/Footer globais prontos para Elementor Theme Builder:

- `header.php` usa header do Elementor quando existir
- `footer.php` usa footer do Elementor quando existir
- `functions.php` registra localizacoes do Theme Builder

## ETAPA 4: CSS extra necessario

A base visual foi preservada pelos arquivos:

- `wordpress-theme/assets/css/style.css`
- `wordpress-theme/assets/css/doe-aqui.css`

Quando criar Header/Footer no Elementor, manter as classes:

- `.site-header`
- `.site-footer`
- `.main-nav`
- `.donate-button`

Se preferir um header/footer 100% Elementor (sem classe legado), criar um arquivo adicional de override com ajustes finos.

## ETAPA 5: ajustes pendentes

1. Instalar e ativar:
   - Elementor
   - Elementor Pro (para Theme Builder global)
2. Criar templates globais:
   - Header Global
   - Footer Global
3. Importar paginas:
   - Executar `wp-import-pages.sh` dentro da raiz do WordPress
4. Revisar links internos:
   - Baseado em `internal-links.csv`
5. Validar responsividade:
   - Desktop, Tablet, Mobile
6. Ajustar JS interativo para widgets Elementor equivalentes (carrosseis, drawers, etc.), quando necessario.
