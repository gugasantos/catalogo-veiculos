<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Compartilhar anúncio</title>
  <style>
    body { font-family: system-ui, Arial; margin: 16px; }
    .wrap { max-width: 520px; margin: 0 auto; }
    img { width: 100%; border-radius: 12px; display: block; }
    .row { display:flex; gap:10px; flex-wrap:wrap; margin-top:12px; }
    .btn { padding:12px 14px; border-radius:10px; text-decoration:none; border:0; cursor:pointer; }
    .btn-primary { background:#111; color:#fff; }
    .btn-wpp { background:#25D366; color:#fff; }
    .btn-gray { background:#eee; color:#111; }
    pre { white-space: pre-wrap; background:#f7f7f7; padding:12px; border-radius:10px; margin-top:12px; }
    small { color:#555; display:block; margin-top:8px; }
  </style>
</head>
<body>
  <div class="wrap">
    <h2>Compartilhar anúncio</h2>

    <img id="shareImg" src="{{ $imageUrl }}" alt="Imagem do anúncio">

    <pre id="shareText">{{ $text }}</pre>
    <small id="statusMsg"></small>

    <div class="row">
      <button class="btn btn-primary" id="btnShare">Compartilhar (imagem + mensagem)</button>
      <button class="btn btn-gray" id="btnCopyImg">Copiar imagem</button>
      <button class="btn btn-gray" id="btnCopyText">Copiar mensagem</button>
      <a class="btn btn-wpp" target="_blank" href="https://wa.me/?text={{ urlencode($text) }}">
        Abrir WhatsApp (texto)
      </a>
      <a class="btn btn-gray" target="_blank" href="{{ $imageUrl }}">Abrir imagem</a>
    </div>

    <small>
      Dica desktop: se o “Compartilhar” não funcionar no seu navegador, clique em <b>Copiar imagem</b> e depois cole no WhatsApp Web (Ctrl+V).
    </small>

    <script>
      const imageUrl = @json($imageUrl);
      const text = @json($text);
      const statusMsg = document.getElementById('statusMsg');

      async function fetchImageFile() {
        const res = await fetch(imageUrl, { cache: 'no-store' });
        const blob = await res.blob();
        return new File([blob], 'anuncio.jpg', { type: blob.type || 'image/jpeg' });
      }

      async function doShare() {
        try {
          if (!navigator.share) {
            statusMsg.textContent = 'Seu navegador não suporta Share Sheet aqui. Use "Copiar imagem" + WhatsApp Web.';
            return;
          }

          const file = await fetchImageFile();

          if (navigator.canShare && !navigator.canShare({ files: [file] })) {
            statusMsg.textContent = 'Share Sheet não aceita arquivos neste navegador. Use "Copiar imagem".';
            return;
          }

          await navigator.share({
            title: 'Anúncio de veículo',
            text,
            files: [file],
          });

          statusMsg.textContent = 'Compartilhamento aberto.';
        } catch (e) {
          // Cancelamento é normal
          statusMsg.textContent = 'Compartilhamento cancelado ou indisponível.';
          console.log(e);
        }
      }

      async function copyImageToClipboard() {
        try {
          if (!navigator.clipboard || !window.ClipboardItem) {
            statusMsg.textContent = 'Seu navegador não permite copiar imagem. Use "Abrir imagem" e salve.';
            return;
          }

          const res = await fetch(imageUrl, { cache: 'no-store' });
          const blob = await res.blob();

          await navigator.clipboard.write([
            new ClipboardItem({ [blob.type || 'image/jpeg']: blob })
          ]);

          statusMsg.textContent = 'Imagem copiada! Agora cole no WhatsApp (Ctrl+V).';
        } catch (e) {
          statusMsg.textContent = 'Não foi possível copiar a imagem (permissão/limite do navegador).';
          console.log(e);
        }
      }

      async function copyText() {
        try {
          await navigator.clipboard.writeText(text);
          statusMsg.textContent = 'Mensagem copiada!';
        } catch (e) {
          statusMsg.textContent = 'Não foi possível copiar a mensagem.';
        }
      }

      document.getElementById('btnShare').addEventListener('click', doShare);
      document.getElementById('btnCopyImg').addEventListener('click', copyImageToClipboard);
      document.getElementById('btnCopyText').addEventListener('click', copyText);

      // tenta automaticamente no MOBILE (fica ótimo)
      const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
      if (isMobile) doShare();
    </script>
  </div>
</body>
</html>
