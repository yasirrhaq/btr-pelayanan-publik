<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan as FacadesArtisan;

class AdminSettings extends Controller
{
    protected $path_file_save = 'uploads/settings/image/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['debug'] = $request->debug == 'true' ? true : false;
        if($request->file()){
            if (!empty(config('app.logo'))) {
                unlink(config('app.logo'));
            }

            if (!empty(config('app.logoText'))) {
                unlink(config('app.logoText'));
            }
            $slug      = slugCustom('setting');
            $file      = $request->file() ?? [];
            $path      = $this->path_file_save;
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $uploads = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file);

            foreach ($uploads as $key => $value) {
                $data[$key] = $value;
            }

        }

        unset($data['_token']);
        $json = json_encode($data, JSON_PRETTY_PRINT);
        
        if(!file_exists(base_path().'/settings/setting.json')){
            mkdir(base_path().'/settings/');
        }
        file_put_contents(base_path().'/settings/setting.json', stripslashes($json));
        FacadesArtisan::call('config:cache');
        
        sleep(5);
        return back()->with('success', 'Setting Berubah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

    }

}
