<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasBalai;
use Illuminate\Support\Facades\Storage;

class AdminFasilitasBalaiController extends Controller
{
    protected $redirect_path = '/dashboard/fasilitas-balai';
    protected $path_file_save = 'fasilitas-balai';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Fasilitas Balai';
        $fasilitasBalai = FasilitasBalai::all();
        return view('dashboard.fasilitas-balai.index', compact(
            'fasilitasBalai',
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
        return view('dashboard.fasilitas-balai.create');
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
        FasilitasBalai::create($validatedData);
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
        $fasilitasBalai = FasilitasBalai::find($id);
        return view('dashboard.fasilitas-balai.show', [
            'fasilitasBalai' => $fasilitasBalai
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
        $fasilitasBalai = FasilitasBalai::find($id);
        return view('dashboard.fasilitas-balai.edit',compact(
            'fasilitasBalai'
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
        $fasilitas_balai = FasilitasBalai::where('id', $id)->first();
        if ($request->file('path_image')) {
            if (!empty($fasilitas_balai->path_image)) {
                unlink($fasilitas_balai->path_image);
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


        $fasilitas_balai = $fasilitas_balai
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
        $fasilitasBalai = FasilitasBalai::find($id);
        if ($fasilitasBalai->image) {
            Storage::delete($fasilitasBalai->image);
        }
        $fasilitasBalai->delete();
        return redirect($this->redirect_path)->with('success', 'Fasilitas Balai berhasil dihapus!');
    }
}