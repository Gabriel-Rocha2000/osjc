#!/bin/bash
# Script para executar o site localmente

echo "🌐 Iniciando servidor local para o site..."
echo ""
echo "📁 Diretório: $(pwd)/site"
echo "🔗 Acesse: http://localhost:8000"
echo ""
echo "Pressione Ctrl+C para parar o servidor"
echo ""

cd site
python3 -m http.server 8000

