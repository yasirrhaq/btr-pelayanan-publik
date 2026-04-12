@extends('frontend.layouts.main')

@section('container')
    <section class="bg-gray-50 border-b border-gray-200 py-10 px-4">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-[#354776]">Berita {{ config('app.name') }}</h1>
            <div class="w-16 h-1 bg-amber-400 mt-2 rounded-full"></div>
        </div>
    </section>

    <section class="py-10 px-4">
        <div class="max-w-6xl mx-auto">
            @if ($posts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow flex flex-col">
                            <div class="aspect-video overflow-hidden bg-gray-100">
                                @if ($post->image)
                                    <img src="{{ asset($post->image) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <img src="https://source.unsplash.com/random/?{{ $post->category->name }}" class="w-full h-full object-cover" alt="">
                                @endif
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <h5 class="font-bold text-[#354776] text-base mb-2 line-clamp-2">{{ $post->title }}</h5>
                                <p class="text-gray-600 text-sm flex-1">{{ $post->excerpt }}</p>
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                                    <small class="text-gray-400 text-xs">{{ $post->updated_at }}</small>
                                    <a href="{{ url('berita', ['slug' => $post->slug]) }}" class="text-xs font-semibold bg-amber-400 hover:bg-amber-300 text-[#354776] px-3 py-1.5 rounded transition-colors">Baca</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center mt-8">{{ $posts->links() }}</div>
            @else
                <p class="text-center text-gray-500">Belum ada berita.</p>
            @endif
        </div>
    </section>
@endsection
