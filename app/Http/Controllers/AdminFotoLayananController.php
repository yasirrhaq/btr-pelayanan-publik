<?php

namespace App\Http\Controllers;

use App\Models\UrlLayanan;
use Illuminate\Http\Request;

class AdminFotoLayananController extends Controller
{
    protected $redirect_path = '/dashboard/foto-layanan';
    protected $path_file_save = 'foto-layanan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Foto Layanan';
        $foto_layanan = UrlLayanan::find([1,2]);
        return view('dashboard.foto-layanan.index', compact(
            'foto_layanan',
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
        $foto_layanan = UrlLayanan::find($id);
        return view('dashboard.foto-layanan.edit', compact('foto_layanan'));
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
            'name' => 'required|max:255',
            'deskripsi' => 'required',
            'path_image' => 'image|file|max:2048',
        ];

        $validatedData = $request->validate($rules);
        $foto_layanan = UrlLayanan::where('id', $id)->first();
        if ($request->file('path_image')) {
            if(!empty($foto_layanan->path_image)){
                unlink($foto_layanan->path_image);
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

        $foto_layanan = $foto_layanan
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Foto Layanan berhasil diupdate!');
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
