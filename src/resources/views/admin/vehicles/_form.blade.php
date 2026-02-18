@php
  $isEdit = isset($vehicle) && $vehicle->exists;
@endphp

<div class="form-grid">
  <div class="field">
    <label>Título *</label>
    <input type="text" name="title" value="{{ old('title', $vehicle->title ?? '') }}" required>
  </div>

  <div class="field">
    <label>Preço (R$)</label>
    <input type="number" step="0.01" name="price"  inputmode="decimal" placeholder="Ex: 89.990,00" value="{{ old('price', $vehicle->price ?? '') }}">
  </div>

  <div class="field">
    <label>Marca *</label>
    <input type="text" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" required>
  </div>

  <div class="field">
    <label>Modelo *</label>
    <input type="text" name="model" value="{{ old('model', $vehicle->model ?? '') }}" required>
  </div>

  <div class="field">
    <label>Versão</label>
    <input type="text" name="version" value="{{ old('version', $vehicle->version ?? '') }}" placeholder="Ex: LTZ 1.0 Turbo">
  </div>

  <div class="field">
    <label>Ano *</label>
    <input type="number" name="year" value="{{ old('year', $vehicle->year ?? '') }}" required>
  </div>

  <div class="field">
    <label>Ano modelo</label>
    <input type="number" name="model_year" value="{{ old('model_year', $vehicle->model_year ?? '') }}">
  </div>

  <div class="field">
    <label>KM Rodados</label>
    <input type="number" name="mileage_km" value="{{ old('mileage_km', $vehicle->mileage_km ?? '') }}" placeholder="Ex: 35000">
  </div>

  <div class="field">
    <label>Cor</label>
    <input type="text" name="color" value="{{ old('color', $vehicle->color ?? '') }}" placeholder="Ex: Prata">
  </div>

  <div class="field">
    <label>Combustível</label>
    <input type="text" name="fuel" value="{{ old('fuel', $vehicle->fuel ?? '') }}" placeholder="Ex: Flex">
  </div>

  <div class="field">
    <label>Câmbio</label>
    <input type="text" name="transmission" value="{{ old('transmission', $vehicle->transmission ?? '') }}" placeholder="Ex: Automático">
  </div>

  <div class="field">
    <label>Status *</label>
    <select name="status" required>
      @php $st = old('status', $vehicle->status ?? 'available'); @endphp
      <option value="available" @selected($st==='available')>Disponível</option>
      <option value="sold" @selected($st==='sold')>Vendido</option>
      <option value="unavailable" @selected($st==='unavailable')>Indisponível</option>
    </select>
  </div>

  <!-- <div class="field">
    <label>Publicar em</label>
    <input
      type="datetime-local"
      name="published_at"
      value="{{ old('published_at', optional($vehicle->published_at)->format('Y-m-d\TH:i')) }}"
    >

  </div> -->

  <div class="field field-wide">
    <label>Descrição</label>
    <textarea name="description" rows="5">{{ old('description', $vehicle->description ?? '') }}</textarea>
  </div>

  <div class="field field-wide">
    <label class="check">
      <input type="checkbox" name="featured" value="1" @checked(old('featured', $vehicle->featured ?? false))>
      <span>Destaque</span>
    </label>
  </div>

  <div class="field field-wide">
    <label>WhatsApp (apenas número)</label>
    <input type="text" name="whatsapp_phone" value="{{ old('whatsapp_phone', $vehicle->whatsapp_phone ?? '') }}" placeholder="Ex: 61999998888">
    <small>Dica: coloque DDD + número (sem espaços). Você pode montar o link depois.</small>
  </div>



  <div class="field field-wide">
    <label class="file-btn">
      <input
        type="file"
        name="photos[]"
        id="photosInput"
        accept="image/*"
        multiple
        hidden
      >
      Selecionar fotos
    </label>

    <div id="photosPreview" class="photos-preview"></div>
  </div>


  @if(isset($vehicle) && $vehicle->exists && $vehicle->photos && $vehicle->photos->count())
    <div class="field field-wide">
      <label>Fotos cadastradas</label>

      <div class="photos-grid">
        @foreach($vehicle->photos()->orderBy('position')->get() as $photo)
          <div class="photo-card">
            <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->alt_text ?? '' }}">
            <div class="photo-meta">
              <div>#{{ $photo->position }}</div>

              <label class="check" style="margin-top:6px;">
                <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}">
                <span>Excluir</span>
              </label>
            </div>
          </div>
        @endforeach
      </div>

      <small>Marque “Excluir” e salve para remover.</small>
    </div>
  @endif

</div>
