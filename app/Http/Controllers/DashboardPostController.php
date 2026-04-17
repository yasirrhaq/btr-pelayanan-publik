<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    protected $redirect_path = '/dashboard/posts';
    protected $path_file_save = 'berita';

    protected function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $absolute = public_path(ltrim(str_replace('\\', '/', $path), '/'));

        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index', ['posts' => Post::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', ['categories' => Category::all()]);
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
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required'
        ]);


        if ($request->file('image')) {

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

            $validatedData['image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['image'];

        }
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100, '...');

        Post::create($validatedData);
        return redirect($this->redirect_path)->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required',
            'remove_image' => 'nullable|boolean',
        ];
        if ($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);
        $post = Post::where('id', $post->id)->first();

        if ($request->boolean('remove_image')) {
            $this->deleteImage($post->image);
            $validatedData['image'] = null;
        }

        if ($request->file('image')) {
            $this->deleteImage($post->image);

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

            $validatedData['image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['image'];
        }

        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 100, '...');

        $post= $post
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Berita berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->deleteImage($post->image);
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success', 'Berita berhasil dihapus!');
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $file = $request->file('file');
        $filename = 'post-editor-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $dir = public_path('uploads/berita/editor');

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file->move($dir, $filename);

        return response()->json([
            'url' => asset('uploads/berita/editor/' . $filename),
            'message' => 'Upload berhasil',
        ]);
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
