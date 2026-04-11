<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('berita.index', [
            "title" => "Daftar Berita",
            "active" => 'posts',
            'categori' => $category,
            "terkini" => Post::latest()->take(2)->get()
        ]);
    }

    public function ajaxListBerita(Request $request){
        try {
            $search = $request->search;
            $category_id = $request->categori_id;
            $jumlah_berita = Post::count('id');
            $berita = Post::where(function($q) use ($search){
                $q->where('title', 'like', "%$search%")
                ->orWhere('body', 'like', "%$search%");

            })
            ->selectRaw('
                id,
                category_id,
                title,
                slug,
                image,
                body,
                created_at
            ')
            ->orderBy('created_at', 'desc');

            if (!empty($category_id)) {
                $berita = $berita->whereHas('category', function ($q) use ($category_id) {
                    $q->where('id', $category_id);
                });
            }

            $berita = $berita->get()
            ->map(function($q){
                $q->attr_body_limit = $q->attr_body_limit;
                return collect($q);
            });

            $result = [
                'data' => $berita,
                'total_page' => $jumlah_berita,
                'show_page' => 2
            ];
            return $this->successJson($result);

        } catch (\Throwable $th) {
            return $this->exceptionJson($th);
        }
    }

    public function show(Post $post)
    {
        return view('frontend.beritaDetail', [
            "title" => "Detail Post",
            "active" => 'posts',
            "post" => $post,
            "terkini" => Post::latest()->filter(request(['search', 'category']))->paginate(7)->withQueryString()
        ]);
    }
}
