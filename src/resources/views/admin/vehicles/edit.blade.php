@extends('layouts.app')

@section('title', 'Editar veículo')

@section('content')
<style>
  .card{
    background: var(--brand-bg-soft);
    border: 1px solid var(--brand-border);
    border-radius: 14px;
    padding: 16px;
    box-shadow: 0 10px 28px rgba(0,0,0,.06);
  }

  .page-title{
    margin: 0 0 6px;
    font-size: 20px;
    font-weight: 800;
    color: var(--brand-text-main);
  }

  .page-sub{
    margin: 0 0 14px;
    color: var(--brand-text-muted);
    font-size: 13px;
  }

  .alert-success{
    background: rgba(34,197,94,.12);
    border: 1px solid rgba(34,197,94,.35);
    color: var(--brand-text-main);
    padding: 10px 12px;
    border-radius: 10px;
    margin-bottom: 12px;
    font-size: 13px;
  }

  .alert-error{
    background: rgba(239,68,68,.12);
    border: 1px solid rgba(239,68,68,.30);
    color: var(--brand-text-main);
    padding: 10px 12px;
    border-radius: 10px;
    margin-bottom: 12px;
    font-size: 13px;
  }

  .form-grid{
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
  }

  .field-wide{ grid-column: 1 / -1; }

  .field label{
    display: block;
    font-size: 12px;
    color: var(--brand-text-muted);
    margin-bottom: 6px;
    font-weight: 700;
  }

  .field input,
  .field select,
  .field textarea{
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid var(--brand-border);
    background: var(--brand-bg-main);
    color: var(--brand-text-main);
    font-size: 14px;
    outline: none;
  }

  .field input:focus,
  .field select:focus,
  .field textarea:focus{
    border-color: rgba(20,184,166,.65);
    box-shadow: 0 0 0 3px rgba(20,184,166,.18);
  }

  .check{
    display: inline-flex;
    gap: 8px;
    align-items: center;
    color: var(--brand-text-main);
  }

  .actions-row{
    display: flex;
    gap: 10px;
    justify-content: space-between;
    margin-top: 16px;
    flex-wrap: wrap;
  }

  .btn{
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid var(--brand-border);
    background: var(--brand-bg-main);
    color: var(--brand-text-main);
    cursor: pointer;
    text-decoration: none;
    font-weight: 600;
  }

  .btn:hover{ filter: brightness(.98); }

  .btn-primary{
  background: #0f766e;       /* verde sólido */
  border: 1px solid #0f766e;
  color: #ffffff;
  }

  .btn-primary:hover{
    background: #0d5f59;
    border-color: #0d5f59;
  }

  .btn-danger{
    background: #b91c1c;       /* vermelho sólido */
    border: 1px solid #b91c1c;
    color: #ffffff;
  }

  .btn-danger:hover{
    background: #991b1b;
    border-color: #991b1b;
  }


  @media(max-width:720px){
    .form-grid{ grid-template-columns: 1fr; }
    .actions-row{
      flex-direction: column;
      align-items: stretch;
    }
    .btn, .btn-danger{
      width: 100%;
      text-align: center;
    }
  }
</style>

<div class="card">
  <h1 style="margin:0 0 10px;font-size:20px;font-weight:800;color:#0f172a;">Editar veículo</h1>
  <p style="margin:0 0 14px;color:#64748b;font-size:13px;">
    Slug: <strong>{{ $vehicle->slug }}</strong>
  </p>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;color:#166534;padding:10px;border-radius:10px;margin-bottom:12px;">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:12px;">
      {{ $errors->first() }}
    </div>
  @endif

  
    
      <form id="vehicleForm"
          method="POST"
          action="{{ route('admin.vehicles.update', $vehicle) }}"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      @include('admin.vehicles._form', ['vehicle' => $vehicle])
    </form>

    <div class="actions-row">
      {{-- Voltar (esquerda) --}}
      <a class="btn" href="{{ route('admin.vehicles.index') }}">Voltar</a>

      {{-- Excluir (meio) --}}
      <form method="POST"
            action="{{ route('admin.vehicles.destroy', $vehicle) }}"
            onsubmit="return confirm('Tem certeza que deseja excluir este veículo? Essa ação não pode ser desfeita.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger">Excluir veículo</button>
      </form>

      {{-- Salvar (direita) --}}
      <button type="submit" form="vehicleForm" class="btn btn-primary">
        Salvar alterações
      </button>
    </div>

        

    </div>


</div>

<script>
  const input = document.getElementById('photosInput');
  const preview = document.getElementById('photosPreview');

  input?.addEventListener('change', () => {
    preview.innerHTML = ''; // limpa previews antigos

    const files = Array.from(input.files || []);
    files.forEach(file => {
      const url = URL.createObjectURL(file);

      const box = document.createElement('div');
      box.style.border = "1px solid #e2e8f0";
      box.style.borderRadius = "12px";
      box.style.overflow = "hidden";
      box.style.background = "#fff";

      const img = document.createElement('img');
      img.src = url;
      img.style.width = "100%";
      img.style.height = "120px";
      img.style.objectFit = "cover";
      img.onload = () => URL.revokeObjectURL(url);

      box.appendChild(img);
      preview.appendChild(box);
    });
  });
</script>

@endsection
