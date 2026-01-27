@extends('layouts.app')

@section('title', 'Admin - Veículos')

@section('content')
<style>
    .admin-wrap {
        display: grid;
        gap: 14px;
    }

    .panel {
        background: var(--brand-bg-soft);
        border: 1px solid var(--brand-border);
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 10px 22px rgba(0,0,0,.06);
    }

    .admin-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .admin-title {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.2px;
        color: #0f172a;
    }

    .admin-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #64748b;
    }

    .actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        cursor: pointer;
        text-decoration: none;
        user-select: none;
        transition: transform .08s ease, box-shadow .08s ease;
    }
    .btn:hover { box-shadow: 0 10px 16px rgba(0,0,0,.07); }
    .btn:active { transform: translateY(1px); }

    .btn-primary {
        border: none;
        background: #0284c7;
        color: #ffffff;
    }

    .filters {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .filters input, .filters select {
        width: 100%;
        padding: 9px 10px;
        font-size: 13px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: var(--brand-bg-soft);
        color: #0f172a;
        outline: none;
    }

    .filters-actions {
        margin-top: 10px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filters-select-option {
        color: var(--brand-text-main);
    }

    @media (max-width: 950px) {
        .filters { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 620px) {
        .filters { grid-template-columns: 1fr; }
        .filters-actions .btn { width: 100%; }
    }

    .table-wrap {
        overflow: auto;
        border-radius: 14px;
        border: 1px solid var(--brand-border);
        background: var(--brand-bg-soft);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 920px; /* rolagem horizontal em telas pequenas */
    }
    

    thead th {
        text-align: left;
        font-size: 12px;
        color: #64748b;
        font-weight: 800;
        letter-spacing: .02em;
        padding: 12px 12px;
        border-bottom: 1px solid #e2e8f0;
        background: var(--brand-bg-soft);
        white-space: nowrap;
    }

    tbody td {
        padding: 12px 12px;
        border-bottom: 1px solid #eef2f7;
        font-size: 13px;
        color: #0f172a;
        vertical-align: middle;
        white-space: nowrap;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    .vehicle-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 320px;
    }

    .thumb {
        width: 54px;
        height: 40px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
        flex: 0 0 auto;
        border: 1px solid #e2e8f0;
    }
    .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .v-title {
        font-weight: 800;
        font-size: 13px;
        margin: 0;
        line-height: 1.1;
    }
    .v-meta {
        margin: 4px 0 0;
        font-size: 12px;
        color: #64748b;
        line-height: 1.1;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #0f172a;
    }

    .pill-available { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
    .pill-sold      { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
    .pill-hidden    { background: #fff7ed; border-color: #fed7aa; color: #9a3412; }

    .pill-featured  { background: #fff7ed; border-color: #fdba74; color: #9a3412; }

    .row-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-sm {
        padding: 7px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
    }

    .btn-sm-green {
        border: none;
        background: #22c55e;
        color: #ffffff;
    }

    .btn-sm-red {
        border: none;
        background: #ef4444;
        color: #ffffff;
    }

    .muted {
        color: #64748b;
        font-size: 12px;
    }
</style>

<div class="admin-wrap">

    {{-- Cabeçalho --}}
    <div class="panel admin-header">
        <div>
            <h1 class="admin-title">Painel Admin • Veículos</h1>
            <p class="admin-subtitle">
                Gerencie os anúncios: criar, editar, ativar/desativar e marcar destaque.
            </p>
        </div>

        <div class="actions">
             <form method="POST" action="{{ route('logout') }}" class="logout-form">
                 @csrf
                <button type="submit" class="btn-logout">
                Sair
                </button>
            </form>
            <a href="{{ route('home') }}" class="btn">← Voltar ao site</a>

            {{-- ajuste essa rota quando você criar o create do admin --}}
            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                + Novo veículo
            </a>
           
      
        </div>
    </div>
    

    {{-- Filtros --}}
    <div class="panel">
        <form method="GET" action="{{ route('admin.vehicles.index') }}">
            <div class="filters">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar por título, marca, modelo..."
                >

                <input
                    type="text"
                    name="brand"
                    value="{{ request('brand') }}"
                    placeholder="Marca (ex: Chevrolet)"
                >

                <select name="status">
                    <option value="">Status (todos)</option>
                    <option value="available" @selected(request('status') === 'available')>Disponível</option>
                    <option value="sold" @selected(request('status') === 'sold')>Vendido</option>
                    <option value="hidden" @selected(request('status') === 'hidden')>Oculto</option>
                </select>

                <select name="featured">
                    <option value="">Destaque (todos)</option>
                    <option value="1" @selected(request('featured') === '1')>Somente destaques</option>
                    <option value="0" @selected(request('featured') === '0')>Sem destaque</option>
                </select>
            </div>

            <div class="filters-actions">
                <a href="{{ route('admin.vehicles.index') }}" class="btn">Limpar</a>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
    </div>

    {{-- Tabela --}}
    <div class="panel" style="padding: 0;">
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Veículo</th>
                    <th>Ano</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Destaque</th>
                    <th>Criado em</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
                </thead>

                <tbody>
                @forelse($vehicles as $vehicle)
                    @php
                        $cover = $vehicle->coverPhoto ?? $vehicle->photos->first();
                        $statusClass = match($vehicle->status) {
                            'available' => 'pill-available',
                            'sold' => 'pill-sold',
                            default => 'pill-hidden',
                        };
                        $statusLabel = match($vehicle->status) {
                            'available' => 'Disponível',
                            'sold' => 'Vendido',
                            default => 'Oculto',
                        };
                    @endphp

                    <tr>
                        <td>
                            <div class="vehicle-cell">
                                <div class="thumb">
                                    @if($cover)
                                        <img src="{{ asset('storage/'.$cover->path) }}" alt="Capa">
                                    @endif
                                </div>
                                <div>
                                    <p class="v-title">{{ $vehicle->title }}</p>
                                    <p class="v-meta">{{ $vehicle->brand }} • {{ $vehicle->model }}</p>
                                    <p class="v-meta muted">Slug: {{ $vehicle->slug }}</p>
                                </div>
                            </div>
                        </td>

                        <td>{{ $vehicle->year ?? '-' }}</td>

                        <td>
                            @if($vehicle->price)
                                R$ {{ number_format($vehicle->price, 2, ',', '.') }}
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        <td>
                            <span class="pill {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>

                        <td>
                            @if($vehicle->featured)
                                <span class="pill pill-featured">Destaque</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        <td class="muted">
                            {{ optional($vehicle->created_at)->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="row-actions">
                                {{-- público: ver anúncio --}}
                                <a class="btn-sm" href="{{ route('vehicles.show', $vehicle->slug) }}" target="_blank" rel="noopener">
                                    Ver
                                </a>

                                {{-- ajuste quando existir --}}
                                <a class="btn-sm btn-sm-green" href="{{ route('admin.vehicles.edit', $vehicle->id) }}">
                                    Editar
                                </a>

                                {{-- toggle status (você cria a rota depois) --}}
                                <form method="POST" action="{{ route('admin.vehicles.toggle', $vehicle->id) }}">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-sm-red">
                                        {{ $vehicle->status === 'hidden' ? 'Ativar' : 'Ocultar' }}
                                    </button>
                                </form>

                                <button
                                type="button"
                                class="btn btn-success js-share"
                                data-share-url="{{ route('admin.vehicles.share.file', $vehicle) }}"
                                data-title="{{ $vehicle->title }} {{ $vehicle->year }}"
                                data-text="{{ "Confira este veículo 👇\nR$ ".number_format((float)$vehicle->price, 2, ',', '.')."\n\n".route('vehicles.show', $vehicle) }}"
                                >
                                📤 Compartilhar
                                </button>


                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted" style="padding: 16px;">
                            Nenhum veículo encontrado.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 12px 14px; background: var(--brand-bg-soft); border-top: 1px solid var(--brand-border);">
            {{ $vehicles->withQueryString()->links() }}
        </div>
    </div>

</div>

<script>
(async function () {

  async function fetchFile(url, filename = 'anuncio.jpg') {
    const res = await fetch(url, { cache: 'no-store' });
    if (!res.ok) throw new Error('Falha ao buscar imagem');
    const blob = await res.blob();
    return new File([blob], filename, { type: blob.type || 'image/jpeg' });
  }

  async function tryShare({ url, title, text }) {
    // Share Sheet (quando suportado)
    if (navigator.share) {
      const file = await fetchFile(url, 'anuncio.jpg');

      if (navigator.canShare && !navigator.canShare({ files: [file] })) {
        throw new Error('Navegador não aceita compartilhar arquivo');
      }

      await navigator.share({ title, text, files: [file] });
      return true;
    }
    return false;
  }

  async function copyImage(url) {
    // fallback desktop bom: copiar imagem e colar no WhatsApp Web
    if (!navigator.clipboard || !window.ClipboardItem) return false;

    const res = await fetch(url, { cache: 'no-store' });
    if (!res.ok) return false;
    const blob = await res.blob();

    await navigator.clipboard.write([
      new ClipboardItem({ [blob.type || 'image/jpeg']: blob })
    ]);

    return true;
  }

  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.js-share');
    if (!btn) return;

    const url = btn.dataset.shareUrl;
    const title = btn.dataset.title || 'Anúncio';
    const text = btn.dataset.text || '';

    btn.disabled = true;

    try {
      // 1) tenta abrir Share Sheet direto
      const ok = await tryShare({ url, title, text });
      if (ok) return;

      // 2) fallback: copia imagem e abre WhatsApp web com texto
      const copied = await copyImage(url);
      if (copied) {
        alert('Imagem copiada! Agora cole no WhatsApp (Ctrl+V). Vou abrir o WhatsApp com a mensagem.');
      } else {
        alert('Seu navegador não suporta compartilhar/copiar imagem. Vou abrir a imagem em uma nova aba.');
        window.open(url, '_blank', 'noopener');
        return;
      }

      const wpp = "https://wa.me/?text=" + encodeURIComponent(text);
      window.open(wpp, '_blank', 'noopener');

    } catch (err) {
      console.log(err);
      alert('Não foi possível abrir o compartilhamento neste navegador. Vou abrir a imagem em uma nova aba.');
      window.open(url, '_blank', 'noopener');
    } finally {
      btn.disabled = false;
    }
  });

})();
</script>

@endsection
