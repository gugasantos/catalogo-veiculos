@extends('layouts.app')

@section('title', 'Admin - Veículos')

@section('content')
<style>
  .admin-wrap { display: grid; gap: 14px; }

  .panel{
    background: var(--brand-bg-soft);
    border: 1px solid var(--brand-border);
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 10px 22px rgba(0,0,0,.06);
  }

  .admin-header{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
  }

  .admin-title{
    margin:0;
    font-size:20px;
    font-weight:800;
    letter-spacing:-0.2px;
    color: var(--brand-text-main);
  }

  .admin-subtitle{
    margin:4px 0 0;
    font-size:13px;
    color: var(--brand-text-muted);
  }

  .actions{ display:flex; gap:10px; align-items:center; flex-wrap:wrap; }

  .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:8px 12px;
    border-radius:12px;
    font-size:13px;
    font-weight:800;
    border:1px solid var(--brand-border);
    background: var(--brand-bg-main);
    color: var(--brand-text-main);
    cursor:pointer;
    text-decoration:none;
    user-select:none;
    transition: transform .08s ease, box-shadow .12s ease, filter .12s ease;
  }
  .btn:hover{ box-shadow: 0 10px 16px rgba(0,0,0,.07); filter: brightness(.99); }
  .btn:active{ transform: translateY(1px); }

  /* Botão principal (mesmo padrão do salvar) */
  .btn-primary{
    background:#0f766e;
    border-color:#0f766e;
    color:#fff;
  }
  .btn-primary:hover{ background:#0d5f59; border-color:#0d5f59; }

  /* Botão danger (logout por exemplo) */
  .btn-danger{
    background:#b91c1c;
    border-color:#b91c1c;
    color:#fff;
  }
  .btn-danger:hover{ background:#991b1b; border-color:#991b1b; }

  .filters{
    display:grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap:12px;
  }

  .filters input, .filters select{
    width:100%;
    padding:9px 10px;
    font-size:13px;
    border-radius:12px;
    border:1px solid var(--brand-border);
    background: var(--brand-bg-main);
    color: var(--brand-text-main);
    outline:none;
  }

  .filters input:focus, .filters select:focus{
    border-color: rgba(20,184,166,.65);
    box-shadow: 0 0 0 3px rgba(20,184,166,.18);
  }

  .filters-actions{
    margin-top:10px;
    display:flex;
    justify-content:flex-end;
    gap:10px;
    flex-wrap:wrap;
  }

  @media (max-width: 950px){
    .filters{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }
  @media (max-width: 620px){
    .filters{ grid-template-columns: 1fr; }
    .filters-actions .btn{ width:100%; }
  }

  .table-wrap{
    overflow:auto;
    border-radius:14px;
    border:1px solid var(--brand-border);
    background: var(--brand-bg-soft);
  }

  table{ width:100%; border-collapse:collapse; min-width:920px; }

  thead th{
    text-align:left;
    font-size:12px;
    color: var(--brand-text-muted);
    font-weight:800;
    letter-spacing:.02em;
    padding:12px 12px;
    border-bottom:1px solid var(--brand-border);
    background: var(--brand-bg-soft);
    white-space:nowrap;
  }

  tbody td{
    padding:12px 12px;
    border-bottom:1px solid var(--brand-border);
    font-size:13px;
    color: var(--brand-text-main);
    vertical-align:middle;
    white-space:nowrap;
  }

  tbody tr:hover{ filter: brightness(.98); }

  .vehicle-cell{ display:flex; align-items:center; gap:10px; min-width:320px; }

  .thumb{
    width:54px;
    height:40px;
    border-radius:10px;
    background: var(--brand-border);
    overflow:hidden;
    flex:0 0 auto;
    border:1px solid var(--brand-border);
  }
  .thumb img{ width:100%; height:100%; object-fit:cover; display:block; }

  .v-title{ font-weight:800; font-size:13px; margin:0; line-height:1.1; color: var(--brand-text-main); }
  .v-meta{ margin:4px 0 0; font-size:12px; color: var(--brand-text-muted); line-height:1.1; }

  .pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 10px;
    border-radius:999px;
    font-size:11px;
    font-weight:900;
    border:1px solid var(--brand-border);
    background: var(--brand-bg-main);
    color: var(--brand-text-main);
  }

  .pill-available{ background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.35); color: #16a34a; }
  .pill-sold{      background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.30); color: #dc2626; }
  .pill-hidden{    background: rgba(234,179,8,.15); border-color: rgba(234,179,8,.35); color: #b45309; }
  .pill-featured{  background: rgba(234,179,8,.15); border-color: rgba(234,179,8,.35); color: #b45309; }

    .row-actions{
    display:flex;
    gap:8px;
    justify-content:flex-end;
    flex-wrap:nowrap;   /* impede quebra */
    align-items:center;
    }

  .btn-sm{
    padding:7px 10px;
    border-radius:12px;
    font-size:12px;
    font-weight:900;
    border:1px solid var(--brand-border);
    background: var(--brand-bg-main);
    color: var(--brand-text-main);
    cursor:pointer;
    text-decoration:none;
  }

  .btn-sm-green{
    background:#0f766e;
    border-color:#0f766e;
    color:#fff;
  }
  .btn-sm-green:hover{ background:#0d5f59; border-color:#0d5f59; }

  .btn-sm-red{
    background:#b91c1c;
    border-color:#b91c1c;
    color:#fff;
  }
  .btn-sm-red:hover{ background:#991b1b; border-color:#991b1b; }

  /* Compartilhar (um azul/neutral forte) */
  .btn-success{
    background:#1d4ed8;
    border-color:#1d4ed8;
    color:#fff;
  }
  .btn-success:hover{ background:#1e40af; border-color:#1e40af; }

  .muted{ color: var(--brand-text-muted); font-size:12px; }
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
                <button type="submit" class="btn btn-danger">Sair</button>

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

                                <!-- <button
                                type="button"
                                class="btn btn-success js-share"
                                data-share-url="{{ route('admin.vehicles.share.file', $vehicle) }}"
                                data-title="{{ $vehicle->title }} {{ $vehicle->year }}"
                                data-text="{{ "Confira este veículo 👇\nR$ ".number_format((float)$vehicle->price, 2, ',', '.')."\n\n".route('vehicles.show', $vehicle) }}"
                                >
                                📤 Compartilhar
                                </button> -->


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
