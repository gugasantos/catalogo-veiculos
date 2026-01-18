@extends('layouts.app')

@section('title', 'Novo veículo')

@section('content')
<style>
  .card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:16px;box-shadow:0 10px 28px rgba(0,0,0,.06);}
  .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;}
  .field-wide{grid-column:1 / -1;}
  .field label{display:block;font-size:12px;color:#64748b;margin-bottom:6px;font-weight:600;}
  .field input,.field select,.field textarea{width:100%;padding:10px 10px;border-radius:10px;border:1px solid #cbd5e1;font-size:14px;}
  .check{display:flex;gap:8px;align-items:center;}
  .actions{display:flex;gap:10px;justify-content:flex-end;margin-top:14px;}
  .btn{padding:10px 14px;border-radius:10px;border:1px solid #cbd5e1;background:#fff;cursor:pointer}
  .btn-primary{background:#0284c7;border-color:#0284c7;color:#fff;}
  @media(max-width:720px){.form-grid{grid-template-columns:1fr;}}
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



