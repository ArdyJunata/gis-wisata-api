<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WisataController extends Controller
{
    public function index()
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
        )->where('id', $id)->first();
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

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_wisata' => 'required',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'jenis_wisata' => 'required',
            'foto' => 'required',
            'geometry' => 'required|JSON'
        ]);

        $data = Wisata::find($id);
        $data->nama_wisata = $request->nama_wisata;
        $data->alamat = $request->alamat;
        $data->kabupaten = $request->kabupaten;
        $data->jenis_wisata = $request->jenis_wisata;
        $data->foto = $request->foto;
        $data->geometry = DB::Raw("ST_GeomFromGeoJSON('".$request->geometry."')");
        $data->save();

        // dd($validate);

        return response()->json(["message" => "data updated.", "data" => $data]);

    }

    public function delete($id)
    {
        $data = Wisata::find($id);
        if($data)
        {
            $data->delete();
        } else {
            return response()->json(['message' => 'data no found.' ]);
        }
        return response()->json(['message' => 'delete success.' ]);
    }
}
