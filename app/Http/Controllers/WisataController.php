<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WisataController extends Controller
{
    public function index()
    {
        return Wisata::all();
    }

    public function show($id)
    {
        return Wisata::select(
            'id',
            'nama_wisata',
            'alamat',
            'kabupaten',
            'jenis_wisata',
            'foto',
            DB::Raw('ST_AsGeoJSON(geometry) as geometry')
        )->get();
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'nama_wisata' => 'required',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'jenis_wisata' => 'required',
            'foto' => 'required',
            'geometry' => 'required|JSON'
        ]);

        $validate['geometry'] = DB::Raw("ST_GeomFromGeoJSON('".$request->geometry."')");

        $data = Wisata::create($validate);

        // dd($validate);

        return response()->json(["message" => "data added.", "data" => $data]);

    }
}
