<div class="col-3">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div>
                <div class="input-group mb-3">
                    <input type="search" class="form-control"
                        aria-label="Dollar amount (with dot and two decimal places)">
                    <span class="input-group-text">
                        <ion-icon name="search-sharp"></ion-icon>
                    </span>
                </div>
                <h6 class="card-title" style="font-size:18px;">Berita Terkini</h6>
                <!-- berita -->
                @foreach ($terkini->take(2) as $post)
                    <div class="row mt-4" style="cursor : pointer;">
                        <div class="d-flex">
                            @if ($post->image)
                                <img src="{{  asset(  $post->image) }}" class="foto-list-berita" />
                            @else
                                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}"
                                    class="foto-list-berita" />
                            @endif
                            <div style="margin-left: 10px;">
                                <h6 class="title-list-berita">{{ $post->title }}</h6>
                                <p class="card-text text-responsive"
                                    style="font-size: 12px;font-weight: bold;overflow: hidden;height: 60px;">
                                    {{ substr($post->excerpt, 0, 50) }}...
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <hr style="width: 95%;" />
                        </div>
                    </div>
                @endforeach
                <!-- berita -->
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <hr style="width: 95%;" />
    </div>
</div>
@endforeach
<!-- berita -->
</div>
</div>
</div>
</div>
