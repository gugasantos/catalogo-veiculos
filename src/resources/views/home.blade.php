@extends('layouts.app')

@section('title', 'Início')

@section('content')
    <style>
        .hero {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.3fr);
            gap: 24px;
            align-items: center;
            margin-bottom: 24px;
            
            background: var(--brand-description);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .12);

            position: relative;
            overflow: hidden;
            z-index: 0;
        }
        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;

            background-image: url("{{ asset('img/logo.png') }}");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: contain; /* NÃO corta a logo */
            background-size: 30%;
            
            /* opacity: 0.09; */
            pointer-events: none;
        }
        @media (max-width: 700px) {
        .hero::after {
            background-position: right 10px top 2px;
            background-size: 160px auto; /* ajuste fino aqui */
            opacity: 0.9;
        }
        }


        .hero-tag-pill {
            padding: 3px 9px;
            border-radius: 999px;
            background: #e2e8f0;
        }



        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
            }
        }
        .hero-title {
            font-size: 28px;
            font-weight: 700;
            
            margin-bottom: 8px;
        }
        .hero-subtitle {
            font-size: 14px;
            color: var(--brand-text-muted);
            margin-bottom: 16px;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }
        .btn-hero-primary {
            padding: 9px 16px;
            border-radius: 999px;
            border: none;
            background: #22c55e;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-left: 20px;
        }
        .btn-hero-secondary {
            padding: 9px 16px;
            border-radius: 999px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            font-size: 14px;
            cursor: pointer;
        }
        .hero-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 11px;
            color: #64748b;
        }
        

        .hero-card {
            display: inline-block;
            text-decoration: none;  
            border-radius: 18px;
            padding: 10px;
            color: #e5e7eb;
            margin-left: 20px;

        }
        .hero-card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .hero-card-line {
            font-size: 13px;
            margin-bottom: 4px;
        }
        .hero-right {
            display: flex;
            flex-direction: column;    /* um abaixo do outro */
            align-items: flex-end;     /* alinhados à direita */
            gap: 8px;                  /* espaço entre os botões */
            height: 100%;
            justify-content: center;   /* centraliza verticalmente no hero */
        }

        .hero-whatsapp-btn,
        .hero-maps-btn {
            width: max-content;   /* garante que mede pelo conteúdo */
            min-width: 240px;     /* força ambos terem no mínimo a mesma largura */
            justify-content: center; /* centraliza o texto */
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 500;

            text-decoration: none;
            white-space: nowrap;
        }

        /* WhatsApp */
        .hero-whatsapp-btn {
            background: rgba(15, 118, 75, 0.3);
            border: 1px solid #14b8a6;
            color: #a5f3fc;
        }

        /* Maps */
        .hero-maps-btn {
            background: rgba(234, 179, 8, 0.2); /* dourado suave */
            border: 1px solid #eab308;
            color: #fde68a;
        }
        @media (max-width: 900px) {
        .hero {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 16px;
        }

        /* Coluna da direita vira "normal" no mobile */
        .hero-right {
            align-items: stretch;       /* ao invés de flex-end */
            justify-content: flex-start;
            width: 100%;
        }

        /* Botões responsivos no mobile */
        .hero-whatsapp-btn,
        .hero-maps-btn {
            width: 100%;                /* ocupa toda a largura */
            min-width: 0;               /* remove o mínimo de 240px */
            justify-content: center;    /* mantém o texto central */
            white-space: normal;        /* permite quebrar linha */
            text-align: center;
        }

        /* opcional: botão "Ver todos os veículos" não ficar deslocado */
        .btn-hero-primary {
            margin-left: 0;
            width: 100%;
        }

        .hero-actions {
            width: 100%;
        }

        .hero-actions a {
            width: 100%;
        }
        }
        

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 6px;
        }
        .section-subtitle {
            font-size: 13px;
            color: var(--brand-text-muted);
            margin: 0 0 12px;
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }
        @media (max-width: 900px) {
            .catalog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 640px) {
            .catalog-grid {
                grid-template-columns: 1fr;
            }
        }

        .vehicle-card {
            background: var(--brand-bg-soft);
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--brand-border);
            display: flex;
            flex-direction: column;
            color: var(--brand-text-main);
        }
        .vehicle-card-img {
            position: relative;
            padding-top: 62.5%;
            background: var(--brand-border);
            overflow: hidden;
        }
        .vehicle-card-img img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .vehicle-status-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(15,23,42,0.8);
            color: #e5e7eb;
        }
        .vehicle-featured {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 999px;
            background: #f97316;
            color: #ffffff;
        }
        .vehicle-card-body {
            padding: 10px 12px 12px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .vehicle-title {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .vehicle-meta {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .vehicle-price {
            font-size: 16px;
            font-weight: 600;
            color: #059669;
            margin: 6px 0 8px;
        }
        .vehicle-actions {
            margin-top: auto;
            display: flex;
            gap: 6px;
        }
        .btn-card-secondary {
            flex: 1;
            padding: 6px 8px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            color: #0f172a;
        }
        .btn-card-primary {
            flex: 1;
            padding: 6px 8px;
            border-radius: 8px;
            border: none;
            background: #22c55e;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            color: #ffffff;
        }
        .cabecalho-principal{
            
        }
        .hero-services {
            list-style: none;
            padding: 0;
            margin: 12px 0 18px;
            display: grid;
            gap: 8px;
            margin-left: 30px;
        }

        .hero-services li {
            position: relative;
            padding-left: 18px;
            font-size: 14px;
            font-weight: 600;
            color: #d4af37; /* dourado elegante */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-services li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: #d4af37;
            border-radius: 50%;
        }

        .icon-whatsapp {
            width: 16px;
            height: 16px;
            color: #25D366; /* verde oficial WhatsApp */
            flex-shrink: 0;
        }


    </style>


    {{-- HERO / CAPA --}}
    
    <section class="hero">
        <div class="cabecalho-principal">
           
            <ul class="hero-services">
                <li>Compra</li>
                <li>Venda</li>
                <li>Troca</li>
                <li>Consignação</li>
            </ul>


            <div class="hero-actions">
                <a href="{{ route('vehicles.index') }}">
                    <button class="btn-hero-primary">
                        Ver todos os veículos
                    </button>
                </a>

                @php
                    $whatsRaw = \App\Models\SiteSetting::getValue('whatsapp_phone'); // CONFERE ESSA CHAVE
                    $whats = preg_replace('/\D+/', '', (string) $whatsRaw);

                    $msg = 'Olá, vi o catálogo de veículos da '.$storeName.' e gostaria de mais informações.';
                    $whatsLink = $whats ? 'https://wa.me/'.$whats.'?text='.urlencode($msg) : null;
                @endphp


              
            </div>

           
        </div>

        <div>
            <div class="hero-right">
                @if(!empty($whatsLink))
                <a href="{{ $whatsLink }}" target="_blank" rel="noopener noreferrer" class="hero-whatsapp-btn">
                    <svg class="icon-whatsapp" viewBox="0 0 32 32" aria-hidden="true">
                        <path fill="#25D366"
                            d="M16 2.9C8.77 2.9 2.9 8.77 2.9 16c0 2.62.8 5.05 2.17 7.06L3 29l6.16-2.03A12.95 12.95 0 0 0 16 29.1c7.23 0 13.1-5.87 13.1-13.1S23.23 2.9 16 2.9z"/>
                        <path fill="#FFFFFF"
                            d="M19.43 17.4c-.25-.12-1.46-.72-1.69-.8-.23-.08-.4-.12-.57.12-.17.25-.65.8-.8.97-.15.17-.3.19-.55.06-.25-.12-1.05-.39-2-.25-.75-.67-1.26-1.49-1.41-1.75-.15-.25-.02-.39.1-.51.11-.11.25-.3.38-.45.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.57-1.37-.78-1.88-.21-.5-.42-.43-.57-.43-.15 0-.32-.02-.49-.02-.17 0-.44.06-.68.32-.23.25-.9.87-.9 2.12s.92 2.47 1.05 2.63c.13.17 1.8 2.75 4.34 3.86.6.26 1.07.42 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.5-.61 1.7-1.2.21-.59.21-1.09.15-1.2-.06-.1-.23-.17-.49-.29z"/>
                    </svg>
                    Chamar agora no WhatsApp
                </a>
                @endif


                <a href="https://www.google.com/maps/dir//WS+MULTIMARCASDF,+scia+quadra+15+conjunto+1+lote+08+-+Lago+Norte,+Bras%C3%ADlia+-+DF,+71250-005/@-15.8007296,-47.9307673,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x935a39ed485a698f:0x50b9e8323a55535c!2m2!1d-47.9141382!2d-15.7088813?entry=ttu&g_ep=EgoyMDI2MDEyMS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank"
                rel="noopener noreferrer"
                class="hero-maps-btn">
                    📍 Localização
                </a>
            </div>

        </div>
    </section>

    {{-- SEÇÃO DE VEÍCULOS EM DESTAQUE (usa $vehicles do controller) --}}
    <section>
        <h2 class="section-title">Veículos em destaque</h2>
        <p class="section-subtitle">
            Alguns dos carros mais buscados no momento.
        </p>

        @if($vehicles->isEmpty())
            <p style="font-size: 13px; color: #64748b;">
                Ainda não há veículos em destaque. Confira todos em
                <a href="{{ route('vehicles.index') }}" style="color:#0f766e;">Veículos disponíveis</a>.
            </p>
        @else
            <div class="catalog-grid">
                @foreach($vehicles as $vehicle)
                    @php
                        $cover = $vehicle->coverPhoto ?? $vehicle->photos->first();
                    @endphp

                    <article class="vehicle-card">
                        <div class="vehicle-card-img">
                            @if($cover)
                                <img src="{{ asset('storage/'.$cover->path) }}"
                                     alt="{{ $cover->alt_text ?? $vehicle->title }}">
                            @endif

                            <div class="vehicle-status-badge">
                                @if($vehicle->status === 'available')
                                    Disponível
                                @elseif($vehicle->status === 'sold')
                                    Vendido
                                @else
                                    Indisponível
                                @endif
                            </div>

                            @if($vehicle->featured)
                                <div class="vehicle-featured">
                                    Destaque
                                </div>
                            @endif
                        </div>

                        <div class="vehicle-card-body">
                            <h3 class="vehicle-title">
                                {{ $vehicle->title }}
                            </h3>

                            <div class="vehicle-meta">
                                {{ $vehicle->year }}
                                &bull;
                                {{ $vehicle->brand }}
                                &bull;
                                {{ $vehicle->model }}
                            </div>

                            @if($vehicle->mileage_km)
                                <div class="vehicle-meta">
                                    {{ number_format($vehicle->mileage_km, 0, ',', '.') }} km
                                    @if($vehicle->fuel)
                                        &bull; {{ $vehicle->fuel }}
                                    @endif
                                </div>
                            @endif

                            @if($vehicle->price)
                                <div class="vehicle-price">
                                    R$ {{ number_format($vehicle->price, 2, ',', '.') }}
                                </div>
                            @else
                                <div class="vehicle-meta" style="margin-bottom: 8px;">
                                    Consulte condições
                                </div>
                            @endif

                            <div class="vehicle-actions">
                                <a href="{{ route('vehicles.show', $vehicle->slug) }}" class="btn-card-secondary">
                                    Ver detalhes
                                </a>

                                @if($vehicle->whatsapp_link)
                                    <a href="{{ $vehicle->whatsapp_link }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn-card-primary">
                                        WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
