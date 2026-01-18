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
            z-index: -1;
            content: "";
            position: absolute;
            inset: 0;

            background: url("{{ asset('img/logoloja.jpeg') }}") 
                center
                no-repeat;

            background-size: 100%;   /* ← garante que NÃO corta a logo */
            opacity: 0.09;              /* ajuste a intensidade */
            pointer-events: none;
            background-position: center 55%;
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
            background: var(--brand-primary-dark);
            border-radius: 18px;
            padding: 16px;
            color: #e5e7eb;
            box-shadow: 0 10px 20px var(--brand-primary-dark);
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
        .hero-card-pill {
            display: inline-block;
            margin-top: 8px;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(15, 118, 110, 0.3);
            border: 1px solid #14b8a6;
            color: #a5f3fc;
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
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }
        .vehicle-card-img {
            position: relative;
            padding-top: 62.5%;
            background: #e2e8f0;
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
    </style>


    {{-- HERO / CAPA --}}
    <section class="hero">
        <div class="cabecalho-principal">
            <h1 class="hero-title">
                Bem-vindo à WS Multimarcas
            </h1>
            <p class="hero-subtitle">
                Encontre seu próximo carro com praticidade. Veja os veículos disponíveis,
                compare e fale direto com a loja pelo WhatsApp. Sem cadastro, sem burocracia.
            </p>

            <div class="hero-actions">
                <a href="{{ route('vehicles.index') }}">
                    <button class="btn-hero-primary">
                        Ver todos os veículos
                    </button>
                </a>

                @php
                    $whats = \App\Models\SiteSetting::getValue('store_whatsapp');
                    $whatsLink = $whats
                        ? 'https://wa.me/'.$whats.'?text='.urlencode('Olá, vi o catálogo de veículos da '.$storeName.' e gostaria de mais informações.')
                        : null;
                @endphp

                @if($whatsLink)
                    <a href="{{ $whatsLink }}" target="_blank" rel="noopener noreferrer">
                        <button class="btn-hero-secondary">
                            Falar no WhatsApp
                        </button>
                    </a>
                @endif
            </div>

            <div class="hero-tags">
                <span class="hero-tag-pill">Catálogo sempre atualizado</span>
                <span class="hero-tag-pill">Contato direto com a loja</span>
                <span class="hero-tag-pill">Sem necessidade de login</span>
            </div>
        </div>

        <div>
            <div class="hero-card">
                <div class="hero-card-title">
                    Atendimento rápido pelo WhatsApp
                </div>
                <div class="hero-card-line">
                    Tire dúvidas sobre financiamento, trocas e condições especiais.
                </div>
                <div class="hero-card-line">
                    Enviamos fotos, vídeos e mais detalhes do veículo que você gostou.
                </div>

                @if($whatsLink)
                    <a href="{{ $whatsLink }}" target="_blank" rel="noopener noreferrer">
                        <div class="hero-card-pill">
                            💬 Chamar agora no WhatsApp
                        </div>
                    </a>
                @endif
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
