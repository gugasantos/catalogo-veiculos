@extends('layouts.app')

@section('title', 'Veículos disponíveis')

@section('content')
    <style>
        .filters-box {
            background: var(--brand-bg-soft);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 16px;
            border: 1px solid var(--brand-border);
        }

        .filters-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            
        }

        /* 2 campos por linha em tablets / telas médias */
        @media (max-width: 900px) {
            .filters-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* 1 campo por linha no celular */
        @media (max-width: 600px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .filters-actions {
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 8px;
            }

            .filters-actions .btn-primary-sm,
            .filters-actions .btn-outline-sm {
                width: 100%;
                text-align: center;
            }
        }

        .filters-grid input {
            width: 80%;
            padding: 6px 8px;
            font-size: 13px;
            border-radius: 8px;
            border: 1px solid var(--brand-border);
            background: var(--brand-bg-soft);
            color: var(--brand-text-main);
        }


        .filters-actions {
            margin-top: 8px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-primary-sm {
            padding: 6px 10px;
            border-radius: 8px;
            border: none;
            background: var(--brand-primary);
            color: var(--brand-bg);
            font-size: 13px;
            cursor: pointer;
        }

        .btn-outline-sm {
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid var(--brand-border);
            background: var(--brand-bg-soft);
            color: var(--brand-text-main);
            font-size: 13px;
            cursor: pointer;
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

        .vehicle-card-body {
            padding: 10px 12px 12px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .vehicle-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--brand-text-main);
            margin-bottom: 4px;
        }

        .vehicle-meta {
            font-size: 12px;
            color: var(--brand-text-muted);
            margin-bottom: 4px;
        }

        .vehicle-price {
            font-size: 16px;
            font-weight: 600;
            color: #22c55e; /* mantém verde porque funciona bem nos dois temas */
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
            border: 1px solid var(--brand-border);
            background: var(--brand-bg-soft);
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            color: var(--brand-text-main);
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
            color: white;
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
    </style>

    
    <div style="margin-bottom: 16px;">
        <h1 style="font-size: 22px; font-weight: 700; margin: 0 0 6px;">
            Veículos disponíveis
        </h1>
        <p style="font-size: 13px; color: #64748b; margin: 0;">
            Veja todos os carros disponíveis na loja e fale direto pelo WhatsApp.
        </p>
    </div>

    {{-- Filtros simples (GET) --}}
    <form method="GET" action="{{ route('vehicles.index') }}" class="filters-box">
        <div class="filters-grid">
            <div>
                <input
                    type="text"
                    name="brand"
                    value="{{ request('brand') }}"
                    placeholder="Marca (ex: Chevrolet)"
                >
            </div>
            <div>
                <input
                    type="text"
                    name="model"
                    value="{{ request('model') }}"
                    placeholder="Modelo (ex: Onix)"
                >
            </div>
            <div>
                <input
                    type="number"
                    name="price_min"
                    value="{{ request('price_min') }}"
                    placeholder="Preço mín (R$)"
                >
            </div>
            <div>
                <input
                    type="number"
                    name="price_max"
                    value="{{ request('price_max') }}"
                    placeholder="Preço máx (R$)"
                >
            </div>
        </div>

        <div class="filters-actions">
            <a href="{{ route('vehicles.index') }}" class="btn-outline-sm">Limpar</a>
            <button type="submit" class="btn-primary-sm">Filtrar</button>
        </div>
    </form>

    @if($vehicles->isEmpty())
        <p style="font-size: 13px; color: #64748b;">
            Nenhum veículo encontrado para os filtros selecionados.
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
                        <h2 class="vehicle-title">
                            {{ $vehicle->title }}
                        </h2>

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

        <div style="margin-top: 16px;">
            {{ $vehicles->withQueryString()->links() }}
        </div>
    @endif
@endsection
