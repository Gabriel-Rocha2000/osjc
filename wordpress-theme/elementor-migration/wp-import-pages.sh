#!/usr/bin/env python3
from __future__ import annotations
import csv
import subprocess
from pathlib import Path

base = Path(__file__).resolve().parent
map_file = base / 'page-map.csv'
site_source = base.parent.parent / 'site'

def run_wp(args: list[str]) -> str:
    out = subprocess.run(['wp', *args], check=False, capture_output=True, text=True)
    if out.returncode != 0:
        raise RuntimeError(out.stderr.strip() or out.stdout.strip())
    return out.stdout.strip()

with map_file.open('r', encoding='utf-8', newline='') as fh:
    reader = csv.DictReader(fh)
    for row in reader:
        html_file = row['html_file']
        slug = row['wordpress_slug'].strip('/') or 'home'
        title = row['wordpress_title']
        status = row['status_sugestao']
        content_file = site_source / html_file
        if not content_file.exists():
            continue
        content = content_file.read_text(encoding='utf-8', errors='ignore')
        existing = run_wp(['post', 'list', '--post_type=page', f'--name={slug}', '--field=ID', '--posts_per_page=1'])
        if existing:
            post_id = existing.splitlines()[0]
            run_wp(['post', 'update', post_id, f'--post_title={title}', f'--post_status={status}', f'--post_content={content}'])
            print(f'Atualizado: {slug}')
        else:
            run_wp(['post', 'create', '--post_type=page', f'--post_name={slug}', f'--post_title={title}', f'--post_status={status}', f'--post_content={content}'])
            print(f'Criado: {slug}')

print('Importacao concluida.')
