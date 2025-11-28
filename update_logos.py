#!/usr/bin/env python3
"""
Script para atualizar o logo em todos os arquivos HTML do site.
Substitui o texto antigo pela tag img com o caminho correto baseado na profundidade.
"""

import os
import re
from pathlib import Path

def calculate_logo_path(file_path, site_root):
    """Calcula o caminho relativo do logo baseado na profundidade do arquivo"""
    # Normalizar caminhos
    file_path = Path(file_path)
    site_root = Path(site_root)
    
    # Calcular profundidade relativa ao site_root
    try:
        relative_path = file_path.relative_to(site_root)
        depth = len(relative_path.parent.parts)
        
        if depth == 0:
            return "LOGO-JERONIMO-NEW-1-90x90.png"
        else:
            return "../" * depth + "LOGO-JERONIMO-NEW-1-90x90.png"
    except ValueError:
        # Se não conseguir calcular, assume que está na raiz
        return "LOGO-JERONIMO-NEW-1-90x90.png"

def update_logo_in_file(file_path, site_root):
    """Atualiza o logo em um arquivo HTML"""
    logo_path = calculate_logo_path(file_path, site_root)
    
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Padrão para encontrar o logo antigo (texto)
        old_pattern = r'<div class="logo-circle">\s*JERONIMO<br>CANDINHO<br>OBRAS SOCIAIS<br>DO C\.E\.F\.\s*</div>'
        
        # Novo conteúdo com a imagem
        new_content = f'<div class="logo-circle">\n                    <img src="{logo_path}" alt="Logo Jerônimo Candinho" />\n                </div>'
        
        # Verificar se o arquivo contém o padrão antigo
        if re.search(old_pattern, content):
            # Substituir
            new_file_content = re.sub(old_pattern, new_content, content)
            
            # Salvar apenas se houver mudanças
            if new_file_content != content:
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(new_file_content)
                return True
        return False
    except Exception as e:
        print(f"Erro ao processar {file_path}: {e}")
        return False

def main():
    site_root = Path(__file__).parent / "site"
    
    if not site_root.exists():
        print(f"Diretório {site_root} não encontrado!")
        return
    
    # Encontrar todos os arquivos HTML
    html_files = list(site_root.rglob("*.html"))
    
    print(f"Encontrados {len(html_files)} arquivos HTML")
    print("Atualizando logos...")
    
    updated_count = 0
    for html_file in html_files:
        if update_logo_in_file(html_file, site_root):
            updated_count += 1
            print(f"✓ Atualizado: {html_file.relative_to(site_root)}")
    
    print(f"\nConcluído! {updated_count} arquivos atualizados.")

if __name__ == "__main__":
    main()

