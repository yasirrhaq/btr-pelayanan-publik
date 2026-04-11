<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;

class AdminStrukturOrganisasiController extends Controller
{
    protected $redirect_path = '/dashboard/struktur-organisasi';
    protected $path_file_save = 'struktur-organisasi';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Fasilitas Balai';
        $strukturOrganisasi = StrukturOrganisasi::all();
        return view('dashboard.struktur-organisasi.index', compact(
            'strukturOrganisasi',
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.struktur-organisasi.create');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'path_image' => 'image|file|max:1024',
        ]);


        if ($request->file('path_image')) {

            $slug      = slugCustom($request->nama);
            $file      = $request->file() ?? [];
            $path      = 'uploads/'.$this->path_file_save.'/';
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['path_image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['path_image'];
        }

        $validatedData['created_by'] = auth()->id();
        StrukturOrganisasi::create($validatedData);
        return redirect($this->redirect_path)->with('success', 'Berhasil menambahkan Data');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Post  $post
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($id)
    {
        $strukturOrganisasi = StrukturOrganisasi::find($id);
        return view('dashboard.struktur-organisasi.show', [
            'strukturOrganisasi' => $strukturOrganisasi
        ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Post  $post
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit(Int $id)
    {
        $strukturOrganisasi = StrukturOrganisasi::find($id);
        return view('dashboard.struktur-organisasi.edit',compact(
            'strukturOrganisasi'
        ));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Post  $post
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, Int $id)
    {
        $rules = [
            'title' => 'required|max:255',
            'path_image' => 'image|file|max:1024',
        ];
        
        $validatedData = $request->validate($rules);
        $struktur_organisasi = StrukturOrganisasi::where('id', $id)->first();
        if ($request->file('path_image')) {
            if (!empty($struktur_organisasi->path_image)) {
                unlink($struktur_organisasi->path_image);
            }

            $slug      = slugCustom($request->nama);
            $file      = $request->file() ?? [];
            $path      = 'uploads/'.$this->path_file_save.'/';
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['path_image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['path_image'];
        }


        $struktur_organisasi = $struktur_organisasi
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Data berhasil diupdate!');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Post  $post
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Int $id)
    {
        $strukturOrganisasi = StrukturOrganisasi::find($id);
        if ($strukturOrganisasi->image) {
            Storage::delete($strukturOrganisasi->image);
        }
        $strukturOrganisasi->delete();
        return redirect($this->redirect_path)->with('success', 'Struktur Organisasi  berhasil dihapus!');
    }
}