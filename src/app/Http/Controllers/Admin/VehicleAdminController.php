<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VehiclePhoto;
use Illuminate\Support\Facades\Storage;


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

        

        return redirect()->route('admin.vehicles.edit', $vehicle)->with('success','Veículo criado!');
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

}
