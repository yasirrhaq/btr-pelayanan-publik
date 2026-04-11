<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKaryaIlmiahController extends Controller
{
    protected $redirect_path = '/dashboard/karya-ilmiah';
    protected $path_file_save = 'gambar-karya-ilmiah';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.karya-ilmiah.index', ['karyaIlmiah' => KaryaIlmiah::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.karya-ilmiah.create');
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
            'slug' => 'required|unique:karya_ilmiah',
            'penerbit' => 'required',
            'tanggal_terbit' => 'required',
            'issn_online' => 'required',
            'issn_cetak' => 'required',
            'subyek' => 'required',
            'bahasa' => 'required',
            'link_download' => 'required',
            'path_image' => 'image|file|max:1024',
            'abstract' => 'required|max:255'
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
            // dd($config_file);

            $validatedData['path_image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['path_image'];
        }

        KaryaIlmiah::create($validatedData);
        return redirect($this->redirect_path)->with('success', 'Karya Ilmiah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KaryaIlmiah  $karyaIlmiah
     * @return \Illuminate\Http\Response
     */
    public function show(KaryaIlmiah $karyaIlmiah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KaryaIlmiah  $karyaIlmiah
     * @return \Illuminate\Http\Response
     */
    public function edit(KaryaIlmiah $karyaIlmiah)
    {
        return view('dashboard.karya-ilmiah.edit', [
            'karya' => $karyaIlmiah
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaryaIlmiah  $karyaIlmiah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaryaIlmiah $karyaIlmiah)
    {
        
        $rules = [
            'title' => 'required|max:255',
            'penerbit' => 'required',
            'tanggal_terbit' => 'required',
            'issn_online' => 'required',
            'issn_cetak' => 'required',
            'subyek' => 'required',
            'bahasa' => 'required',
            'path_image' => 'image|file|max:1024',
            'link_download' => 'required',
            'abstract' => 'required|max:255'
        ];
        $validatedData = $request->validate($rules);
        $karya_ilmiah = KaryaIlmiah::where('id', $karyaIlmiah->id)->first();
        if ($request->file('path_image')) {
            if (!empty($karya_ilmiah->path_image)) {
                unlink($karya_ilmiah->path_image);
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


        $karya_ilmiah = $karya_ilmiah
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaryaIlmiah  $karyaIlmiah
     * @return \Illuminate\Http\Response
     */
    public function destroy(KaryaIlmiah $karyaIlmiah)
    {
        if ($karyaIlmiah->path_image) {
            Storage::delete($karyaIlmiah->path_image);
        }
        KaryaIlmiah::destroy($karyaIlmiah->id);
        return redirect($this->redirect_path)->with('success', 'Karya Ilmiah berhasil dihapus!');
    }
}
