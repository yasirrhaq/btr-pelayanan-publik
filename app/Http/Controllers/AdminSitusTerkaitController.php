<?php

namespace App\Http\Controllers;

use App\Models\SitusTerkait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSitusTerkaitController extends Controller
{
    protected $redirect_path = '/dashboard/situs-terkait';
    protected $path_file_save = 'situs-terkait';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Foto Home';
        $situsTerkait = SitusTerkait::all();
        return view('dashboard.situs-terkait.index', compact(
            'situsTerkait',
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
        return view('dashboard.situs-terkait.create');
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
            'url'=>'required|max:255',
            'path_image' => 'image|file|max:1024'
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

        SitusTerkait::create($validatedData);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id)
    {
        $situsTerkait = SitusTerkait::find($id);
        return view('dashboard.situs-terkait.edit', compact(
            'situsTerkait'
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
            'url' => 'required|max:255',
            'path_image' => 'image|file|max:1024'
        ];

        $validatedData = $request->validate($rules);
        $situsTerkait = SitusTerkait::where('id', $id)->first();
        if ($request->file('path_image')) {
            if (!empty($situsTerkait->path_image)) {
                unlink($situsTerkait->path_image);
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


        $situsTerkait = $situsTerkait
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $situsTerkait = SitusTerkait::find($id);
        if ($situsTerkait->path_image) {
            Storage::delete($situsTerkait->path_image);
        }
        $situsTerkait->delete();
        return redirect($this->redirect_path)->with('success', 'Data berhasil dihapus!');
    }
}
