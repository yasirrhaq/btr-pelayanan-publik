<nav class="navbar navbar-expand-lg " id="header-nav">
    <div class="container-fluid nav-ul">
    <a class="navbar-brand d-flex" href="#">
        <img class="image-header-logo"  src="assets/logo.png"/>
        <img src="assets/logoText.png" class="logo-text"/>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse nav-ul" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto " id="color-text-primary">
                <li class="nav-item">
                    <a class="nav-link navbar-item " aria-current="page" href="{{asset('/')}}">Home</a>
                </li>
                <li class="nav-item dropdown dropdowns dropdown-6">
                    <a class="nav-link navbar-item" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Profil <ion-icon class="nav-icon" name="caret-down-outline"></ion-icon>
                    </a>
                    <ul class="dropdown-menu dropdown_menus dropdown_menu--animated dropdown_menu-6 ">
                        <li><a class="dropdown-item" href="../pages/visimisi/visimisi.html">Visi dan Misi</a></li>
                        <li><a class="dropdown-item" href="../pages/sejarah/sejarah.html">Sejarah</a></li>
                        <li><a class="dropdown-item" href="../pages/Tugas/tugas.html">Tugas dan Fungsi</a></li>
                        <li><a class="dropdown-item" href="../pages/struktur/struktur-organisasi.html">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item" href="../pages/informasipenjabat/informasi-penjabat.html">Informasi Pejabat</a></li>
                        <li><a class="dropdown-item" href="../pages/fasilitas/fasilitas.html">Fasilitas Balai</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdowns dropdown-6">
                    <a class="nav-link  navbar-item" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Layanan <ion-icon class="nav-icon" name="caret-down-outline"></ion-icon>
                    </a>
                    <ul class="dropdown-menu menu dropdown_menus dropdown_menu--animated dropdown_menu-6 ">
                    <li id="advis" class="drop dropdown-8">
                        <div class="d-flex justify-content-between">
                        <a class="dropdown-item" href="#">
                        Advis Teknis
                        </a>
                        <span style="width: 13px;height: 13px;color: #364878;margin-right: 20px;margin-top: 5px;">></span>
                    </div>
                        <ul class="dropdown-menu drop drop_menu drop_menu--animated dropdown_menu-8"
                        style="height: 100px;left: 300px;" >
                        <li><a class="dropdown-item li-nav" href="../pages/advis/advis.html">Tentang Advis Teknis</a></li>
                        <li><a class="dropdown-item li-nav" href="../pages/advis/permohonanAdvis.html">Permohonan Advis Teknis</a></li>
                        </ul>
                    </li>
                    <li class="drop dropdown-8">
                        <div class="d-flex justify-content-between">
                        <a class="dropdown-item" href="#">Pengujian Laboratorium</a>
                        <span style="width: 13px;height: 13px;color: #364878;margin-right: 20px;margin-top: 5px;">></span>
                    </div>
                        <ul class="dropdown-menu drop drop_menu drop_menu--animated dropdown_menu-8"  style="width: 350px;height : 100px;left: 300px;top : 30px;">
                        <li><a class="dropdown-item" href="../pages/pengujianLaboratorium/Pengujian.html">Tentang Pengujian Laboratorium</a></li>
                        <li><a class="dropdown-item" href="../pages/inputLayanan/LayananPengujian.html">Permohonan Pengujuan Laboratorium</a></li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item" href="#"
                        >Permohonan Data</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdowns dropdown-6">
                    <a class="nav-link  navbar-item" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Repository <ion-icon class="nav-icon" name="caret-down-outline"></ion-icon>
                    </a>
                    <ul class="dropdown-menu dropdown_menus dropdown_menu--animated dropdown_menu-6 ">
                        <li class="drop dropdown-8">
                            <div class="d-flex justify-content-between">
                                <a class="dropdown-item" href="#">e-Perpustakaan</a>
                                <span style="width: 13px;height: 13px;color: #364878;margin-right: 10px;margin-top: 5px;">></span>
                            </div>
                            <ul class="dropdown-menu drop drop_menu drop_menu--animated dropdown_menu-8"  style="width: 350px;height : 100px;left: 230px;">
                                <li><a class="dropdown-item" href="../pages/advis/advis.html">Katalog e-Perpustakaan</a></li>
                                <li><a class="dropdown-item" href="#">Layanan Perpustakaan</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="../karyailmiah/karyailmiah.html">Karya Ilmiah</a></li>
                        <li><a class="dropdown-item" href="#">Rencana Strategi</a></li>
                        <li><a class="dropdown-item" href="#">JDIH PU</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdowns dropdown-6">
                    <a class="nav-link navbar-item" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Informasi Publik <ion-icon class="nav-icon" name="caret-down-outline"></ion-icon>
                    </a>
                    <ul class="dropdown-menu dropdown_menus dropdown_menu--animated dropdown_menu-6 ">
                        <li><a class="dropdown-item" href="#">e-PPID</a></li>
                        <li><a class="dropdown-item" href="#">Whistleblowing system</a></li>
                        <li><a class="dropdown-item" href="#">Pengaduan Masyarakat</a></li>
                        <li><a class="dropdown-item" href="#">Gratifikasi</a></li>
                        <li><a class="dropdown-item" href="#">Survey Kepuasan Pelanggan</a></li>
                        <li><a class="dropdown-item" href="#">Hasil Survey Kepuasan Pelanggan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdowns dropdown-6">
                    <a class="nav-link navbar-item" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Publikasi
                    <ion-icon class="nav-icon" name="caret-down-outline"></ion-icon>
                    </a>
                    <ul class="dropdown-menu dropdown_menus dropdown_menu--animated dropdown_menu-6 ">
                        <li class="drop dropdown-8"><a class="dropdown-item" href="#">
                            Berita</a>
                            <ul class="dropdown-menu drop drop_menu drop_menu--animated dropdown_menu-8"  style="width: 350px;height : 100px;right: 158px;">
                                <li><a class="dropdown-item" href="https://pu.go.id/berita/kanal">Berita Kementerian PU</a></li>
                                <li><a class="dropdown-item" href="https://sda.pu.go.id/berita/index/sda">Berita SDA</a></li>
                                <li><a class="dropdown-item" href="../berita/beritaAwal.html">Berita {{ config('app.name') }}</a></li>
                            </ul>
                        </li>
                        <li class="drop dropdown-8"><a class="dropdown-item" href="#">
                            Galeri</a>
                            <ul class="dropdown-menu drop drop_menu drop_menu--animated dropdown_menu-8"  style="width: 200px;height : 80px;right: 158px;">
                                <li><a class="dropdown-item" href="../pages/galeri/foto.html">Foto</a></li>
                                <li><a class="dropdown-item" href="../pages/galeri/vidio.html">Video</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="button-div">
                <a type="button" href="./../login.html"  class="btn btn-primary" id="button-login">Login</a>
            </div>
        </div>
    </div>
</nav>
