#!/usr/bin/env python3
"""
Gera artefatos de migracao HTML -> WordPress/Elementor.

Saidas:
- page-map.csv
- internal-links.csv
- wp-import-pages.sh
"""

from __future__ import annotations

import csv
import re
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import urlparse


ROOT = Path(__file__).resolve().parents[2]
SITE_DIR = ROOT / "site"
OUT_DIR = Path(__file__).resolve().parent


class LinkParser(HTMLParser):
    def __init__(self) -> None:
        super().__init__()
        self.title = ""
        self._in_title = False
        self.links: list[str] = []

    def handle_starttag(self, tag: str, attrs) -> None:
        if tag.lower() == "title":
            self._in_title = True
        if tag.lower() == "a":
            href = dict(attrs).get("href")
            if href:
                self.links.append(href.strip())

    def handle_endtag(self, tag: str) -> None:
        if tag.lower() == "title":
            self._in_title = False

    def handle_data(self, data: str) -> None:
        if self._in_title:
            self.title += data


def is_primary_html(path: Path) -> bool:
    rel = path.relative_to(SITE_DIR).as_posix()
    if rel.startswith("assets/"):
        return False
    return True


def slug_from_html(rel_path: str) -> str:
    if rel_path == "index.html":
        return "/"
    clean = rel_path.replace("index.html", "").replace(".html", "")
    clean = clean.strip("/").lower().replace(" ", "-")
    return f"/{clean}/" if clean else "/"


def normalize_internal_href(href: str) -> str | None:
    href = href.strip()
    if not href or href.startswith("#"):
        return None
    if href.startswith(("mailto:", "tel:", "javascript:")):
        return None
    if href.startswith(("http://", "https://")):
        parsed = urlparse(href)
        if "osjc" not in parsed.netloc:
            return None
        href = parsed.path.lstrip("/")
    href = href.split("#", 1)[0]
    href = href.lstrip("./")
    return href if href.endswith(".html") else None


def main() -> None:
    OUT_DIR.mkdir(parents=True, exist_ok=True)
    pages: list[dict[str, str]] = []
    links: list[dict[str, str]] = []

    html_files = sorted(p for p in SITE_DIR.rglob("*.html") if is_primary_html(p))
    slug_lookup: dict[str, str] = {}

    for html_file in html_files:
        rel = html_file.relative_to(SITE_DIR).as_posix()
        parser = LinkParser()
        parser.feed(html_file.read_text(encoding="utf-8", errors="ignore"))
        title = re.sub(r"\s+", " ", parser.title).strip() or Path(rel).stem
        slug = slug_from_html(rel)
        slug_lookup[rel] = slug
        pages.append(
            {
                "html_file": rel,
                "wordpress_slug": slug,
                "wordpress_title": title,
                "status_sugestao": "publish",
            }
        )
        for raw_href in parser.links:
            target = normalize_internal_href(raw_href)
            if not target:
                continue
            links.append(
                {
                    "origem_html": rel,
                    "href_html": target,
                    "href_wordpress": "",
                }
            )

    for link in links:
        if link["href_html"] in slug_lookup:
            link["href_wordpress"] = slug_lookup[link["href_html"]]
        else:
            link["href_wordpress"] = f"/{link['href_html'].replace('.html', '').strip('/')}/"

    with (OUT_DIR / "page-map.csv").open("w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(
            f, fieldnames=["html_file", "wordpress_slug", "wordpress_title", "status_sugestao"]
        )
        writer.writeheader()
        writer.writerows(pages)

    with (OUT_DIR / "internal-links.csv").open("w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=["origem_html", "href_html", "href_wordpress"])
        writer.writeheader()
        writer.writerows(links)

    import_script = OUT_DIR / "wp-import-pages.sh"
    lines = [
        "#!/usr/bin/env python3",
        "from __future__ import annotations",
        "import csv",
        "import subprocess",
        "from pathlib import Path",
        "",
        "base = Path(__file__).resolve().parent",
        "map_file = base / 'page-map.csv'",
        "site_source = base.parent.parent / 'site'",
        "",
        "def run_wp(args: list[str]) -> str:",
        "    out = subprocess.run(['wp', *args], check=False, capture_output=True, text=True)",
        "    if out.returncode != 0:",
        "        raise RuntimeError(out.stderr.strip() or out.stdout.strip())",
        "    return out.stdout.strip()",
        "",
        "with map_file.open('r', encoding='utf-8', newline='') as fh:",
        "    reader = csv.DictReader(fh)",
        "    for row in reader:",
        "        html_file = row['html_file']",
        "        slug = row['wordpress_slug'].strip('/') or 'home'",
        "        title = row['wordpress_title']",
        "        status = row['status_sugestao']",
        "        content_file = site_source / html_file",
        "        if not content_file.exists():",
        "            continue",
        "        content = content_file.read_text(encoding='utf-8', errors='ignore')",
        "        existing = run_wp(['post', 'list', '--post_type=page', f'--name={slug}', '--field=ID', '--posts_per_page=1'])",
        "        if existing:",
        "            post_id = existing.splitlines()[0]",
        "            run_wp(['post', 'update', post_id, f'--post_title={title}', f'--post_status={status}', f'--post_content={content}'])",
        "            print(f'Atualizado: {slug}')",
        "        else:",
        "            run_wp(['post', 'create', '--post_type=page', f'--post_name={slug}', f'--post_title={title}', f'--post_status={status}', f'--post_content={content}'])",
        "            print(f'Criado: {slug}')",
        "",
        "print('Importacao concluida.')",
    ]
    import_script.write_text("\n".join(lines) + "\n", encoding="utf-8")
    import_script.chmod(0o755)

    print(f"Paginas mapeadas: {len(pages)}")
    print(f"Links internos mapeados: {len(links)}")
    print(f"Arquivos gerados em: {OUT_DIR}")


if __name__ == "__main__":
    main()
