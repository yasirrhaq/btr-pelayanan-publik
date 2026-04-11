<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita BTR</title>
    <link rel="icon" href="assets/logo.png" type="image/icon type">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/index.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/BeitaAwal.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/navbar.css') }}">
  </head>
  <body>
    <!-- navbar top-->
    <div class="header-main">
        <p class="time"></p>
        <div class="d-flex">
        <div style="margin-right : 13px;margin-top : 3px;">
          <a href="https://www.instagram.com/pupr_sda_baltekrawa/" target="blank" class="link-icon">
          <ion-icon name="logo-instagram" style="width:11px;height :11px;margin-right : 5px;"></ion-icon>
          </a>
          <a href="https://www.facebook.com/people/Balai-Teknik-Rawa/100066235135162/" target="blank" class="link-icon">
          <ion-icon name="logo-facebook" style="width:11px;height :11px;margin-right : 5px;"></ion-icon>
        </a>
        <a href="https://www.youtube.com/channel/UCoC8oCFvMLXI0PtEcBp3Plw" target="blank" class="link-icon">
          <ion-icon name="logo-youtube" style="width:11px;height :11px;margin-right : 5px;"></ion-icon>
        </a>
        </div>
          <div class="dropdown">
            <a class="dropdown-toggle link-subtitle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Indonesia
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">English</a></li>
            </ul>
          </div>
        </div>
    </div>
        @include('frontend.partials.navbar')
        <div class="header-berita">
        <div class="cover-color">
        <div class="header-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between content-header-berita">
                    <h1 class="header-title-berita">
                      Berita {{ config('app.name') }}
                    </h1>
                    <h4>
                      <span style="color:blue">Beranda</span><span style="color:white;">/ Berita BTR</span>
                    </h4>
                </div>
            </div>
        </div>
      </div>
      </div>
      <div class="container mt-5 container-berita">
        	@yield('beritaHeader')
        <div class="row" style="margin-top: 100px;">
          	@yield('container')
			  @include('frontend.beritaTerkini')

        </div>
        @include('frontend.partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="js/frontend/nav.js"></script>
    <script>
       const time =  document.querySelector(".time");
       const d = new Date(Date.now());
       let month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober","November", "Desember"];
       let tanggal = d.getDate();
       let bulan = d.getMonth();
       let jam = d.getHours() < 10 ? '0' + d.getHours() : d.getHours();
       let menit = d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes();
       let detik = d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds();
       time.textContent = `${tanggal} ${month[bulan]} ${d.getFullYear()} | ${jam}:${menit}:${detik} WITA`
    </script>
</body>
</html>
