@extends('frontend.layouts.mainNew')

@section('customCss')
    <link rel="stylesheet" href="{{ url('css/frontend/berita.css')}}">
@endsection
@section('container')
    <section class="whats-news-area pt-50 pb-20">
        <div class="container">
            <div class="row justify-content-center mb-3">
                <div class="col-md-6">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="whats-news-caption">
                                        <div class="row content-berita">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Berita Terkini</h3>
                            <form class="frm-search-berita">

                                <div class="input-group mb-3">

                                    <select class="form-control" name="categori_id" style="width: 100% !important;">
                                        <option value="" selected>Semua</option>
                                        @foreach ($categori as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search.." name="search">
                                    <button type="button" class="btn-search-berita"> <i class="fas fa-search"></i></button>
                                </div>
                            </form>
                            <hr>
                            @foreach ($terkini as $post)
                                <div class="media post_item">
                                    @if ($post->image)
                                        <img src="{{ asset($post->image) }}" alt="post"
                                            style="max-height: 80px; max-width: 80px;">
                                    @else
                                        <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}"
                                            alt="post" style="max-height: 80px; max-width: 80px;">
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

    <div class="d-flex justify-content-center mb-2 btn-paginate">
    </div>

@endsection

@push('js')
    <link rel="stylesheet" href="https://pagination.js.org/dist/2.1.5/pagination.css">

    <script src="{{ asset('js/pagination.js') }}"></script>
    <script>
        function template(data){
            var html = `Tidak ada berita`;
            if(data.length > 0){
                html = '';
                $.each(data, function (key, value) {
                    var gambar='';
                    if(value.image === null){
                        gambar = "img/logo pupr.png"
                    }else{
                        gambar=value.image
                    }
                    html += `
                        <div class="col-lg-6 col-md-6">
                            <div class="single-what-news mb-100">
                                <div class="what-img ratio ratio-16x9">
                                    <img class="beritaThumb" <img src="{{ asset('') }}/${gambar}" alt="">
                                </div>
                                <div class="what-cap">
                                    <span class="color1">
                                        ${value?.category?.name}
                                    </span>
                                    <h4>
                                        <a href="${BASE_URL}/berita/${value?.slug}">
                                            ${value?.title}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    `
                });
            }

            return html;
        }

        function paginateBerita(){
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/ajax-search-berita`,
                data: $('.frm-search-berita').serialize(),
                dataType: "json",
                success: function (response) {
                    $('.btn-paginate').pagination({
                        dataSource : (response),
                        locator: 'data',
                        totalNumber: response.total_page,
                        pageSize: response.show_paage,
                        callback: function(data, pagination) {
                            var html = template(data);
                            $('.content-berita').html(html);
                        }
                    })
                },
                error: function(){
                    alert('Terjadi Kesalahan Server');
                }
            });
        }

        $(document).on('click', '.btn-search-berita', function(){
            $('.content-berita').html('Sedang Memuat Data ...');
            paginateBerita();
        })

        $('.btn-search-berita').trigger('click');

        $('form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                $('.btn-search-berita').trigger('click');
                return false;
            }
        });
    </script>
@endpush
