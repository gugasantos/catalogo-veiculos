<!doctype html>
<html lang="pt-BR">
<head>
    <script>
    const savedTheme = localStorage.getItem("site-theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    </script>
    <meta charset="utf-8">
    <title>@yield('title', 'Catálogo de Veículos')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <style>
        /* 🌗 Tema Padrão (Claro) */
        :root {
            --brand-bg: #f1f5f9;
            --brand-bg-soft: #ffffff;
            --brand-primary: #0f172a;
            --brand-primary-dark: #c58a16;
            --brand-text-main: #0f172a;
            --brand-text-muted: #694747ff;
            --brand-border: #cbd5e1;
            --brand-toggle: #121212;
            --brand-description: #0E1118;
            --font-body: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-heading: 'Poppins', system-ui, sans-serif;
            --brand-boton-header-color:rgba(196, 129, 5, 0.1);
        }

        /* 🌙 Tema Escuro */
        [data-theme="dark"] {
            --brand-bg: #121212;
            --brand-bg-soft: #121212;
            --brand-primary: #f5b63a;
            --brand-primary-dark: #c58a16;
            --brand-text-main: #f9fafb;
            --brand-text-muted: #ffffff;
            --brand-border: #27272f;
            --brand-toggle: #ffffff;
            --brand-description: #0E1118;
            --brand-boton-header-color:rgba(247, 151, 6, 1)
        }

        /* ===== Layout usando as variáveis ===== */
        body {
            margin: 0;
            background: var(--brand-bg);
            color: var(--brand-text-main);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a { color: inherit; text-decoration: none; }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 16px;
        }

        header {
            background: var(--brand-bg-soft);
            border-bottom: 1px solid var(--brand-border);
        }

        header .inner {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 16px;
        }

        header nav {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        header nav a {
            font-size: 14px;
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--brand-boton-header-color);
            color: #0f172a;
            /* border: 1px solid #c52a16ff; */
            transition: all .25s ease-in-out;
        }

        header nav a:hover {
            background: #c58a16;
            color: #ffffff;
            border-color: #c58a16;
            box-shadow: 0 6px 16px rgba(2,132,199,.35);
            transform: translateY(-1px) scale(1.03);
        }

        body.dark header nav a {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.18);
            color: #e5e7eb;
        }

        body.dark header nav a:hover {
            background: #38bdf8;
            color: #0f172a;
            border-color: #38bdf8;
            box-shadow: 0 6px 16px rgba(56,189,248,.45);
        }



        footer {
            border-top: 1px solid var(--brand-border);
            margin-top: 32px;
            font-size: 11px;
            color: var(--brand-text-muted);
            background: var(--brand-bg-soft);
        }

        footer .inner {
            max-width: 1120px;
            margin: 0 auto;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
        }

        main {
            padding-top: 16px;
            padding-bottom: 24px;
        }

        .badge-admin {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 999px;
            background: rgba(245,182,58,0.2);
            color: var(--brand-primary);
            margin-left: 8px;
        }
        #themeToggle{
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border:1px solid var(--brand-border);
            background:var(--brand-toggle);
            color:var(--brand-bg-soft);
            cursor:pointer;
            margin-left:16px;

            /* animação suave */
            transition: background .3s ease, color .3s ease, border .3s ease, transform .2s ease;
            }

            /* Hover */
            #themeToggle:hover{
            background: var(--brand-bg-soft);
            color: var(--brand-toggle);
            border-color: var(--brand-text-main);
            transform: scale(1.05);
            }
        .brand-box {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-logo {
            height: 38px;
            width: 38px;
            border-radius: 50%;    /* ← deixa redondo */
            object-fit: cover;     /* garante que a imagem preencha bem */
        }


        .brand-name {
            font-family: var(--font-heading);
            font-size: 18px;
            font-weight: 700;
            color: var(--brand-text-main);
        }
        .login-wrapper{
            min-height: calc(100vh - 170px); /* header+footer */
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 12px 0;
        }

        .login-card{
            width:100%;
            max-width: 380px;
            background: var(--brand-bg-soft);
            border: 1px solid var(--brand-border);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 12px 28px rgba(0,0,0,.12);
        }

        .login-header{
            text-align:center;
            margin-bottom: 14px;
        }

        .login-logo{
            width: 64px;
            height: 64px;
            border-radius: 16px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .login-title{
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: var(--brand-text-main);
        }

        .login-subtitle{
            margin: 6px 0 0;
            font-size: 13px;
            color: var(--brand-text-muted);
        }

        .login-error{
            margin: 12px 0;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(239,68,68,.10);
            border: 1px solid rgba(239,68,68,.25);
            color: #b91c1c;
            font-size: 13px;
        }

        .login-form{
            display:flex;
            flex-direction:column;
            gap: 10px;
        }

        .login-field{
            display:flex;
            flex-direction:column;
            gap: 5px;
        }

        .login-field label{
            font-size: 12px;
            color: var(--brand-text-muted);
        }

        .login-field input{
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid var(--brand-border);
            background: var(--brand-bg-soft);
            color: var(--brand-text-main);
            font-size: 14px;
            outline: none;
        }

        .login-field input:focus{
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(2,132,199,.18);
        }

        .login-remember{
            display:flex;
            align-items:center;
            gap: 8px;
            font-size: 12px;
            color: var(--brand-text-muted);
            user-select:none;
        }

        .login-remember input{
            width: 16px;
            height: 16px;
        }

        .btn-login{
            margin-top: 6px;
            width:100%;
            padding: 11px 12px;
            border-radius: 14px;
            border: none;
            background: var(--brand-primary);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor:pointer;
        }

        .btn-login:hover{
            filter: brightness(0.95);
        }
        .photos-grid{
            display:grid;
            grid-template-columns:repeat(4,minmax(0,1fr));
            gap:10px;
        }
        .photo-card{
            border:1px solid #e2e8f0;
            border-radius:12px;
            overflow:hidden;
            background:#fff;
        }
        .photo-card img{
            width:100%;
            height:120px;
            object-fit:cover;
            display:block;
        }
        .photo-meta{
            padding:8px;
            font-size:12px;
            color:#64748b;
        }
        @media(max-width:720px){
            .photos-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
        }
        
       
        .actions-row{
        display:flex;
        align-items:center;
        gap:12px;
        margin-top:24px;
        }

        .actions-row > :first-child{
        margin-right:auto; /* empurra o resto para a direita */
        }

        /* deixa o form do excluir sem “quebrar” layout */
        .actions-row form{
        margin:0;
        }

        .btn-danger{
        background:#ef4444;
        border:none;
        color:#fff;
        padding:10px 14px;
        border-radius:10px;
        cursor:pointer;
        }
        .btn-danger:hover{ filter: brightness(.95); }
        .btn-primary:hover{ filter: brightness(.95); }
        .btn:hover{ filter: brightness(.95); }
        .file-btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:10px;
            border:1px dashed #cbd5e1;
            background:#f8fafc;
            color:#0f172a;
            font-size:14px;
            cursor:pointer;
            transition:.2s;
            }

            .file-btn:hover{
            background:#e2e8f0;
        }
        .check{
        display:inline-flex;        /* ou flex */
        align-items:center;
        gap:8px;
        cursor:pointer;
        line-height:1;
        white-space:nowrap;
        }

        .check input[type="checkbox"]{
        margin:0;                   /* remove margem padrão */
        width:16px;
        height:16px;
        }

        .logout-form{
        margin-left: 12px;
        }

        .btn-logout{
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #ef4444;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
        }

        .btn-logout:hover{
        background: #fee2e2;
        border-color: #fecaca;
        }

        /* ===============================
   FORM GRID (Create / Edit)
        =============================== */

        /* garante que padding/border não estoure colunas */
        * {
        box-sizing: border-box;
        }

        /* grid principal do formulário */
        .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 28px; /* vertical | horizontal */
        align-items: start;
        }

        /* wrapper de cada campo */
        .field {
        min-width: 0;               /* evita overflow */
        display: flex;
        flex-direction: column;
        gap: 6px;
        }

        /* labels */
        .field label {
        font-size: 13px;
        font-weight: 500;
        color: var(--brand-text-muted);
        }

        /* inputs, selects e textarea */
        .field input,
        .field select,
        .field textarea {
        width: 100%;
        max-width: 100%;
        padding: 10px 12px;
        border-radius: 12px;
        border: 1px solid var(--brand-border);
        background: var(--brand-bg-soft);
        color: var(--brand-text-main);
        font-size: 14px;
        outline: none;
        transition: border .2s ease, box-shadow .2s ease;
        }

        /* focus */
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
        }

        /* campos que ocupam a linha inteira */
        .field-wide {
        grid-column: 1 / -1;
        }

        /* textarea */
        .field textarea {
        resize: vertical;
        }

        /* ===============================
        Upload de fotos
        =============================== */

        .file-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px dashed var(--brand-border);
        background: var(--brand-bg-soft);
        color: var(--brand-text-main);
        font-size: 14px;
        cursor: pointer;
        transition: background .2s ease, border .2s ease;
        }

        .file-btn:hover {
        background: rgba(148, 163, 184, 0.12);
        }

        /* preview das imagens */
        .photos-preview,
        #photosPreview {
        margin-top: 12px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        }

        /* cards das imagens */
        .photos-preview > div,
        #photosPreview > div {
        border: 1px solid var(--brand-border);
        border-radius: 12px;
        overflow: hidden;
        background: var(--brand-bg-soft);
        }

        /* ===============================
        Responsivo
        =============================== */

        @media (max-width: 900px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .photos-preview,
        #photosPreview {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        }












        
        </style>

</head>
<body>

<header>
    <div class="inner container">
        
        <a href="{{ route('home') }}" class="brand-box">
            <img src="{{ asset('img/logoloja.jpeg') }}" alt="Logo" class="brand-logo">
            <span class="brand-name">
                {{ \App\Models\SiteSetting::getValue('store_name', 'Multimarcas') }}
            </span>
        </a>


        <nav>
            <a href="{{ route('home') }}">Início</a>
            <a href="{{ route('vehicles.index') }}">Veículos</a>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.vehicles.index') }}">Admin</a>
                @endif
            @endauth
        </nav>
        <button id="themeToggle">
        🌙
        </button>

    </div>
</header>

<main class="container">
    @yield('content')
</main>

<footer>
    <div class="inner">
        <span>&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::getValue('store_name', 'Multimarcas') }}</span>
        <span>
            {{ \App\Models\SiteSetting::getValue('store_city', 'Brasília') }}
            -
            {{ \App\Models\SiteSetting::getValue('store_state', 'DF') }}
        </span>
    </div>
</footer>
    <script>
    const btn = document.getElementById("themeToggle");

    function updateButtonLabel() {
        const theme = document.documentElement.getAttribute("data-theme");
        btn.innerText = theme === "dark"
            ? "☀️ "
            : "🌙";
    }

    btn.addEventListener("click", () => {
        const current = document.documentElement.getAttribute("data-theme");
        const next = current === "dark" ? "light" : "dark";

        document.documentElement.setAttribute("data-theme", next);
        localStorage.setItem("site-theme", next);
        updateButtonLabel();
    });

    updateButtonLabel();
    </script>

</body>
</html>
