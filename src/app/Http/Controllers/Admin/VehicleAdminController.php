<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VehiclePhoto;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class VehicleAdminController extends Controller
{

    private function handleUploads(Request $request, \App\Models\Vehicle $vehicle): void
    {
            if (!$request->hasFile('photos')) return;

            $files = $request->file('photos', []);
            // pega o próximo position
            $pos = (int) ($vehicle->photos()->max('position') ?? 0);

            foreach ($files as $file) {
                if (!$file || !$file->isValid()) continue;

                $pos++;

                // salva em storage/app/public/vehicles/{id}/
                $path = $file->store("vehicles/{$vehicle->id}", 'public');

                $vehicle->photos()->create([
                    'path' => $path,
                    'position' => $pos,
                    'alt_text' => $vehicle->title,
                ]);
            }
        }    


    private function validateVehicle(Request $request): array
    {
        return $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['nullable','numeric','min:0'],

            'brand' => ['required','string','max:120'],
            'model' => ['required','string','max:120'],
            'version' => ['nullable','string','max:120'],

            'year' => ['required','integer','min:1900','max:2100'],
            'model_year' => ['nullable','integer','min:1900','max:2100'],

            'mileage_km' => ['nullable','integer','min:0'],
            'color' => ['nullable','string','max:80'],

            'fuel' => ['nullable','string','max:80'],
            'transmission' => ['nullable','string','max:80'],

            'status' => ['required','in:available,sold,unavailable'],
            'featured' => ['nullable','boolean'],

            'whatsapp_phone' => ['nullable','string','max:30'],
            'published_at' => ['nullable','date'],

            'photos' => ['nullable','array','max:12'],
            'photos.*' => ['image','mimes:jpg,jpeg,png,webp','max:5120'], // 5MB

        ]);
    }

    public function index(Request $request)
    {
        $q = $request->get('q');

        $vehicles = Vehicle::query()
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'ILIKE', "%{$q}%")
                    ->orWhere('brand', 'ILIKE', "%{$q}%")
                    ->orWhere('model', 'ILIKE', "%{$q}%");
            })
            ->when($request->filled('brand'), fn ($q) =>
                $q->where('brand', 'ILIKE', '%'.$request->brand.'%')
            )
            ->when($request->filled('status'), fn ($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->filled('featured'), fn ($q) =>
                $q->where('featured', (bool) $request->featured)
            )
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        // 🔥 Normaliza preço antes da validação
        if ($request->filled('price')) {
            $price = preg_replace('/[^0-9,\.]/', '', $request->price);
            $price = str_replace('.', '', $price);   // remove milhar
            $price = str_replace(',', '.', $price); // vírgula -> ponto

            $request->merge([
                'price' => $price
            ]);
        }

        $data = $this->validateVehicle($request);
        $data['featured'] = $request->boolean('featured');

        // gera slug
        $base = Str::slug(trim(($data['brand'] ?? '').' '.($data['model'] ?? '').' '.($data['year'] ?? '').' '.($data['title'] ?? '')));
        $slug = $base ?: Str::slug($data['title']);

        $i = 2;
        while (\App\Models\Vehicle::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }
        $data['slug'] = $slug;

        $vehicle = \App\Models\Vehicle::create($data);
        $this->handleUploads($request, $vehicle);

        return redirect()
            ->route('admin.vehicles.edit', $vehicle)
            ->with('success','Veículo criado!');
    }




    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, \App\Models\Vehicle $vehicle)
    {
        $data = $this->validateVehicle($request);
        $data['featured'] = $request->boolean('featured');

        $vehicle->update($data);
        if ($request->filled('delete_photos')) {
            $ids = $request->input('delete_photos', []);
            $photos = $vehicle->photos()->whereIn('id', $ids)->get();

            foreach ($photos as $p) {
                // remove arquivo físico
                Storage::disk('public')->delete($p->path);
                $p->delete();
            }
        }
        $this->handleUploads($request, $vehicle);


        return redirect()->route('admin.vehicles.edit', $vehicle)->with('success','Veículo atualizado!');
    }

    public function toggleStatus(Vehicle $vehicle)
    {
        $vehicle->status = $vehicle->status === 'hidden'
            ? 'available'
            : 'hidden';

        $vehicle->save();

        return back()->with('success', 'Status atualizado.');
    }


    public function destroy(Vehicle $vehicle)
    {
        // apaga fotos (arquivos) antes
        foreach ($vehicle->photos as $photo) {
            if ($photo->path) {
                Storage::disk('public')->delete($photo->path);
            }
        }

        // apaga registros das fotos e o veículo
        $vehicle->photos()->delete();
        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Veículo excluído com sucesso.');
    }

  


    private function buildShareImageUrl(Vehicle $vehicle): string
    {
        $photo = $vehicle->photos()->orderByDesc('is_cover')->orderBy('position')->first();
        if (!$photo) abort(404, 'Veículo sem foto para compartilhar.');

        $manager = new ImageManager(new Driver());
        $img = $manager->read(storage_path('app/public/' . $photo->path));

        // ✅ NÃO corta mais (mantém o formato original)
        // opcional: só reduz se for gigante (mantém proporção)
        $img = $img->scaleDown(2000, 2000);

        $w = $img->width();
        $h = $img->height();

        // ✅ overlay proporcional ao tamanho da foto
        $barHeight = max(140, (int) round($h * 0.18)); // 18% da altura (mín 140px)

        $overlay = $manager->create($w, $barHeight)->fill('rgba(0,0,0,0.60)');
        $img->place($overlay, 'bottom-left', 0, 0);

        $fontPath = storage_path('app/fonts/Montserrat-Black.ttf');

        $text = trim(
            "{$vehicle->title} {$vehicle->year}"
            . ($vehicle->description ? "  •  {$vehicle->description}" : "")
            . "  •  R$ " . number_format((float)$vehicle->price, 2, ',', '.')
        );

        $maxWidth = $w - 120;

        // ✅ tamanho de fonte proporcional
        $fontSize = max(28, (int) round($w * 0.035)); // ex: 1080 => ~38
        $y = $h - $barHeight + 30;

        $img->text($text, 60, $y, function ($font) use ($fontPath, $maxWidth, $fontSize) {
            $font->filename($fontPath);
            $font->size($fontSize);
            $font->color('ffffff');
            $font->wrap($maxWidth); // pode quebrar linha se precisar
            $font->align('left');
            $font->valign('top');
        });

        $path = "share/vehicle-{$vehicle->id}.jpg";
        Storage::disk('public')->put($path, (string) $img->toJpeg(90));

        return asset("storage/$path");
    }

    public function generateShareImage(Vehicle $vehicle)
    {
        return redirect()->to($this->buildShareImageUrl($vehicle));
    }


    public function shareStatus(Vehicle $vehicle)
    {
        $imageUrl = $this->generateShareImage($vehicle);
        $link = route('vehicles.show', $vehicle);

        $text = urlencode("Confira este veículo 👇\n$link");

        return redirect("https://wa.me/?text=$text");
    }

    public function shareSmart(Vehicle $vehicle)
    {
        $imageUrl = $this->buildShareImageUrl($vehicle);

        $link = route('vehicles.show', $vehicle);
        $text = "Confira este veículo 👇\n\n"
            . "{$vehicle->title} {$vehicle->year}\n"
            . "R$ " . number_format((float)$vehicle->price, 2, ',', '.') . "\n\n"
            . $link;

        return view('admin.vehicles.share-smart', compact('vehicle', 'imageUrl', 'text'));
    }

    public function shareFile(Vehicle $vehicle)
    {
        // gera/garante a imagem
        $imageUrl = $this->buildShareImageUrl($vehicle); // do helper que criamos

        // converte URL -> path do storage public
        $path = "share/vehicle-{$vehicle->id}.jpg";

        abort_unless(Storage::disk('public')->exists($path), 404);

        return response()->file(
            Storage::disk('public')->path($path),
            [
                'Content-Type' => 'image/jpeg',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            ]
        );
    }



}
