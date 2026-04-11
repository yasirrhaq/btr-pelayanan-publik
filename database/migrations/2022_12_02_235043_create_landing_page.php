<?php

use App\Models\LandingPage;
use App\Models\LandingPageTipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_tipe', function (Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $map_data = [
            'Visi',
            'Misi',
            'Sejarah',
            'Tugas',
            'Fungsi',
        ];

        foreach ($map_data as $key => $value) {
            $landing_page_tipe = new LandingPageTipe;
            $landing_page_tipe->title = $value;
            $landing_page_tipe->save();
        }

        Schema::create('landing_page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200)->nullable();
            $table->unsignedBigInteger('landing_page_tipe_id')->nullable();
            $table->longText('deskripsi');
            $table->string('path')->nullable()->comment('digunakan untuk simpan gambarnya');
            $table->integer('status')->comment('1 = Active, 0 = In Active ')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('landing_page_tipe_id')->references('id')->on('landing_page_tipe');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });

        $map_landing_page = [
            [
                'title' => 'Visi',
                'landing_page_tipe_id' => 1, #diambil sesuai urutan landing page tipe di atas
                'path' => null,
                'deskripsi' => 'Terwujudnya Balai Teknik Rawa sebagai unggulan pelayanan teknis bidang rawa dengan melaksanakan pengembangan, perekayasaan, pengkajian  pengujian, inspeksi, dan sertifikasi bidang rawa',
            ],
            [
                'title' => 'Misi',
                'landing_page_tipe_id' => 2, #diambil sesuai urutan landing page tipe di atas
                'path' => null,
                'deskripsi' => '
                    <p>1.	Melaksanakan pelayanan teknis pengujian dan pengkajian bidang rawa sesuai kebutuhan stakeholder dengan pelayanan prima.</p>
                    <p>2.	Meningkatkan kualitas Sumber Daya Manusia yang profesional bidang rawa.</p>
                    <p>3.	Melaksanakan pengembangan dan perekayasaan bidang rawa untuk menghasilkan layanan teknologi.</p>
                    <p>4.	Mewujudkan lembaga terakreditasi yang mendapatkan pengakuan nasional dan internasional secara berkelanjutan</p>
                    <p>5.	Mewujudkan Pelayanan inspeksi/ sertifikasi untuk kinerja Jaringan Irigasi Rawa untuk menjamin keandalan fungsi dan operasi infrastruktur rawa.</p>
                ',
            ],
            [
                'title' => 'Sejarah',
                'landing_page_tipe_id' => 3, #diambil sesuai urutan landing page tipe di atas
                'path' => 'assets/sejarah pupr.png',
                'deskripsi' => '
                    Sesuai dengan Peraturan Menteri Pekerjaan Umum dan Perumahan Rakyat Nomor 16 Tahun 2020 tentang Organisasi dan Tata Kerja Unit Pelaksana Teknis di Kementerian Pekerjaan Umum dan Perumahan Rakyat, dalam pasal 47, Balai Teknik Rawa adalah unit pelaksana teknis yang berada di bawah dan bertanggung jawab kepada Direktur Jenderal Sumber Daya Air melalui Direktur Irigasi dan Rawa. Balai Teknik Rawa mempunyai tugas melaksanakan pengembangan, perekayasaan, dan pelaksanaan pelayanan teknis pengujian, pengkajian, inspeksi, dan sertifikasi di bidang rawa. Balai Teknik Rawa berkedudukan di Kota Banjarmasin, Provinsi Kalimantan Selatan dan memiliki wilayah kerja di seluruh Indonesia.
                ',
            ],
            [
                'title' => 'Tugas',
                'landing_page_tipe_id' => 4, #diambil sesuai urutan landing page tipe di atas
                'path' => null,
                'deskripsi' => '
                    <div>Balai Teknik Rawa telah melalui perjalanan yang cukup panjang yang dimulai pada tanggal 20 April 2007 terbentuk Balai Rawa yang berkedudukan di Banjarmasin sesuai dengan Peraturan Menteri Pekerjaan Umum Nomor 08/PRT/M/2007 tentang Organisasi dan Tata Kerja Unit Pelaksana Teknis Departemen Pekerjaan Umum. Balai Rawa merupakan Unit Pelaksana Teknis yang berada di bawah Pusat Penelitian dan Pengembangan Sumber Daya Air yang belokasi di Bandung dengan Eselon-I nya yaitu Badan Penelitian dan Pengembangan. Badan Penelitian dan Pengembangan. Pada tahun 2010 terdapat perubahan nomenklatur Departemen Pekerjaan Umum menjadi Kementerian Pekerjaan Umum melalui Peraturan Menteri Pekerjaan Umum No. 21/PRT/M/2010. Kemudian pada tahun 2015 terjadi perubahan struktur organisasi dan perubahan nomenklatur melalui Peraturan Menteri PUPR No 34 Tahun 2015 Tentang Organisasi dan Tata Kerja Unit Pelaksana Teknis Kementerian PUPR Balai Rawa berganti nomenklatur menjadi Balai Litbang Teknologi Rawa. Tidak berselang lama dengan terbitnya Peraturan Menteri Pekerjaan Umum dan Perumahan Rakyat Nomor 20/PRT/M/2016, terjadi perubahan nomenklatur kembali dari Balai Litbang Teknologi Rawa menjadi Balai Penelitian Dan Pengembangan Rawa dengan tugas melaksanakan Penelitian dan Pengembangan Bidang Rawa dengan wilayah kerja seluruh Indonesia.<br><br>Pada tahun 2020 terjadi reorganisasi di Kementerian PUPR dimana Badan Penelitian dan Pengembangan dibubarkan sehingga Balai Litbang Rawa berganti nomenklatur menjadi Balai Teknik Rawa dibawah Direktorat Jenderal Sumber Daya Air sesuai Peraturan Menteri Pekerjaan Umum dan Perumahan Rakyat Nomor 16/PRT/M/2020 No 16 Tahun 2020 Tanggal 02 Juni 2020 Tentang Organisasi Dan Tata Kerja Unit Pelaksana Teknis di Kementerian Pekerjaan Umum Dan Perumahan Rakyat. Balai Teknik Rawa mempunyai tugas melaksanakan pengembangan, perekayasaan, dan pelaksanaan pelayanan teknis pengujian, pengkajian, inspeksi, dan sertifikasi di bidang rawa. Dengan wilayah kerja Seluruh Indonesia.</div>
                ',
            ],
            [
                'title' => 'Fungsi',
                'landing_page_tipe_id' => 5, #diambil sesuai urutan landing page tipe di atas
                'path' => null,
                'deskripsi' => '
                    <div>Dalam melaksanakan tugasnya, Balai Teknik Rawa menyelenggarakan fungsi sebagaimana yang tertuang dalam pasal 49, meliputi:<br>A. Penyusunan Rencana, Program, Dan Anggaran,<br>B. Pelaksanaan Pengembangan Dan Perekayasaan,<br>C. Pelaksanaan Diseminasi,<br>D. Pelaksanaan Pelayanan Teknis Meliputi Pengujian,<br>E. Pengkajian, Inspeksi, Dan Sertifikasi,&nbsp;<br>F. Fasilitasi Pelaksanaan Alih Teknologi,&nbsp;<br>G. Penyiapan Dan Pengelolaan Data,&nbsp;<br>H. Pengelolaan Laboratorium,&nbsp;<br>I. Pelaksanaan Pemantauan, Evaluasi, Dan Pelaporan; Dan&nbsp;<br>J. Pelaksanaan Urusan Tata Usaha Dan Rumah Tangga Balai.&nbsp;<br>Untuk melaksanakan Fungsi tersebut Balai Teknik Rawa didukung oleh dua unsur organisasi yang terdiri dari Subbagian Umum dan Tata Usaha serta Kelompok Jabatan Fungsional. Pasal 51 menyebutkan bahwa tugas Subbagian Umum dan Tata Usaha mempunyai tugas melakukan penyusunan program dan anggaran, pengelolaan kepegawaian, keuangan, tata persuratan dan tata kearsipan, serta perlengkapan, pengelolaan barang milik negara, pengelolaan penerimaan negara bukan pajak, penyiapan basis data, evaluasi dan pelaporan, urusan rumah tangga, serta koordinasi administrasi penerapan sistem pengendalian intern balai.&nbsp;</div>
                ',
            ],
        ];

        LandingPage::insert($map_landing_page);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_page_tipe');
        Schema::dropIfExists('landing_page');
    }
}
