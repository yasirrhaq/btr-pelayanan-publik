@extends('frontend.layouts.mainNew')
@section('customCss')
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{ url('css/frontend/berita.css')}}">
@endsection
@section('container')
    <!-- <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">{{ $post->title }}</h1>

                {{-- <h5>By: {{ $post['author'] }}</h5> --}}

                <p>By. Yasir Haq in <a href="{{url('')}}/berita?category={{ $post->category->slug }}" class="text-decoration-none">
                        {{ $post->category->name }}</a></p>
                {{-- <img src="{{ $post['image'] }}" alt="{{ $post['image'] }}" width="200"> --}}

                @if ($post->image)
                    <img src="{{  asset(  $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" class="card-img-top"
                        alt="{{ $post->category->name }}" class="img-fluid">
                @endif


                {{-- <p>{{ $post->body }}</p> --}}
                {{-- ini kalo mau pakai ada tag htmlnya --}}

                <article class="my-3 fs-5">
                    {!! $post->body !!}
                </article>

                <a href="{{url('')}}/berita" class="text-decoration-none">Back to berita</a>
            </div>
        </div>
    </div> -->
    <!-- yang bisa -->
    <!-- <main>
        <div class="container mt-5 container-berita">
                <div class="row">
                    <div class="col-9 d-flex justify-content-center">
                        <div class="card" style="width: 80%;box-shadow: 0px 0px 2px rgb(0,0,0, 0.3),0px 0px 2px rgb(0,0,0,0.3),0px 0px 2px rgb(0,0,0,0.3);">
							@if ($post->image)
								<div class="ratio ratio-16x9">
									<img src="{{  asset( $post->image) }}" class="card-img-top" alt="...">
								</div>
								@else
								<div class="ratio ratio-16x9">
									<img src="https://source.unsplash.com/random/?{{ $post->category->name }}" class="card-img-top" alt="...">
								</div>
								@endif
                            <div class="card-body">
                              <h5 class="card-title mb-5">{{ $post->title }}</h5>
                              <article class="card-text mb-3">
                                {!! $post->body !!}
                               </article>
                        	</div>
							<a href="{{url('')}}/berita" class="text-decoration-none mb-2" style="color:black">Back to berita</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </main> -->
    <section class="whats-news-area pt-50 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                        <div class="card" style="width: 80%;box-shadow: 0px 0px 2px rgb(0,0,0, 0.3),0px 0px 2px rgb(0,0,0,0.3),0px 0px 2px rgb(0,0,0,0.3);">
                            @if ($post->image)
                                <div class="">
                                    <img src="{{   asset( $post->image)  }}" class="img-fluid w-100 h-30">
                                </div>
								@else
                                <div class="">
                                    <img src="https://source.unsplash.com/random/?{{ $post->category->name }}" class="img-fluid w-100 h-30">
                                </div>
								@endif
                            <div class="card-body">
                              <h5 class="card-title mb-5">{{ $post->title }}</h5>
                              <article class="card-text mb-3">
                                {!! $post->body !!}
                               </article>
                        	</div>
							<a href="{{url('')}}/berita" class="text-decoration-none mb-2 ml-3" style="color:black">Back to berita</a>
                      </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget popular_post_widget">
                                    <h3 class="widget_title">Berita Terkini</h3>
                                    @foreach ($terkini->take(2) as $post)
                                        <div class="media post_item">
                                            @if($post->image)
                                                <img src="{{  asset( $post->image) }}" alt="post" style="max-height: 80px; max-width: 80px;">
                                            @else
                                                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" alt="post" style="max-height: 80px; max-width: 80px;">
                                            @endif
                                            <div class="media-body">
                                                <a href="{{ url('berita', ['slug' => $post->slug]) }}">
                                                    <h3>{{ $post->title }}</h3>
                                                </a>
                                                <p>{{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
</br>
</br>
@endsection
