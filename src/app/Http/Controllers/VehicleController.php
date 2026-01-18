<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function home()
    {
        $featured = Vehicle::where('status', 'available')
            ->orderByDesc('featured', true)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('home', [
            'vehicles' => $featured,
            'storeName' => SiteSetting::getValue('store_name', 'Loja de Carros'),
        ]);
    }

    public function index(Request $request)
    {
        $query = Vehicle::with('photos')
            ->where('status', 'available');

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        $vehicles = $query
            ->orderByDesc('featured')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles'));
    }



    public function show(string $slug)
    {
        $vehicle = Vehicle::with(['photos' => function ($q) {
            $q->orderByDesc('is_cover')
            ->orderBy('position');
        }])->where('slug', $slug)->firstOrFail();


        return view('vehicles.show', compact('vehicle'));
    }
}
