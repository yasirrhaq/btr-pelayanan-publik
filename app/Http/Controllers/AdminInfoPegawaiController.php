<?php

namespace App\Http\Controllers;

use App\Models\InfoPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInfoPegawaiController extends Controller
{
    protected $redirect_path = '/dashboard/info-pegawai';
    protected $path_file_save = 'info-pegawai';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infoPegawai = InfoPegawai::all();
        return view('dashboard.info-pegawai.index', compact('infoPegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.info-pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        InfoPegawai::create($validatedData);
        return redirect($this->redirect_path)->with('success', 'Berhasil menambahkan Data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infoPegawai = InfoPegawai::find($id);
        return view('dashboard.info-pegawai.show', [
            'infoPegawai' => $infoPegawai
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infoPegawai = InfoPegawai::find($id);
        return view('dashboard.info-pegawai.edit',compact(
            'infoPegawai'
        ));
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
            'path_image' => 'image|file|max:1024',
        ];
        
        $validatedData = $request->validate($rules);
        $info_pegawai = InfoPegawai::where('id', $id)->first();
        if ($request->file('path_image')) {
            if (!empty($info_pegawai->path_image)) {
                unlink($info_pegawai->path_image);
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


        $info_pegawai = $info_pegawai
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Info pegawai berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $infoPegawai = InfoPegawai::find($id);
        if ($infoPegawai->image) {
            Storage::delete($infoPegawai->image);
        }
        $infoPegawai->delete();
        return redirect($this->redirect_path)->with('success', 'Info pegawai berhasil dihapus!');
    }
}
