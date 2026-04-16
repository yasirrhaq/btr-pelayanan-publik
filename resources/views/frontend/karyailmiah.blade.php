@extends('frontend.layouts.mainTailwind')

@section('customCss')
<link rel="stylesheet" href="{{ url('css/responsive/karya.css')}}">
<link rel="stylesheet" href="{{ url('css/frontend/karyailmiah.css')}}">
@endsection

@section('container')
<section>
<div class="container mb-5 mt-5">
            <div>
                <h3 class="title-tugas">Karya Ilmiah</h3>
                <div class="d-flex justify-content-center">
                    <div class="divider-title-tugas"></div>
                </div>
            </div>
            <div style="margin-top:80px;">
                <!-- <input type="search" placeholder="Judul Pengarang" class="input-search"/>
                <span class="position-search">  
                <ion-icon name="search-outline" style="width: 16px; height : 16px;"></ion-icon>
                </span> -->

                <form action="{{url('')}}/karya-ilmiah">
                    <div class="input-group mb-3">
                        <input type="text" class="input-search" placeholder="Cari Judul" name="search"
                            value={{ request('search') }}>
                        <!-- <button type="submit"> <i class="fas fa-search"></i></button> -->
                    </div>
                </form>
            </div>
            @if($karyaIlmiah->count())
              @foreach($karyaIlmiah as $karya)
              <div class="card" style="width: 100%;">
                  <div class="card-body">
                      <div class="d-flex mt-3">
                          <img src="../../assets/docs.png" style="width: 31px; height: 31px;"/>
                          <div class="des">
                          <a class="stretched-link" href="{{ url('karya-ilmiah-detail', ['slug' => $karya->slug]) }}">
                              <h3 class="card-title title-docs">
                                  {{$karya -> title}} 
                              </h3>
                          </a>  
                              <p class="address-docs">
                                  {{$karya -> penerbit}} 
                              </p>
                          </div>
                      </div>
                  </div>
                  <!-- <div class="card-footer text-muted">
                      2 days ago
                  </div> -->
              </div>
              @endforeach
            @else
              <p class="text-center fs-4">Tidak ada Karya Ilmiah di Temukan</p>
            @endif
        </div>
        <div class="d-flex justify-content-center mb-4">
          {{ $karyaIlmiah->links() }}
      </div>
</section>
   @endsection

   @section('customJs')
   <script>
    $(document).ready(function(){
        var multipleCardCarousel = document.querySelector(
  "#carouselExampleControls"
);
if (window.matchMedia("(min-width: 768px)").matches) {
  var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: false,
  });
  var carouselWidth = $(".carousel-inner")[0].scrollWidth;
  var cardWidth = $(".carousel-item").width();
  var scrollPosition = 0;
  $("#carouselExampleControls .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
      scrollPosition += cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
  $("#carouselExampleControls .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
} else {
  $(multipleCardCarousel).addClass("slide");
}
 });
   </script>
   @endsection
