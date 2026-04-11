@foreach ($landing_page as $item)
    <div class="row">
        <div class="col-lg-12">
            <div class="about-right mb-90">
                <div class="mb-30 pt-30 text-center">
                    <h3 class="title-tugas"> {{ $item->title }} </h3>
                    <div class="d-flex justify-content-center">
                        <div class="divider-title-tugas"></div>
                    </div>
                </div>
                <div class="about-prea text-justify">
                    <p>
                        {!! str_replace(['<div>','</div>'],' ',$item->deskripsi) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($item->path))
        <div class="row">
            <div class="col-lg-12">
                <div class="about-right mb-90">
                    <div class="about-img mt-10">
                        <img src="{{ imageExists($item->path) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
