<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trailer;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    public function index()
    {
        $trailers = Trailer::all();
        return response()->json($trailers, 200);
    }

    public function show($id)
    {
        $trailer = Trailer::find($id);

        if (!$trailer) {
            return response()->json(['message' => 'Trailer not found'], 404);
        }

        return response()->json($trailer, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poster' => 'nullable|string',
            'vidio' => 'nullable|string',
            'tahun' => 'required|integer',
            'populer' => 'nullable|integer',
            'thumbnail' => 'nullable|string',
        ]);

        $trailer = Trailer::create($validated);

        return response()->json(['message' => 'Trailer created', 'data' => $trailer], 201);
    }

    public function update(Request $request, $id)
    {
        $trailer = Trailer::find($id);

        if (!$trailer) {
            return response()->json(['message' => 'Trailer not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poster' => 'nullable|string',
            'vidio' => 'nullable|string',
            'tahun' => 'required|integer',
            'populer' => 'nullable|integer',
            'thumbnail' => 'nullable|string',
        ]);

        $trailer->update($validated);

        return response()->json(['message' => 'Trailer updated', 'data' => $trailer], 200);
    }

    public function destroy($id)
    {
        $trailer = Trailer::find($id);

        if (!$trailer) {
            return response()->json(['message' => 'Trailer not found'], 404);
        }

        $trailer->delete();

        return response()->json(['message' => 'Trailer deleted'], 200);
    }
}
