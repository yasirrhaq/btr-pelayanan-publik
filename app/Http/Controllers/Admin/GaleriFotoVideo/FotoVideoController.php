<?php

namespace App\Http\Controllers\Admin\GaleriFotoVideo;

use App\Http\Controllers\Controller;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoVideoController extends Controller
{
    protected $redirect_path = '/dashboard/galeri/foto-video';
    protected $path_file_save = 'galeri';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Foto';
        $fotoVideo = GaleriFoto::all();
        return view('dashboard.galeri-foto-video.index', compact(
            'fotoVideo',
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
        return view('dashboard.galeri-foto-video.create');
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
        GaleriFoto::create($validatedData);
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
        $galeriFoto = GaleriFoto::find($id);
        return view('dashboard.galeri-foto-video.show', [
            'galeri_foto' => $galeriFoto
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
        $galeri_foto = GaleriFoto::find($id);
        return view('dashboard.galeri-foto-video.edit', compact(
            'galeri_foto'
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
        $galeri_foto = GaleriFoto::where('id', $id)->first();
        if ($request->file('path_image')) {
            if (!empty($galeri_foto->path_image)) {
                unlink($galeri_foto->path_image);
            }

            $slug      = slugCustom($request->nama);
            $file      = $request->file() ?? [];
            $path      = 'uploads/galeri/';
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['path_image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['path_image'];
        }


        $galeri_foto = $galeri_foto
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
        $galeri_foto = GaleriFoto::find($id);
        if ($galeri_foto->path_image) {
            Storage::delete($galeri_foto->path_image);
        }
        $galeri_foto->delete();
        return redirect($this->redirect_path)->with('success', 'Data berhasil dihapus!');
    }
}
