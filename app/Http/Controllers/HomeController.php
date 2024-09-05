<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(){
    // Ambil data untuk slider dan rekomendasi secara acak
    $slider = DB::table('_trailer')->inRandomOrder()->get();
    $recommendations = DB::table('_trailer')->inRandomOrder()->limit(3)->get();
    
    // Ambil data untuk Top 10 Onema This Week secara berurutan
    $topOnema = DB::table('_trailer')->orderBy('populer', 'desc')->get();
    
    return view('home.homepage', compact('slider', 'recommendations', 'topOnema'));
}


    public function ikmal()
    {
        return view('home.detail');
    }

    public function create(Request $request)
    {
        $request->validate([
            'gridTitle' => 'required|string|max:255',
            'gridDeskripsi' => 'required|string',
            'gridVidio' => 'required|file|mimes:mp4,mov,avi,wmv|max:20480',
            'gridPoster' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gridTahun' => 'required|integer',
            'gridOpsi' => 'required|string',
        ]);

        if ($request->hasFile('gridVidio') && $request->hasFile('gridPoster')) {
            // Mengambil nama asli file video dan poster
            $videoName = $request->file('gridVidio')->getClientOriginalName();
            $posterName = $request->file('gridPoster')->getClientOriginalName();

            // Memindahkan file video dan poster ke direktori 'upload'
            $request->file('gridVidio')->move(public_path() . '/upload', $videoName);
            $request->file('gridPoster')->move(public_path() . '/upload', $posterName);

            // Menyimpan data ke dalam database
            DB::table('_trailer')->insert([
                'title' => $request->input('gridTitle'),
                'deskripsi' => $request->input('gridDeskripsi'),
                'vidio' => $videoName, // Menyimpan nama file video ke dalam kolom 'vidio'
                'poster' => $posterName, // Menyimpan nama file poster ke dalam kolom 'poster'
                'tahun' => $request->input('gridTahun'),
                'populer' => $request->input('gridOpsi'),
            ]);
        }


        return redirect()->route('home')->with('success', 'Film berhasil ditambahkan!');
    }

    public function show($id)
    {
        $detail = Trailer::find($id);

        if (!$detail) {
            return redirect()->back()->with('error', 'Data not found');
        }

        return view('home.detail', compact('detail'));
    }
}
