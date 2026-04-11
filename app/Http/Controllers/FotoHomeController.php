<?php

namespace App\Http\Controllers;

use App\Models\FotoHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoHomeController extends Controller
{
    protected $redirect_path = '/dashboard/foto-home';
    protected $path_file_save = 'home';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Foto Home';
        $fotoHome = FotoHome::all();
        return view('dashboard.foto-home.index', compact(
            'fotoHome',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foto_home = FotoHome::find($id);
        return view('dashboard.foto-home.edit', compact('foto_home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'path_image' => 'image|file|max:2048',
        ];

        $validatedData = $request->validate($rules);
        $foto_home = FotoHome::where('id', $id)->first();
        if ($request->file('path_image')) {
            if(!empty($foto_home->path_image)){
                unlink($foto_home->path_image);
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

        $foto_home = $foto_home
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Foto Home berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
