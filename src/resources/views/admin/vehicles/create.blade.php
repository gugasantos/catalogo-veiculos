@extends('layouts.app')

@section('title', 'Novo veículo')

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
    margin: 0 0 10px;
    font-size: 20px;
    font-weight: 800;
    color: var(--brand-text-main);
  }

  .alert-error{
    background: rgba(239, 68, 68, .12);
    border: 1px solid rgba(239, 68, 68, .30);
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
    padding: 10px 10px;
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
    border-color: rgba(20, 184, 166, .65);
    box-shadow: 0 0 0 3px rgba(20, 184, 166, .18);
  }

  .check{
    display: inline-flex;
    gap: 8px;
    align-items: center;
    color: var(--brand-text-main);
  }

  .actions{
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 14px;
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
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
  }

  .btn:hover{
    filter: brightness(0.98);
  }

  .btn-primary{
    background: rgba(15, 118, 75, 0.30);
    border-color: #14b8a6;
    color: #a5f3fc;
  }

  @media(max-width:720px){
    .form-grid{ grid-template-columns: 1fr; }
    .actions{ justify-content: stretch; }
    .btn{ width: 100%; }
  }
</style>


<div class="card">
  <h1 style="margin:0 0 10px;font-size:20px;font-weight:800;color:#0f172a;">Novo veículo</h1>

  @if($errors->any())
    <div style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:12px;">
      {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin.vehicles.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.vehicles._form', ['vehicle' => new \App\Models\Vehicle()])
    <div class="actions">
      <a class="btn" href="{{ route('admin.vehicles.index') }}">Voltar</a>
      <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
  </form>
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



