<?php

namespace App\Http\Controllers\Admin\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LandingPageTipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{

    public function __construct()
    {
        $this->path_file_save = 'uploads/landing-page/';
        $this->redirect_path = 'dashboard/landing-page';

        if (app()->runningInConsole() || !request()->filled('type')) {
            return;
        }

        $type = $this->cekTypeSlug(request());
        $this->path_file_save = 'uploads/landing-page/' . $type->title . '/' . date('d-m-Y') . '/';
        $this->redirect_path = 'dashboard/landing-page?type=' . $type->slug;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function cekTypeSlug(Request  $request){
        $type = $request->type;
        $cek_type = LandingPageTipe::whereSlug($type)->first();
        if (empty($cek_type)) {
            abort(404, 'Sepertinya anda menghilang :V');
        }
        return $cek_type;
    }
    public function index(Request $request)
    {
        $cek_type = $this->cekTypeSlug($request);
        $title = "Landing Page - $cek_type->title";
        $data = LandingPage::whereLandingPageTipeId($cek_type->id)->get();
        return view('dashboard.landing-page.index', compact(
            'data',
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $this->cekTypeSlug($request);
        return view('dashboard.landing-page.create', compact('type'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        $type = $this->cekTypeSlug($request);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'deskripsi' => 'required',
            'image' => 'image|file|max:1024',
        ]);


        if ($request->file('image')) {

            $slug      = slugCustom($type->title);
            $file      = $request->file() ?? [];
            $path      = $this->path_file_save;
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['path'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['image'];
        }
        $validatedData['landing_page_tipe_id'] = $type->id;
        LandingPage::create($validatedData);
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
        // $LandingPage = LandingPage::find($id);
        // return view('dashboard.landing-page.show', [
        //     'galeri_foto' => $LandingPage
        // ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Post  $post
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit(Int $id)
    {
        $type = $this->cekTypeSlug(request());
        $title = "Landing Page - $type->title";
        $landing_page = LandingPage::find($id);
        return view('dashboard.landing-page.edit', compact(
            'landing_page',
            'title'
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

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'deskripsi' => 'required',
            'image' => 'image|file|max:1024',
        ]);
        $landing_page = LandingPage::find($id);
        if ($request->file('image')) {
            if (!empty($landing_page->path)) {
                unlink($landing_page->path);
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

            $validatedData['path'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['image'];
        }


        $landing_page = $landing_page
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
        $landing_page = LandingPage::find($id);
        if ($landing_page->path) {
            Storage::delete($landing_page->path);
        }
        $landing_page->deleted_by = auth()->id();
        $landing_page->save();
        $landing_page->delete();
        return redirect($this->redirect_path)->with('success', 'Data berhasil dihapus!');
    }
}
