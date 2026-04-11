<footer>
       <div class="footer-area fix" style="background-color:#354776;">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-5 col-lg-5 col-md-7 col-sm-12">
                        <div class="single-footer-caption mt-60">
                            <div class="footer-tittle">
                                <h4> {{ config('app.name') }} </h4>
                                <p style="color:white">{{ $footer_setting->nama_kementerian }}</p>
                            </div>
                            <div class="footer-tittle mt-3">
                                <h4>Statistik Pengunjung</h4>
                                <div class="footer-tex-one footer-table text-contact-us" style="justify-content: space-between;">
                        <ul>
                          <p class="text-p" style="color:white">Hari ini</p>
                          <p class="text-p" style="color:white">7 hari terakhir</p>
                          <p class="text-p" style="color:white">30 Hari terakhir</p>
                          <p class="text-p" style="color:white">Sepanjang Waktu</p>
                        </ul>
                        <div>
                          <p class="text-p" style="color:white">1</p>
                          <p class="text-p" style="color:white">4</p>
                          <p class="text-p" style="color:white">19</p>
                          <p class="text-p" style="color:white">36</p>
                        </div>
                    </table>
                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-footer-caption mt-60">
                            <div class="footer-tittle">
                                <h4>Contact Us</h4>
                                <p style="color:white"><i class="fas fa-home me-3" style="color:white"></i>{{ $footer_setting->alamat ?? '' }}</p>
                                <p style="color:white"><i class="fas fa-phone me-3" style="color:white"></i> Phone : {{ $footer_setting->no_hp ?? '' }}</p>
                                <p style="color:white">
                                  <i class="fas fa-envelope me-3" style="color:white"></i>
                                  Email : {{ $footer_setting->email ?? ''}}
                                </p>
                                <div class="footer-form" >
                                    <div id="mc_embed_signup">
                                        <div class="footer-social mt-3">
                                            <a href="{{ $sosmed->find(11)->url ?? '#'}}">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                            <a href="{{ $sosmed->find(12)->url ?? '#'}}">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                            <a href="{{ $sosmed->find(13)->url ?? '#'}}">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6">
                        <div class="single-footer-caption mb-50 mt-60">
                            <div class="footer-tittle">
                                <h4>Lokasi</h4>
                            </div>
                            <div class="mapouter">
                      <div class="gmap_canvas">
                        <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=balai%20teknik%20rawa&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <a href="https://putlocker-is.org"></a><br><style>.mapouter{position:relative;text-align:right;height:302.84px;width:205px;}</style>
                        <a href="https://www.embedgooglemap.net">google map embed generator</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:205px;width:302.84px;}</style>
                      </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="footer-bottom-area">
           <div class="container">
               <div class="footer-border">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-lg-6">
                            <div class="footer-copy-right">
                                <p>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> Balai Teknik Rawa. All Right Reserved
                                    <a href="https://colorlib.com" target="_blank" style="color:green" class="copyright">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
   </footer>
