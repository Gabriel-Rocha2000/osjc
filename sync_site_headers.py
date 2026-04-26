#!/usr/bin/env python3
"""
Padroniza o <header> do site estático com o da home: header-top + header-bottom,
menu completo, redes, alternância de tema e botão Doe aqui com ícone.
Corrige headers existentes (Materiais no menu, YouTube oficial).
"""
from __future__ import annotations

import re
from pathlib import Path

SITE = Path(__file__).resolve().parent / "site"
YOUTUBE = "https://www.youtube.com/@obrassociaisjeronimocandinho"


def path_prefix(rel: Path) -> str:
    parts = rel.parts
    if len(parts) <= 1:
        return ""
    return "../" * (len(parts) - 1)


def build_header(pre: str) -> str:
    if pre:
        logo = f"{pre}LOGO-JERONIMO-NEW-1-90x90.png"
        assets = f"{pre}assets/"
        yt_icon = f"{pre}youtube-123.svg"
        heart = f"{pre}heart-icon.png"
        home = f"{pre}index.html"
        quem = f"{pre}quem-somos.html"
        posts = f"{pre}posts.html"
        pages = f"{pre}pages.html"
        transp = f"{pre}pages/todas/transparencia.html"
        contato = f"{pre}pages/todas/contato.html"
        doe = f"{pre}doe-aqui.html"
    else:
        logo = "LOGO-JERONIMO-NEW-1-90x90.png"
        assets = "./assets/"
        yt_icon = "./youtube-123.svg"
        heart = "./heart-icon.png"
        home = "index.html"
        quem = "quem-somos.html"
        posts = "posts.html"
        pages = "pages.html"
        transp = "pages/todas/transparencia.html"
        contato = "pages/todas/contato.html"
        doe = "doe-aqui.html"

    return f"""    <header class="site-header" id="siteHeader">
        <div class="container">
            <div class="header-top">
                <div class="header-left">
                    <div class="logo-circle">
                        <img src="{logo}" alt="Logo Jerônimo Candinho" />
                    </div>
                    <h1 class="site-title"><a href="{home}">Obras Sociais C.E.F. Jerônimo Candinho</a></h1>
                </div>
            </div>
            <div class="header-bottom">
                <nav class="main-nav">
                    <ul>
                        <li><a href="{home}" class="nav-link">Home</a></li>
                        <li><a href="{quem}" class="nav-link">Quem Somos</a></li>
                        <li><a href="{posts}" class="nav-link">Programas</a></li>
                        <li><a href="{pages}" class="nav-link">Vagas</a></li>
                        <li><a href="{posts}" class="nav-link">Blog</a></li>
                        <li><a href="{transp}" class="nav-link">Transparência</a></li>
                        <li><a href="{pages}" class="nav-link">Materiais</a></li>
                        <li><a href="{contato}" class="nav-link">Contato</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <div class="social-icons">
                        <a href="https://www.instagram.com/jeronimocandinho.osjc?igsh=NHlmb3NxN2p0ODh1" target="_blank" rel="noopener" aria-label="Instagram" class="social-icon">
                            <img src="{assets}instagram-icon.svg" alt="Instagram" class="social-icon-img" />
                        </a>
                        <a href="https://www.facebook.com" target="_blank" rel="noopener" aria-label="Facebook" class="social-icon">
                            <img src="{assets}facebook-icon.svg" alt="Facebook" class="social-icon-img" />
                        </a>
                        <a href="{YOUTUBE}" target="_blank" rel="noopener" aria-label="YouTube" class="social-icon">
                            <img src="{yt_icon}" alt="YouTube" class="social-icon-img" />
                        </a>
                    </div>
                    <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
                        <span class="theme-icon">🌙</span>
                    </button>
                    <a href="{doe}" class="donate-button"><img src="{heart}" alt="Coração" class="donate-heart-icon"> Doe aqui</a>
                </div>
            </div>
        </div>
    </header>"""


MOBILE_SNIPPET = """    <!-- Elementos decorativos verdes -->
    <div class="decorative-green-right"></div>
    <div class="decorative-green-bottom"></div>

    <!-- Botão hambúrguer para abrir drawer (mobile) -->
    <button class="drawer-toggle" id="drawerToggle" aria-label="Abrir menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

"""


def ensure_mobile_chrome(text: str) -> str:
    if "id=\"drawerToggle\"" in text:
        return text
    m = re.search(r"<body[^>]*>", text, re.IGNORECASE)
    if not m:
        return text
    insert_at = m.end()
    return text[:insert_at] + "\n" + MOBILE_SNIPPET + text[insert_at:]


def replace_first_header(text: str, new_header: str) -> str | None:
    m = re.search(r"<header\s[^>]*class=\"site-header\"[^>]*>", text)
    if not m:
        m = re.search(r"<header\s+class=\"site-header\"[^>]*>", text)
    if not m:
        return None
    start = m.start()
    end = text.find("</header>", start)
    if end == -1:
        return None
    end += len("</header>")
    return text[:start] + new_header + text[end:]


def fix_youtube_hrefs(text: str) -> str:
    text = text.replace('href="hhttps://youtube.com"', f'href="{YOUTUBE}"')
    text = text.replace('href="https://youtube.com"', f'href="{YOUTUBE}"')
    text = text.replace('href="https://youtube.com/"', f'href="{YOUTUBE}"')
    return text


def insert_materiais_nav(text: str, materiais_href: str) -> str:
    if ">Materiais<" in text:
        return text
    pattern = (
        r"(<li>\s*<a\s+href=\"[^\"]*\"\s+class=\"nav-link\">Transparência</a>\s*</li>\s*)"
        r"(<li>\s*<a\s+href=\"[^\"]*\"\s+class=\"nav-link\">Contato</a>\s*</li>)"
    )

    def repl(m: re.Match[str]) -> str:
        return (
            m.group(1)
            + f'<li><a href="{materiais_href}" class="nav-link">Materiais</a></li>\n                        '
            + m.group(2)
        )

    new_text, n = re.subn(pattern, repl, text, count=1)
    if n:
        return new_text
    return text


def materiais_href_for(rel: Path) -> str:
    pre = path_prefix(rel)
    return f"{pre}pages.html" if pre else "pages.html"


def main() -> None:
    changed = 0
    for path in sorted(SITE.rglob("*.html")):
        if "assets" in path.relative_to(SITE).parts:
            continue
        rel = path.relative_to(SITE)
        text = path.read_text(encoding="utf-8", errors="replace")
        orig = text
        text = fix_youtube_hrefs(text)
        if "header-bottom" in text:
            text = insert_materiais_nav(text, materiais_href_for(rel))
        else:
            new_h = build_header(path_prefix(rel))
            rep = replace_first_header(text, new_h)
            if rep is not None:
                text = rep
        text = ensure_mobile_chrome(text)
        if text != orig:
            path.write_text(text, encoding="utf-8")
            changed += 1
            print(rel)
    print(f"Total alterados: {changed}")


if __name__ == "__main__":
    main()
