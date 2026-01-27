@extends('layouts.app')

@section('title', $vehicle->title)

@section('content')
    <style>
        .breadcrumb {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 10px;
        }
        .breadcrumb a {
            color: #64748b;
        }
        .breadcrumb a:hover {
            color: #0f172a;
        }

        .vehicle-layout {
            display: grid;
            grid-template-columns: minmax(0, 3fr) minmax(0, 2fr);
            gap: 20px;
        }
        @media (max-width: 900px) {
            .vehicle-layout {
                grid-template-columns: 1fr;
            }
        }

        .vehicle-main-image {
            background: #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            position: relative;
            padding-top: 62.5%;
            margin-bottom: 10px;
        }
        .vehicle-main-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vehicle-status-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 11px;
            padding: 3px 9px;
            border-radius: 999px;
            background: rgba(15,23,42,0.85);
            color: #e5e7eb;
        }
        .vehicle-featured-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 11px;
            padding: 3px 9px;
            border-radius: 999px;
            background: #f97316;
            color: #ffffff;
        }

        .thumbs-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 6px;
        }
        @media (max-width: 640px) {
            .thumbs-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
        .thumb-item {
            position: relative;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            padding-top: 65%;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .thumb-item img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .thumb-item.is-active {
            border-color: #0ea5e9;
        }

        .vehicle-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--brand-text-main);
            margin-bottom: 4px;
        }
        .vehicle-subtitle {
            font-size: 13px;
            color: var(--brand-text-muted);
            margin-bottom: 10px;
        }

        .vehicle-price-block {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 12px 14px;
            margin-bottom: 12px;
        }
        .vehicle-price-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 4px;
        }
        .vehicle-price-value {
            font-size: 22px;
            font-weight: 700;
            color: #059669;
        }

        .vehicle-cta {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 12px;
        }
        .btn-whatsapp-main {
            width: 100%;
            padding: 10px 14px;
            border-radius: 999px;
            border: none;
            background: #22c55e;
            color: #ffffff;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
        }
        .btn-whatsapp-main span {
            font-size: 18px;
            margin-right: 6px;
        }
        .btn-secondary-outline {
            width: 100%;
            padding: 9px 14px;
            border-radius: 999px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            font-size: 13px;
            cursor: pointer;
        }
        .hero-maps-btn{
            width: 100%;
            padding: 10px 14px;
            border-radius: 999px;
            border: none;
            background: var(--brand-primary-dark);
            color: #ffffff;
            font-size: 15px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .vehicle-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }
        .vehicle-meta-item {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            font-size: 12px;
        }
        .vehicle-meta-label {
            color: #94a3b8;
            font-size: 11px;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .vehicle-meta-value {
            color: #0f172a;
            font-weight: 500;
        }

        .vehicle-section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--brand-text-main);
            margin: 0 0 6px;
        }
        .vehicle-section-box {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            font-size: 13px;
            color: var(--brand-text-main);
        }

        .vehicle-description {
            white-space: pre-line;
        }
    </style>

    @php
        $photos = $vehicle->photos ?? collect();
        $cover = $vehicle->coverPhoto ?? $photos->first();

        $storeWhats = \App\Models\SiteSetting::getValue('store_whatsapp');
        $whatsNumber = $vehicle->whatsapp_number ?? $storeWhats;

        $whatsLink = $vehicle->whatsapp_link;
        if (!$whatsLink && $whatsNumber) {
            $whatsMessage = 'Olá, tenho interesse no veículo: '.$vehicle->title;
            $whatsLink = 'https://wa.me/'.$whatsNumber.'?text='.urlencode($whatsMessage);
        }
    @endphp

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Início</a>
        &nbsp;/&nbsp;
        <a href="{{ route('vehicles.index') }}">Veículos</a>
        &nbsp;/&nbsp;
        <span>{{ $vehicle->title }}</span>
    </nav>

    <div class="vehicle-layout">
        {{-- COLUNA ESQUERDA: FOTOS / GALERIA --}}
        <div>
            <div class="vehicle-main-image" id="main-image-container">
                @if($cover)
                    <img
                        id="main-image"
                        src="{{ asset('storage/'.$cover->path) }}"
                        alt="{{ $cover->alt_text ?? $vehicle->title }}"
                        data-photo-id="{{ $cover->id }}"
                    >
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
                    <div class="vehicle-featured-badge">
                        Destaque
                    </div>
                @endif
            </div>

            @if($photos->count() > 1)
                <div class="thumbs-grid" id="thumbs-grid">
                    @foreach($photos as $photo)
                        <div class="thumb-item {{ $cover && $cover->id === $photo->id ? 'is-active' : '' }}"
                             data-photo-src="{{ asset('storage/'.$photo->path) }}"
                             data-photo-id="{{ $photo->id }}">
                            <img src="{{ asset('storage/'.$photo->path) }}"
                                 alt="{{ $photo->alt_text ?? $vehicle->title }}">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- COLUNA DIREITA: INFO / WHATSAPP / FICHA --}}
        <div>
            <h1 class="vehicle-title">
                {{ $vehicle->title }}
            </h1>
            <div class="vehicle-subtitle">
                {{ $vehicle->year }} • {{ $vehicle->brand }} • {{ $vehicle->model }}
            </div>

            <div class="vehicle-price-block">
                <div class="vehicle-price-label">
                    preço do veículo
                </div>

                @if($vehicle->price)
                    <div class="vehicle-price-value">
                        R$ {{ number_format($vehicle->price, 2, ',', '.') }}
                    </div>
                @else
                    <div class="vehicle-price-value" style="font-size: 15px; color:#0f172a;">
                        Consulte condições
                    </div>
                @endif
            </div>

            <div class="vehicle-cta">
                <!-- @if($whatsLink)
                    <a href="{{ $whatsLink }}" target="_blank" rel="noopener noreferrer">
                        <button class="btn-whatsapp-main">
                            <span>💬</span> Falar sobre este veículo no WhatsApp
                        </button>
                    </a>
                @endif -->

                @if($vehicle->whatsapp_link)
                    <a href="{{ $whatsLink }}" target="_blank" rel="noopener noreferrer">
                        <button class="btn-whatsapp-main">
                            <span>💬</span> Falar sobre este veículo no WhatsApp
                        </button>
                    </a>
                @endif

                <a href="https://www.google.com/maps/dir//WS+MULTIMARCASDF,+scia+quadra+15+conjunto+1+lote+08+-+Lago+Norte,+Bras%C3%ADlia+-+DF,+71250-005/@-15.8007296,-47.9307673,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x935a39ed485a698f:0x50b9e8323a55535c!2m2!1d-47.9141382!2d-15.7088813?entry=ttu&g_ep=EgoyMDI2MDEyMS4wIKXMDSoASAFQAw%3D%3D"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hero-maps-btn">
                        📍 Fazer uma Visita
                </a>


                <a href="{{ route('vehicles.index') }}">
                    <button class="btn-secondary-outline">
                        ⬅ Voltar para listagem de veículos
                    </button>
                </a>
            </div>

            <div class="vehicle-meta-grid">
                @if($vehicle->mileage_km)
                    <div class="vehicle-meta-item">
                        <div class="vehicle-meta-label">Quilometragem</div>
                        <div class="vehicle-meta-value">
                            {{ number_format($vehicle->mileage_km, 0, ',', '.') }} km
                        </div>
                    </div>
                @endif

                @if($vehicle->fuel)
                    <div class="vehicle-meta-item">
                        <div class="vehicle-meta-label">Combustível</div>
                        <div class="vehicle-meta-value">
                            {{ $vehicle->fuel }}
                        </div>
                    </div>
                @endif

                @if($vehicle->transmission)
                    <div class="vehicle-meta-item">
                        <div class="vehicle-meta-label">Câmbio</div>
                        <div class="vehicle-meta-value">
                            {{ $vehicle->transmission }}
                        </div>
                    </div>
                @endif

                @if($vehicle->color)
                    <div class="vehicle-meta-item">
                        <div class="vehicle-meta-label">Cor</div>
                        <div class="vehicle-meta-value">
                            {{ $vehicle->color }}
                        </div>
                    </div>
                @endif

                @if($vehicle->doors)
                    <div class="vehicle-meta-item">
                        <div class="vehicle-meta-label">Portas</div>
                        <div class="vehicle-meta-value">
                            {{ $vehicle->doors }} portas
                        </div>
                    </div>
                @endif

                @if($vehicle->plate)
                    <div class="vehicle-meta-item">
                        <div class="vehicle-meta-label">Placa</div>
                        <div class="vehicle-meta-value">
                            {{ $vehicle->plate }}
                        </div>
                    </div>
                @endif
            </div>

            <div style="margin-bottom: 12px;">
                <h2 class="vehicle-section-title">Descrição do veículo</h2>
                <div class="vehicle-section-box vehicle-description">
                    @if($vehicle->description)
                        {{ $vehicle->description }}
                    @else
                        Descrição não informada. Entre em contato pelo WhatsApp para mais detalhes sobre este veículo.
                    @endif
                </div>
            </div>

            <div>
                <h2 class="vehicle-section-title">Observações</h2>
                <div class="vehicle-section-box" style="font-size: 12px;">
                    Valores, condições e disponibilidade podem ser alterados sem aviso prévio.
                    Confirme todas as informações diretamente com a loja antes de fechar negócio.
                </div>
            </div>
        </div>
    </div>

    {{-- Script simples pra trocar a foto principal ao clicar nas thumbs --}}
    <script>
        (function () {
            const mainImg = document.getElementById('main-image');
            const thumbsGrid = document.getElementById('thumbs-grid');

            if (!mainImg || !thumbsGrid) return;

            thumbsGrid.addEventListener('click', function (e) {
                const thumb = e.target.closest('.thumb-item');
                if (!thumb) return;

                const src = thumb.getAttribute('data-photo-src');
                const id = thumb.getAttribute('data-photo-id');
                if (!src) return;

                mainImg.src = src;
                mainImg.setAttribute('data-photo-id', id);

                // Atualiza estado visual
                document.querySelectorAll('.thumb-item').forEach(function (el) {
                    el.classList.remove('is-active');
                });
                thumb.classList.add('is-active');
            });
        })();
    </script>
@endsection
