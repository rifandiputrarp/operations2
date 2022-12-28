<html>

<head>
    <style>
        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
            font-family: "Arial Narrow", Arial, sans-serif;
            font-size: 10pt;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 90.24px;
            margin-left: 94.08px;
            margin-right: 73.92px;
            margin-bottom: 53.76px;
            font-family: "Arial Narrow", Arial, sans-serif;
            font-size: 10pt;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0px;
            left: 94.08px;
            right: 73.92px;
            height: 90.24px;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 94.08px;
            right: 73.92px;
            height: 53.76px;
        }

        footer .pagenum:before {
            content: counter(page);
        }

        .page_break {
            page-break-before: always;
        }

        .head {
            text-align: center;
        }

        .table1 th {
            border: 1px solid black;
            padding: 5px;
        }

        .table1 td {
            border: 1px solid black;
            padding: 10px;
        }

        .table1 {
            width: 100%;
            border-collapse: collapse;
        }

        .table2 td {
            padding: 2px;
            vertical-align: top;
        }

        .table3 {
            border: 1px solid black;
            width: 100%;
        }

        .table3 td {
            vertical-align: top;
        }

        .space {
            margin-top: 20px;
        }

        .dspace {
            margin-top: 40px;
        }

        .tspace {
            margin-top: 80px;
        }

        p {
            line-height: 1.6;
            text-align: justify;
        }

        .table4 th {
            border: 1px solid black;
            padding: 3px;
        }

        .table4 td {
            border: 1px solid black;
            padding: 3px;
        }

        .table4 {
            width: 100%;
            border-collapse: collapse;
        }

        .table5 th {
            border: 1px solid black;
            padding: 1px;
            vertical-align: middle;
        }

        .table5 td {
            border: 1px solid black;
            padding: 1px;
            vertical-align: middle;
        }

        .table5 {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>



<body>
    <header>
        <table style="width:100%">
            <tr>
                @if($oc[0]->berbayar != 1)
                <td style="padding-top:20px">
                    <img src="{{public_path('/img/logoKemenperin.png')}}" style="width:140px;">
                </td>
                @else
                <td style="padding-top:20px">
                    <img src="{{public_path('/img/logoKemenperin.png')}}" style="width:140px;visibility: hidden;">
                </td>
                @endif
                <td style="padding-top:15px">
                    <img src="{{public_path('/img/logosci.png')}}" style="width:70px;float: right;">
                </td>
            </tr>
        </table>
        <hr>
    </header>

    <footer>
        <hr>
        <table style="width: 100%;font-size:9pt;">
            <tr>
                <td width="70%">
                    <i>Laporan Verifikasi Tingkat Komponen Dalam Negeri (TKDN)</i>
                </td>
                <td width="30%" style="text-align: right;">
                    <i>
                        <div class="pagenum-container">Hal. <span class="pagenum"></span></div>
                    </i>
                </td>
            </tr>
        </table>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <p style="font-weight: bold;text-align:center"> RINGKASAN EKSEKUTIF</p>

        <div class="dspace"> </div>

        <p>
            {{$profil[0]->nama_perusahaan}} merupakan Perusahaan Modal dengan komposisi {{$profil[0]->saham_negeri}}% dimiliki oleh Warga Negara Indonesia dan {{$profil[0]->saham_luar_negeri}}% dimiliki oleh Warga Negara Asing,
            dengan Akta Pendirian no. {{$profil[0]->akta_pendirian}} tanggal {{changeFormat($profil[0]->tanggal_akta)}} oleh Notaris {{$profil[0]->notaris}}
            @if($profil[0]->ijin_usaha != "" && $profil[0]->nib != "")
            dan Izin Usaha No. {{$profil[0]->ijin_usaha}} / Nomor Izin Berusaha {{$profil[0]->nib}}
            @elseif($profil[0]->ijin_usaha != "")
            dan Izin Usaha No. {{$profil[0]->ijin_usaha}}
            @elseif($profil[0]->nib != "")
            dan Nomor Izin Berusaha {{$profil[0]->nib}}
            @endif
            yang diterbitkan oleh {{$profil[0]->penerbit_ijin}} pada tanggal {{changeFormat($profil[0]->tanggal_terbit_ijin)}}.
        </p>

        <div class="space"> </div>

        <p>
            Dalam Laporan ini jenis produk yang diverifikasi Tingkat Komponen Dalam Negeri (TKDN) oleh PT. SUCOFINDO (Persero) adalah {{$dataVerif[0]->jenis_produk}}, {{$dataVerif[0]->tipe}}.
        </p>

        <div class="space"> </div>

        <p>
            Adapun hasil verifikasi terhadap produk {{$dataVerif[0]->jenis_produk}}, {{$dataVerif[0]->tipe}}. ditunjukkan oleh Tabel berikut ini :
        </p>

        <table class="table1">
            <thead>
                <tr>
                    <th style="text-align:center;width:10%"> Jenis Produk </th>
                    <th style="text-align:center;width:10%"> Tipe </th>
                    <th style="text-align:center;width:10%"> Nilai TKDN (%) </th>
                    <th style="text-align:center;width:10%"> Komponen Utama (%)</th>
                    <th style="text-align:center;width:10%"> Komponen Pendukung (%)</th>
                    <th style="text-align:center;width:10%"> Perakitan (%)</th>
                    <th style="text-align:center;width:10%"> Pengembangan (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataVerif as $idx => $data)
                <tr>
                    <td>{{$data->jenis_produk}}</td>
                    <td>{{$data->tipe}}</td>
                    <td>{{$data->capaian_tkdn}}</td>
                    <td>{{$data->komponen_utama}}</td>
                    <td>{{$data->komponen_pendukung}}</td>
                    <td>{{$data->perakitan}}</td>
                    <td>{{$data->pengembangan}}</td>
                </tr>
                @endforeach
            </tbody>


        </table>

        <p>
            <b>Bagian Fasilitasi Kandungan Lokal </b>
        </p>

        <div class="tspace"> </div>

        <p>
            <b>
                <u>Ermawan Agus Sudaryanto </u>
            </b>
            <br>
            Kepala Bagian
        </p>


        <table class="table1" style="width:20%;font-size:8px;padding: 0px;">
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding:1px;text-align: center;">JON</td>
                <td style="padding:1px;text-align: center;">{{$etc}}</td>
                <td style="padding:1px;text-align: center;">{{$verifikator1}}</td>
            </tr>
            <tr>
                <td style="padding:1px;text-align: center;">PM</td>
                <td style="padding:1px;text-align: center;">Ver.1</td>
                <td style="padding:1px;text-align: center;">Ver.2</td>
            </tr>

        </table>

        <div class="page_break"></div>


        <p style="font-weight: bold; text-align:center"> PROFIL PERUSAHAAN</p>

        <div class="dspace"> </div>

        <p>
            <b><u>I. PEMEGANG MEREK</u></b>
        </p>

        <table class="table2" style="margin-left:10px">
            <tr>
                <td style="width:250px">a. Nama Perusahaan</td>
                <td style="width:10px">:</td>
                <td>{{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>b. Alamat</td>
                <td>:</td>
                <td>{{@$alamat[0]->alamat}} , {{@$alamat[0]->kelurahan}} , {{@$alamat[0]->kecamatan}} , {{@$alamat[0]->kabupaten}}, {{@$alamat[0]->provinsi}}</td>
            </tr>
            <tr>
                <td>c. Telepon</td>
                <td>:</td>
                <td>{{@$alamat[0]->telepon}}</td>
            </tr>
            <tr>
                <td>d. Fax</td>
                <td>:</td>
                <td>{{@$alamat[0]->fax}}</td>
            </tr>
            <tr>
                <td>e. Email</td>
                <td>:</td>
                <td>{{@$alamat[0]->email}}</td>
            </tr>
            <tr>
                <td>f. Status Perusahaan</td>
                <td>:</td>
                <td>{{$profil[0]->status}}</td>
            </tr>
            <tr>
                <td>g. Pejabat Penghubung</td>
                <td>:</td>
                <td>{{$profil[0]->pejabat}} Jabatan : {{$profil[0]->jabatan}}</td>
            </tr>
            <tr>
                <td>h. Akta Pendirian Perusahaan</td>
                <td>:</td>
                <td>No. {{@$profil[0]->akta_pendirian}} Tanggal {{changeFormat(@$profil[0]->tanggal_akta)}} Nama Notaris {{@$profil[0]->notaris}}</td>
            </tr>
            <tr>
                <td>i. NPWP</td>
                <td>:</td>
                <td>{{$profil[0]->npwp}}</td>
            </tr>
            <tr>
                <td>j. Ijin Usaha (IUT dan/atau SIUP)</td>
                <td>:</td>
                <td>{{$profil[0]->ijin_usaha}}</td>
            </tr>
        </table>

        <div class="dspace"> </div>

        <p>
            <b><u>II. PABRIKAN LOKAL</u></b>
        </p>

        <table class="table2" style="margin-left:10px">
            <tr>
                <td style="width:250px">a. Nama Perusahaan</td>
                <td style="width:10px">:</td>
                <td>{{@$profilLokal[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>b. Alamat</td>
                <td>:</td>
                <td>{{@$alamat_lokal[0]->alamat}} , {{@$alamat_lokal[0]->kelurahan}} , {{@$alamat_lokal[0]->kecamatan}} , {{@$alamat_lokal[0]->kabupaten}}, {{@$alamat_lokal[0]->provinsi}}</td>
            </tr>
            <tr>
                <td>c. Telepon</td>
                <td>:</td>
                <td>{{@$alamat_lokal[0]->telepon}}</td>
            </tr>
            <tr>
                <td>d. Fax</td>
                <td>:</td>
                <td>{{@$alamat_lokal[0]->fax}}</td>
            </tr>
            <tr>
                <td>e. Email</td>
                <td>:</td>
                <td>{{@$alamat_lokal[0]->email}}</td>
            </tr>
            <tr>
                <td>f. Status Perusahaan</td>
                <td>:</td>
                <td>{{@$profilLokal[0]->status}}</td>
            </tr>
            <tr>
                <td>g. Pejabat Penghubung</td>
                <td>:</td>
                <td>{{@$profilLokal[0]->pejabat}} Jabatan : {{@$profilLokal[0]->jabatan}}</td>
            </tr>
            <tr>
                <td>h. Akta Pendirian Perusahaan</td>
                <td>:</td>
                <td>No. {{@$profilLokal[0]->akta_pendirian}} Tanggal {{changeFormat(@$profilLokal[0]->tanggal_akta)}} Nama Notaris {{@$profilLokal[0]->notaris}}</td>
            </tr>
            <tr>
                <td>i. NPWP</td>
                <td>:</td>
                <td>{{@$profilLokal[0]->npwp}}</td>
            </tr>
            <tr>
                <td>j. Ijin Usaha (IUT dan/atau SIUP)</td>
                <td>:</td>
                <td>{{@$profilLokal[0]->ijin_usaha}}</td>
            </tr>
        </table>


        <div class="dspace"> </div>

        <p>
            <b><u>III. PENGEMBANGAN</u></b>
        </p>

        <table class="table2" style="margin-left:10px">
            <tr>
                <td style="width:250px">a. Nama Perusahaan</td>
                <td style="width:10px">:</td>
                <td>{{@$profilPengembang[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>b. Alamat</td>
                <td>:</td>
                <td>{{@$alamat_pengembang[0]->alamat}} , {{@$alamat_pengembang[0]->kelurahan}} , {{@$alamat_pengembang[0]->kecamatan}} , {{@$alamat_pengembang[0]->kabupaten}}, {{@$alamat_pengembang[0]->provinsi}}</td>
            </tr>
            <tr>
                <td>c. Telepon</td>
                <td>:</td>
                <td>{{@$alamat_pengembang[0]->telepon}}</td>
            </tr>
            <tr>
                <td>d. Fax</td>
                <td>:</td>
                <td>{{@$alamat_pengembang[0]->fax}}</td>
            </tr>
            <tr>
                <td>e. Email</td>
                <td>:</td>
                <td>{{@$alamat_pengembang[0]->email}}</td>
            </tr>
            <tr>
                <td>f. Status Perusahaan</td>
                <td>:</td>
                <td>{{@$profilPengembang[0]->status}}</td>
            </tr>
            <tr>
                <td>g. Pejabat Penghubung</td>
                <td>:</td>
                <td>{{@$profilPengembang[0]->pejabat}} Jabatan : {{@$profilPengembang[0]->jabatan}}</td>
            </tr>
            <tr>
                <td>h. Akta Pendirian Perusahaan</td>
                <td>:</td>
                <td>No. {{@$profilPengembang[0]->akta_pendirian}} Tanggal {{changeFormat(@$profilPengembang[0]->tanggal_akta)}} Nama Notaris {{@$profilPengembang[0]->notaris}}</td>
            </tr>
            <tr>
                <td>i. NPWP</td>
                <td>:</td>
                <td>{{@$profilPengembang[0]->npwp}}</td>
            </tr>
            <tr>
                <td>j. Ijin Usaha (IUT dan/atau SIUP)</td>
                <td>:</td>
                <td>{{@$profilPengembang[0]->ijin_usaha}}</td>
            </tr>
        </table>


        <div class="dspace"> </div>


        <p>
            <b><u>IV. DATA PRODUK YANG DIVERIFIKASI</u></b>
        </p>

        @foreach($dataVerif as $idx => $data)
        <br>

        <table class="table1">
            <tbody style="vertical-align: top;">
                <tr>
                    <td colspan="3">
                        <b> Data Produk {{$idx+1}}</b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;border-right-style: none;"> Kelompok Barang / Jasa </td>
                    <td style="width: 3%;border-right-style: none;border-left-style: none;"> : </td>
                    <td style="width: 62%;border-left-style: none;">{{$data->nama_kelompok}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Bidang Usaha / Jenis Industri </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->bidang_usaha}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Jenis Produk </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->jenis_produk}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Tipe </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->tipe}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Spesifikasi </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->spesifikasi}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kode HS </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kode_hs}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Standar </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">-</td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Sertifikat Produk </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">-</td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Merk </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->merk}}</td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kapasitas Produksi Sesuai VKI </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kapasitas_vki}} </td>
                </tr>
            </tbody>
        </table>

        <div class="page_break"></div>

        @endforeach


        <p style="font-weight: bold;text-align:center"> LAPORAN VERIFIKASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</p>

        <div class="dspace"> </div>


        <p style="font-weight: bold;">I. LATAR BELAKANG</p>

        <p style="padding-left: 15px">
            Sesuai dengan Peraturan Menteri Perindustrian Republik Indonesia Nomor 02/M-IND/PER/2/2014 tentang Pedoman Peningkatan Penggunaan Produk Dalam Negeri Dalam Pengadaan Barang/Jasa Pemerintah,
            PT. SUCOFINDO telah melakukan verifikasi TKDN terhadap {{@$profilLokal[0]->nama_perusahaan}} sebagai Pabrikan Lokal
            @if(@$profilLokal[0]->nama_perusahaan == @$profilPengembang[0]->nama_perusahaan)
            dan Pengembang
            @else
            dan {{@$profilPengembang[0]->nama_perusahaan}} sebagai Pengembang
            @endif
            pada tanggal {{changeFormat(@$surtug->tgl_surtug)}}
            @if(@$surtug->tgl_akhir_surtug != "" && @$surtug->tgl_akhir_surtug != @$surtug->tgl_surtug)
            sampai dengan {{changeFormat(@$surtug->tgl_akhir_surtug)}}
            @endif
            .
        </p>

        <div class="space"> </div>

        <p style="font-weight: bold;">II. TUJUAN </p>

        <p style="padding-left: 15px">
            Tujuan dari verifikasi capaian TKDN adalah sebagai berikut:
        </p>
        <ol>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Pemastian penggunaan produk dalam negeri terhadap penyediaan barang/jasa produk Kendaraan Bermotor Listrik Berbasis Baterai.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Mengetahui nilai capaian TKDN produk Kendaraan Bermotor Listrik Berbasis Baterai yang dihasilkan oleh perusahaan.</li>
        </ol>

        <div class="space"> </div>

        <p style="font-weight: bold;"> III. DASAR HUKUM </p>

        <p style="padding-left: 15px;vertical-align: middle">
            {!! $laporan[0]->dasar_hukum !!}
        </p>

        <div class="space"> </div>

        <p style="font-weight: bold;"> IV. METODOLOGI </p>

        <p style="padding-left: 15px;margin-top:0;margin-bottom:0"> a. <i>Desk Study</i></p>
        <p style="padding-left: 35px;margin-top:0;margin-bottom:0"> <i>Desk Study</i> merupakan metode yang dilakukan dengan menggunakan proses pengecekan terhadap literatur maupun dokumen tertulis. Proses yang dilakukan dengan metoda ini dapat dipertanggung jawabkan karena didukung oleh literatur ataupun dokumen tertulis.</p>
        <p style="padding-left: 15px;margin-top:0;margin-bottom:0"> b. Wawancara / <i>Interview</i></p>
        <p style="padding-left: 35px;margin-top:0;margin-bottom:0"> Proses wawancara merupakan proses lanjutan dari <i>Desk Study</i>, dimana wawancara dilakukan secara langsung dengan pihak yang memiliki kompetensi untuk memberikan penjelasan terhadap seluruh kegiatan yang diverifikasi. Dalam kegiatan verifikasi TKDN, proses wawancara menjadi suatu hal yang sangat penting karena dapat digali informasi-informasi yang tidak diperoleh dari dokumen tertulis maupun hasil pengamatan langsung di lapangan.</p>
        <p style="padding-left: 15px;margin-top:0;margin-bottom:0"> c. Verifikasi Lapangan</p>
        <p style="padding-left: 35px;margin-top:0;margin-bottom:0"> Proses verifikasi lapangan merupakan kegiatan kunjungan lapangan untuk melakukan pengamatan langsung di lapangan. Dengan menggunakan metoda ini, proses verifikasi yang sebelumnya hanya berdasarkan literatur dan dokumen tertulis menjadi lebih akurat karena didukung oleh hasil pengamatan langsung di lapangan.</p>
        <p style="padding-left: 15px;margin-top:0;margin-bottom:0"> d. Komparasi</p>
        <p style="padding-left: 35px;margin-top:0;margin-bottom:0"> Proses komparasi adalah metoda membandingkan hasil kegiatan verifikasi dengan referensi yang sudah ada untuk produk sejenis. Dengan menggunakan metoda ini, verifikator memiliki Baganan atau pemahaman yang lebih jelas mengenai objek yang akan diverifikasi. Disamping itu, diperoleh informasi yang lebih lengkap dari objek yang akan diperiksa, sehingga dapat dilakukan proses analisa terhadap hasil yang dilakukan.</p>
        <p style="padding-left: 15px;margin-top:0;margin-bottom:0"> e. Engineering Judgement </p>
        <p style="padding-left: 35px;margin-top:0;margin-bottom:0"> Dalam pelaksanaan kegiatan verifikasi, dimungkinkan terdapat data & dokumen yang kurang memadai untuk diolah menjadi informasi yang dibutuhkan, sehingga diperlukan pendekatan teknis yang dilakukan dengan menggunakan metoda <i>engineering judgement</i>. </p>
        <p style="padding-left: 35px;margin-top:0;margin-bottom:0"> Metode <i>engineering judgement</i> mengutamakan proses verifikasi dapat menggunakan data dan informasi sekunder lainnya yang dapat dipertanggungjawabkan.</p>

        <div class="space"> </div>

        <p style="font-weight: bold;">V. KRITERIA PENILAIAN TKDN</p>

        <ol type="a">
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri Manufaktur dihitung berdasarkan perbandingan antara harga barang jadi dikurangi harga komponen luar negeri terhadap harga barang jadi.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Harga barang jadi sebagaimana dimaksud adalah biaya produksi yang dikeluarkan untuk memproduksi barang.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri Manufaktur dihitung berdasarkan pembobotan terhadap komponen utama, komponen pendukung, dan perakitan.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri Pengembangan dihitung berdasarkan pembobotan terhadap Desain Awal, Engeneering, Prototype, Pengujian,Lisensi, Komersialisasi KBL.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Pembobotan dalam penghitungan TKDN sebagaimana dimaksud berdasarkan tahapan proses.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Penentuan Komponen Dalam Negeri atau Komponen Luar Negeri berdasarkan kriteria :
                <ul>
                    <li>Untuk Bahan Baku (Material) berdasarkan negara asal barang (<i>Country of Origin</i>) </li>
                    <li>Untuk Tenaga kerja berdasarkan kewarganegaraan </li>
                    <li>Untuk Mesin Produksi berdasarkan kepemilikan. </li>
                    <li>Untuk Desain Awal, <i>Engeneering</i>, <i>Prototype</i>, Pengujian,Lisensi, Komersialisasi KBL, berdasarkan tahapan proses.</li>
                </ul>
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Penelusuran penilaian TKDN Manufaktur dilakukan sampai dengan produsen tingkat 2 (Layer 2).
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri untuk Manufaktur dilakukan dengan menggunakan Formulasi perhitungan TKDN Barang Manufaktur sebagai berikut :<br>

                <p style="padding-left: 15px;font-size:13px;font-size:9pt">% TKDN Barang Manufaktur = <u>Biaya Produksi Total – Biaya Produksi Komponen Luar Negeri</u> x 100% </p>
                <p style="padding-left: 250px;font-size:9pt">Biaya Produksi Total</p>
            </li>

            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri untuk Pengembangan dilakukan dengan menggunakan perincian bobot kendaraan berbasis listrik roda 2 atau roda 3 perhitungan sebagai berikut:<br>

                <table class="table5" style="width: 550px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="60%">Kegiatan Pengembangan</th>
                        <th width="30%">Bobot Penilaian<br>Desain Awal</th>
                    </tr>
                    <tr>
                        <th> 1 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Komponen Utama </th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> a. Body, Kabin, dan/atau Sasis </td>
                        <td>7%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> b. Baterai</td>
                        <td>35%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> c. Drive Train</td>
                        <td>13%</td>
                    </tr>
                    <tr>
                        <th> 2 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Komponen Pendukung </th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> a. Sistem Setir (Steering System) & Suspensi</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> b. Sistem Pengereman (Breaking System)</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> c. Roda (Wheel) & Gardan (Axle)</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> d. Electrical Instrument</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> e. Komponen Universal</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <th> 3</th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Komersialisasi </th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> a. Riset Pasar (Performa Penjualan Dalam Negeri)</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> b. Riset Pasar (Performa Penjualan Luar Negeri)</td>
                        <td>1%</td>
                    </tr>

                </table>
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri untuk Pengembangan dilakukan dengan menggunakan perincian bobot kendaraan berbasis listrik roda 4 atau lebih perhitungan sebagai berikut:<br>

                <table class="table5" style="width: 550px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="60%">Kegiatan Pengembangan</th>
                        <th width="30%">Bobot Penilaian<br>Desain Awal</th>
                    </tr>
                    <tr>
                        <th> 1 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Komponen Utama </th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> a. Body, Kabin, dan/atau Sasis </td>
                        <td>7%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> b. Baterai</td>
                        <td>35%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> c. Drive Train</td>
                        <td>13%</td>
                    </tr>
                    <tr>
                        <th> 2 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Komponen Pendukung </th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> a. Sistem Setir (Steering System)</td>
                        <td>4%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> b. Suspensi</td>
                        <td>2%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> c. Sistem Pengereman (Brake System)</td>
                        <td>4%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic"> d. Komponen Universal</td>
                        <td>5%</td>
                    </tr>
                    <tr>
                        <th> 3</th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Komersialisasi </th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> a. Riset Pasar (Performa Penjualan Dalam Negeri)</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> b. Riset Pasar (Performa Penjualan Luar Negeri)</td>
                        <td>1%</td>
                    </tr>

                </table>
            </li>
        </ol>



        <p style="font-weight: bold;"> VI. RUANG LINGKUP </p>

        <p style="padding-left: 15px">Pelaksanaan verifikasi capaian TKDN yang dilakukan PT. SUCOFINDO (Persero) meliputi :</p>
        <ol type="a">
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan verifikasi lapangan terhadap proses produksi produk yang diverifikasi
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan pemeriksaan dan verifikasi dokumen pendukung capaian TKDN terkait produk yang diverifikasi
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan penghitungan capaian TKDN produk yang diverifikasi
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan penyusunan laporan capaian TKDN produk yang diverifikasi
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Menyerahkan laporan hasil verifikasi capaian TKDN kepada Kementerian Perindustrian Republik Indonesia
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Verifikasi TKDN tidak meliputi penelaahan berkaitan dengan keabsahan dokumen-dokumen yang diberikan
                oleh perusahaan.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Data yang tidak disertai dokumen pendukung dinyatakan sebagai Komponen Luar Negeri
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Semua informasi yang tercantum dalam laporan penilaian TKDN ini adalah berdasarkan data dan dokumen
                yang diberikan oleh perusahaan sesuai dengan kondisi di lapangan
            </li>
        </ol>



        <?php function cetak_header($profil, $dataVerif, $alamat, $profilLokal)
        { ?>
            <table class="table3">
                <tr>
                    <td width="20%">Penyedia Barang/Jasa</td>
                    <td width="1%"> : </td>
                    <td width="50%"> {{$profil[0]->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : </td>
                    <td>{{@$alamat[0]->alamat}} </td>
                </tr>
                <tr>
                    <td>Diproduksi Oleh</td>
                    <td> : </td>
                    <td>{{@$profilLokal[0]->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td>Hasil Produksi</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->bidang_usaha}}</td>
                </tr>
                <tr>
                    <td>Jenis Produk</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->jenis_produk}}</td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->tipe}}</td>
                </tr>
                <tr>
                    <td>Spesifikasi</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->spesifikasi}}</td>
                </tr>
                <tr>
                    <td>Merek</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->merk}}</td>
                </tr>
            </table>
        <?php } ?>


        @foreach($dataFiles as $idx => $files)
        <?php
        $cek = json_decode($files->konten);
        if (isset($cek->FORM1_9)) {
            $sheet['rekap'] = $cek->FORM1_9;
        ?>

            <div class="page_break"></div>



            <p style="padding-left: 15px">Rekapitulasi Penilaian TKDN Manufaktur</p>

            <table class="table3">
                <tr>
                    <td width="20%">Penyedia Barang/Jasa</td>
                    <td width="1%"> : </td>
                    <td width="50%"> {{$profil[0]->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : </td>
                    <td>{{@$alamat[0]->alamat}} </td>
                </tr>
                <tr>
                    <td>Diproduksi Oleh</td>
                    <td> : </td>
                    <td>{{@$profilLokal[0]->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td>Hasil Produksi</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->bidang_usaha}}</td>
                </tr>
                <tr>
                    <td>Jenis Produk</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->jenis_produk}}</td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->tipe}}</td>
                </tr>
                <tr>
                    <td>Spesifikasi</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->spesifikasi}}</td>
                </tr>
                <tr>
                    <td>Merek</td>
                    <td> : </td>
                    <td>{{$dataVerif[0]->merk}}</td>
                </tr>
                <tr>
                    <td>Komponen Pendukung</td>
                    <td> : </td>
                    <td> {{$files->nama_jenis}}</td>
                </tr>
            </table>
            <br>
            <table class="table4">
                <tr>
                    <th colspan="2" rowspan="2" width="10px">Uraian</th>
                    <th colspan="3">Biaya</th>
                    <th rowspan="2">TKDN (%)</th>
                </tr>
                <tr>
                    <th>KDN</th>
                    <th>KLN</th>
                    <th>TOTAL</th>
                </tr>


                <?php for ($y = 15; $y <= 26; $y++) { ?>
                    <?php if ($y == 15) { ?>
                        <tr>
                            <td colspan="6" style="background-color:#DADADA;"> I. Bahan Baku (Material) Langsung </td>
                        </tr>
                    <?php } else if ($y == 18) { ?>
                        <tr>
                            <td colspan="6" style="background-color:#DADADA;"> II. Tenaga Kerja Langsung </td>
                        </tr>
                    <?php } else if ($y == 21) { ?>
                        <tr>
                            <td colspan="6" style="background-color:#DADADA;"> III. Factory Overhead </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <?php for ($x = 0; $x < 7; $x++) { ?>
                                <?php if ($x != 2) { ?>
                                    <?php if ($y == 26) { ?> {{--total--}}
                                        <?php if ($x == 0) { ?>
                                            <td colspan="2">
                                                <center>{{$sheet['rekap'][$y][$x]}}</center>
                                            </td>
                                        <?php } else if ($x != 1 && $x != 6) { ?>
                                            <?php
                                            $nilai_kdn = 0;
                                            $nilai_kln = 0;
                                            $nilai_total = 0;
                                            if (is_numeric($sheet['rekap'][$y][5])) {
                                                $kdn = 0;
                                                $kln = 0;
                                                $total = 0;
                                                $grandTotal = 0;
                                                if (is_numeric($sheet['rekap'][$y][3])) {
                                                    $kdn = $sheet['rekap'][$y][3];
                                                }
                                                if (is_numeric($sheet['rekap'][$y][4])) {
                                                    $kln = $sheet['rekap'][$y][4];
                                                }
                                                if (is_numeric($sheet['rekap'][$y][5])) {
                                                    $total = $sheet['rekap'][$y][5];
                                                }
                                                if (is_numeric($sheet['rekap'][26][5])) {
                                                    $grandTotal = $sheet['rekap'][26][5];
                                                }
                                                if ($total != 0) {
                                                    $nilai_kdn = ($kdn / $total) * 100;
                                                    $nilai_kln = ($kln / $total) * 100;
                                                    $nilai_total = 100;
                                                }
                                            }
                                            ?>
                                            <?php if ($x == 3) { ?>{{--kdn--}}
                                                <td style="text-align: right">{{number_format($nilai_kdn, 2, ",", "")}} %</td>
                                            <?php } ?>
                                            <?php if ($x == 4) { ?>{{--kln--}}
                                                <td style="text-align: right">{{number_format($nilai_kln, 2, ",", "")}} %</td>
                                            <?php } ?>
                                            <?php if ($x == 5) { ?>{{--total--}}
                                                <td style="text-align: right">{{number_format($nilai_total, 2, ",", "")}} %</td>
                                            <?php } ?>
                                            {{--<td style="text-align: right">
                                                {{number_format($sheet['rekap'][$y][$x], 2, ",", "")}}
                                            </td>--}}
                                        <?php } else if ($x == 6) { ?>
                                            <td style="text-align: right">
                                                {{number_format($sheet['rekap'][$y][$x]*100, 2, ",", "")}} %
                                            </td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($x == 7 && ($sheet['rekap'][$y][$x] != null)) { ?>
                                            <td>{{number_format($sheet['rekap'][$y][$x]*100, 2, ",", "")}} % </td>
                                            <?php } else {
                                            if ($x == 6) { ?>
                                                <td style="text-align: right">{{number_format($sheet['rekap'][$y][$x], 2, ",", "")}} %</td>
                                            <?php } else if ($x > 1) { ?>
                                                <?php
                                                $nilai_kdn = 0;
                                                $nilai_kln = 0;
                                                $nilai_total = 0;
                                                if (is_numeric($sheet['rekap'][$y][5])) {
                                                    $kdn = 0;
                                                    $kln = 0;
                                                    $total = 0;
                                                    $grandTotal = 0;
                                                    if (is_numeric($sheet['rekap'][$y][3])) {
                                                        $kdn = $sheet['rekap'][$y][3];
                                                    }
                                                    if (is_numeric($sheet['rekap'][$y][4])) {
                                                        $kln = $sheet['rekap'][$y][4];
                                                    }
                                                    if (is_numeric($sheet['rekap'][$y][5])) {
                                                        $total = $sheet['rekap'][$y][5];
                                                    }
                                                    if (is_numeric($sheet['rekap'][26][5])) {
                                                        $grandTotal = $sheet['rekap'][26][5];
                                                    }
                                                    if ($total != 0) {
                                                        $nilai_kdn = ($kdn / $total) * 100;
                                                        $nilai_kln = ($kln / $total) * 100;
                                                        $nilai_total = ($total / $grandTotal) * 100;
                                                    }
                                                }
                                                ?>
                                                <?php if ($x == 3) { ?>{{--kdn--}}
                                                    <td style="text-align: right">{{number_format($nilai_kdn, 2, ",", "")}} %</td>
                                                <?php } ?>
                                                <?php if ($x == 4) { ?>{{--kln--}}
                                                    <td style="text-align: right">{{number_format($nilai_kln, 2, ",", "")}} %</td>
                                                <?php } ?>
                                                <?php if ($x == 5) { ?>{{--total--}}
                                                    <td style="text-align: right">{{number_format($nilai_total, 2, ",", "")}} %</td>
                                                <?php } ?>
                                                {{-- <td style="text-align: right">{{number_format($sheet['rekap'][$y][$x], 2, ",", "")}}</td>--}}
                                            <?php } else { ?>
                                                <td>{{$sheet['rekap'][$y][$x]}}</td>
                                        <?php }
                                        } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
            <p style="padding-left: 15px">Nilai TKDN Manufaktur = {{number_format($sheet['rekap'][26][6]*100, 2, ",", "")}} %
                <?php
                echo '(' . terbilang(number_format($sheet['rekap'][26][6] * 100, 2, ",", "")) . ')';
                ?> </p>

        <?php }


        if (isset($cek->rekapitulasi)) {
            $sheet['rekap'] = $cek->rekapitulasi;
        ?>
            <div class="page_break"></div>



            <p style="padding-left: 15px">Rekapitulasi TKDN Manufaktur Komponen Utama</p>

            <?php echo cetak_header($profil, $dataVerif, $alamat, $profilLokal); ?>
            <br>
            <?php
            $a = 0;
            if ($files->jenis_kbl == 2) {
                $a = 1;
            } ?>
            <table class="table4">
                <tr style="text-align: center">
                    <th rowspan="2">Uraian</th>
                    <th rowspan="2">BOBOT PENILAIAN</th>
                    <th colspan="3">Biaya (%)</th>
                    <th rowspan="2">TKDN (%)</th>
                </tr>
                <tr style="text-align: center">
                    <th>KDN</th>
                    <th>KLN</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td colspan="6" style="background-color:#DADADA;">{{$sheet['rekap'][3][2]}} {{$sheet['rekap'][3][3]}}</td>
                </tr>
                <?php
                $grandTotal = 0;
                $grandTotalTkdn = 0;
                for ($l = 4; $l <= 6; $l++) { ?>
                    <tr>
                        <?php
                        $total = ($sheet['rekap'][$l][6] * 100) + ($sheet['rekap'][$l][8] * 100);
                        $grandTotal = $grandTotal + $total;
                        $grandTotalTkdn = $grandTotalTkdn + ($sheet['rekap'][$l][10] * 100);
                        ?>
                        <td>{{$sheet['rekap'][$l][3]}}</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][4]*100, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][6]*100, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][8]*100, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($total, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][10]*100, 2, ",", "")}} %</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" style="text-align: center">Biaya Produksi</td>
                    <td style="text-align: right">{{number_format($grandTotal/3, 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($grandTotalTkdn, 2, ",", "")}} %</td>
                </tr>
            </table>
            <p style="padding-left: 15px">Nilai TKDN Manufaktur Komponen Utama =
                <?php
                echo number_format($grandTotalTkdn, 2, ",", "") . '% ';
                echo '(' . terbilang(number_format($grandTotalTkdn, 2, ",", "")) . ')';
                ?> </p>

            </p>

        <?php }

        if (isset($cek->rekapitulasi)) {
            $sheet['rekap'] = $cek->rekapitulasi;
        ?>
            <div class="page_break"></div>



            <p style="padding-left: 15px">Rekapitulasi TKDN Manufaktur Komponen Pendukung</p>

            <?php echo cetak_header($profil, $dataVerif, $alamat, $profilLokal); ?>
            <br>
            <?php
            $a = 0;
            if ($files->jenis_kbl == 2) {
                $a = 1;
            } ?>
            <table class="table4">
                <tr style="text-align: center">
                    <th rowspan="2">Uraian</th>
                    <th rowspan="2">BOBOT PENILAIAN</th>
                    <th colspan="3">Biaya (%)</th>
                    <th rowspan="2">TKDN (%)</th>
                </tr>
                <tr style="text-align: center">
                    <th>KDN</th>
                    <th>KLN</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td colspan="6" style="background-color:#DADADA;">{{$sheet['rekap'][7][2]}} {{$sheet['rekap'][7][3]}}</td>
                </tr>
                <?php
                $grandTotal = 0;
                $grandTotalTkdn = 0;
                for ($l = 8; $l <= (12 - $a); $l++) { ?>
                    <tr>
                        <?php
                        $total = ($sheet['rekap'][$l][6] * 100) + ($sheet['rekap'][$l][8] * 100);
                        $grandTotal = $grandTotal + $total;
                        $grandTotalTkdn = $grandTotalTkdn + ($sheet['rekap'][$l][10] * 100);
                        ?>
                        <td>{{$sheet['rekap'][$l][3]}}</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][4]*100, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][6]*100, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][8]*100, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($total, 2, ",", "")}} %</td>
                        <td style="text-align: right">{{number_format($sheet['rekap'][$l][10]*100, 2, ",", "")}} %</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" style="text-align: center">Biaya Produksi</td>
                    <td style="text-align: right">{{number_format($grandTotal/(5-$a), 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($grandTotalTkdn, 2, ",", "")}} %</td>
                </tr>
            </table>
            <p style="padding-left: 15px">Nilai TKDN Manufaktur Komponen Pendukung =
                <?php
                echo number_format($grandTotalTkdn, 2, ",", "") . '% ';
                echo '(' . terbilang(number_format($grandTotalTkdn, 2, ",", "")) . ')';
                ?> </p>

            </p>

        <?php }

        if (isset($cek->rekapitulasi)) {
            $sheet['rekap'] = $cek->rekapitulasi;
            //print_r($sheet['rekap']);die();
        ?>
            <div class="page_break"></div>



            <p style="padding-left: 15px">Rekapitulasi TKDN Perakitan</p>

            <?php echo cetak_header($profil, $dataVerif, $alamat, $profilLokal); ?>
            <br>
            <?php
            $a = 0;
            if ($files->jenis_kbl == 2) {
                $a = 1;
            } ?>
            <table class="table4" style="text-align: center">
                <tr>
                    <th>III. TKDN PERAKITAN (10%)</th>
                    <th>WNI</th>
                    <th colspan="2">Min 80%</th>
                    <th colspan="2">Min 50%</th>
                    <th>TKDN (%)</th>
                </tr>
                <tr>
                    <td style="text-align: left; width: 30%; padding-left: 10px">{{$sheet['rekap'][16-$a][3]}}</td>
                    <td>{{number_format($sheet['rekap'][16-$a][4]*100, 2, ",", "")}} %</td>
                    <td colspan="2">{{number_format($sheet['rekap'][16-$a][6]*100, 2, ",", "")}} %</td>
                    <td colspan="2">{{number_format($sheet['rekap'][16-$a][8]*100, 2, ",", "")}} %</td>
                    <td>{{number_format($sheet['rekap'][16-$a][10]*100, 2, ",", "")}} %</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align: left; padding-left: 10px">{{$sheet['rekap'][17-$a][3]}}</td>
                    <td rowspan="2">{{number_format($sheet['rekap'][17-$a][4]*100, 2, ",", "")}} %</td>
                    <td>{{$sheet['rekap'][17-$a][6]}} </td>
                    <td>{{$sheet['rekap'][17-$a][7]}} </td>
                    <td>{{$sheet['rekap'][17-$a][8]}} </td>
                    <td>{{$sheet['rekap'][17-$a][9]}} </td>
                    <td rowspan="2">{{number_format($sheet['rekap'][18-$a][10]*100, 2, ",", "")}} %</td>
                </tr>
                <tr>
                    <td>{{number_format($sheet['rekap'][18-$a][17]*100, 2, ",", "")}} %</td>
                    <td>{{number_format($sheet['rekap'][18-$a][18]*100, 2, ",", "")}} %</td>
                    <td>{{number_format($sheet['rekap'][18-$a][19]*100, 2, ",", "")}} %</td>
                    <td>{{number_format($sheet['rekap'][18-$a][20]*100, 2, ",", "")}} %</td>
                </tr>
                <tr>
                    <td colspan="6">Biaya Produksi</td>
                    <td>{{number_format(($sheet['rekap'][16-$a][10]*100)+($sheet['rekap'][18-$a][10]*100), 2, ",", "")}} %</td>
                </tr>
            </table>
            <p style="padding-left: 15px">Nilai TKDN Manufaktur Komponen Pendukung =
                <?php
                $nilai = ($sheet['rekap'][16 - $a][10] * 100) + ($sheet['rekap'][18 - $a][10] * 100);
                echo number_format($nilai, 2, ",", "") . '% ';
                echo '(' . terbilang(number_format($nilai, 2, ",", "")) . ')';
                ?> </p>

            </p>

        <?php }

        if (isset($cek->pengembangan)) {
            $sheet['rekap'] = $cek->pengembangan;
            //print_r($sheet['rekap']);die();
        ?>
            <div class="page_break"></div>



            <p style="padding-left: 15px">Rekapitulasi Penilaian TKDN Pengembangan</p>

            <?php echo cetak_header($profil, $dataVerif, $alamat, $profilLokal); ?>
            <br>
            <table class="table4" style="font-size: 10.4px">
                <tr style="background-color:#AEAAAA">
                    <th colspan="3" rowspan="2">KOMPONEN</th>
                    <th rowspan="2">PERSENTASE</th>
                    <th colspan="2">KRITERIA</th>
                    <th rowspan="2">PORSI NILAI</th>
                    <th rowspan="2">NILAI TKDN</th>
                </tr>
                <tr style="background-color:#AEAAAA">
                    <th style="width: 30px">Ada</th>
                    <th style="width: 30px">Tidak Ada</th>
                </tr>
                <tr style="text-align: center">
                    <td>(I)</td>
                    <td colspan="2">(II)</td>
                    <td>(III)</td>
                    <td colspan="2">(IV)</td>
                    <td style="width: 50px">(V)</td>
                    <td style="width: 50px">(VI)</td>
                </tr>

                <?php function cetak($sheet, $baris)
                { ?>
                    <tr style="background-color:#DADADA;">
                        <td style="background-color:white;"></td>
                        <td colspan="2">Desain Awal
                            (Perancangan atau perencanaan yang dilakukan sebelum membuat suatu komponen)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">1</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki Bersama (joint venture) dengan pihak asing, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][30]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][20] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][20] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">2</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki sepenuhnya di dalam negeri, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center">{{number_format($sheet['rekap'][$baris][31]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][21] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][21] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#DADADA;">
                        <td style="background-color:white;"></td>
                        <td colspan="2">Rekayasa/Engineering
                            Penggunaan perangkat lunak computer untuk melakukan alanisa teknis seperti Finite Element Analisys dan Computational Fluid Dynanmic</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">1</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki Bersama (joint venture) dengan pihak asing, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][33]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][22] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][22] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">2</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki sepenuhnya di dalam negeri, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center">{{number_format($sheet['rekap'][$baris][34]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][23] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][23] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#DADADA;">
                        <td style="background-color:white;"></td>
                        <td colspan="2">Prototype
                            (Model/mula-mula dalam bentuk 3D yang menjadi contoh)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">1</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki Bersama (joint venture) dengan pihak asing, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][36]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][24] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][24] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">2</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki sepenuhnya di dalam negeri, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center">{{number_format($sheet['rekap'][$baris][37]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][25] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][25] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#DADADA;">
                        <td style="background-color:white;"></td>
                        <td colspan="2">Pengujian
                            (Pengujian kesesuaian fungsi dan unjuk kerja/performance terhadap standar tertentu)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">1</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki Bersama (joint venture) dengan pihak asing, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][39]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][26] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][26] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">2</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki sepenuhnya di dalam negeri, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center">{{number_format($sheet['rekap'][$baris][40]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][27] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][27] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#DADADA;">
                        <td style="background-color:white;"></td>
                        <td colspan="2">Dokumen Lisensi HKI
                            (Kepemilikan HKI terkait pengembangan yang dilakukan)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">1</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki Bersama (joint venture) dengan pihak asing, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][42]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][28] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][28] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px !important;">2</td>
                        <td style="width: 300px !important;">Dokumen pengembangan dimiliki sepenuhnya di dalam negeri, dapat menunjukan proses modifikasi dari awal sampai akhir</td>
                        <td style="text-align: center">{{number_format($sheet['rekap'][$baris][43]*100, 2, ",", "")}} %</td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][29] == 1) {
                                                            echo "V";
                                                        } ?></td>
                        <td style="text-align: center"><?php if ($sheet['rekap'][$baris][29] == 0) {
                                                            echo "V";
                                                        } ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>

                {{--1--}}
                <?php $baris = 4; ?>
                <tr style="background-color:#AEAAAA;">
                    <td style="text-align: center">I</td>
                    <td colspan="2">Komponen Utama<br>
                        Body, Kabin, dan/atau Sasis (Untuk roda 4 atau lebih) ; atau Rangka dan/atau Body (untuk roda 2 atau 3)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][6]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
                <?php echo cetak($sheet, $baris); ?>
                {{--2--}}
                <?php $baris = 5; ?>
                <tr style="background-color:#AEAAAA;">
                    <td style="text-align: center">II</td>
                    <td colspan="2">Komponen Utama<br>
                        Baterai</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][6]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
                <?php echo cetak($sheet, $baris); ?>
                {{--3--}}
                <?php $baris = 6; ?>
                <tr style="background-color:#AEAAAA;">
                    <td style="text-align: center">III</td>
                    <td colspan="2">Komponen Utama<br>
                        Sistem Penggerak/Drive Train</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][6]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
                <?php echo cetak($sheet, $baris); ?>
                {{--4--}}
                <?php $baris = 7; ?>
                <tr style="background-color:#AEAAAA;">
                    <td style="text-align: center">IV</td>
                    <td colspan="2">Komponen Utama<br>
                        Pilihan system pada komponen pendukung</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][6]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
                <?php echo cetak($sheet, $baris); ?>
                {{--5--}}
                <?php $baris = 8; ?>
                <tr style="background-color:#AEAAAA;">
                    <td style="text-align: center">V</td>
                    <td colspan="2">Komersialisasi Hasil Riset di Pasar Domestik
                        (Menunjukkan bukti-bukti distribusi dan penjualan produk)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][6]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
                {{--6--}}
                <?php $baris = 9; ?>
                <tr style="background-color:#AEAAAA;">
                    <td style="text-align: center">VI</td>
                    <td colspan="2">Komersialisasi Hasil Riset di Pasar Ekspor
                        (Menunjukkan bukti-bukti distribusi dan penjualan produk)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][6]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center"> {{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
                {{--7--}}
                <?php $baris = 11; ?>
                <tr>
                    <td colspan="7" style="text-align: center">TOTAL NILAI</td>
                    <td style="text-align: center">{{number_format($sheet['rekap'][$baris][18]*100, 2, ",", "")}} %</td>
                </tr>
            </table>

            <p style="padding-left: 15px">Nilai TKDN Pengembangan =
                <?php
                echo number_format($sheet['rekap'][$baris][18] * 100, 2, ",", "") . '% ';
                echo '(' . terbilang(number_format($sheet['rekap'][$baris][18] * 100, 2, ",", "")) . ')';
                ?> </p>

            <?php  // print_r($sheet['rekap']);die();
            ?>
        <?php }

        if (isset($cek->rekapitulasi)) {
            $sheet['rekap'] = $cek->rekapitulasi;
        ?>
            <div class="page_break"></div>



            <p style="padding-left: 15px">Rekapitulasi Perhitungan Nilai TKDN Kendaraan Listrik Berbasis Baterai</p>

            <?php echo cetak_header($profil, $dataVerif, $alamat, $profilLokal); ?>
            <br>
            <?php
            $a = 0;
            if ($files->jenis_kbl == 2) {
                $a = 1;
            } ?>
            <table class="table4">
                <tr style="text-align: center">
                    <th style="width: 20%">Uraian</th>
                    <th style="width: 10%">BOBOT PENILAIAN</th>
                    <th colspan="2" style="width: 20%">KDN</th>
                    <th colspan="2" style="width: 20%">KLN</th>
                    <th style="width: 10%">TKDN (%)</th>
                </tr>
                <?php
                $grandTotal = 0;
                $grandTotalTkdn = 0;
                for ($l = 3; $l <= (12 - $a); $l++) { ?>
                    <?php if ($l == 3 || $l == 7) { ?>
                        <tr>
                            <td colspan="7" style="background-color:#DADADA;">{{$sheet['rekap'][$l][2]}} {{$sheet['rekap'][$l][3]}}</td>
                        </tr>
                    <?php } else { ?>

                        <tr>
                            <td>{{$sheet['rekap'][$l][3]}}</td>
                            <td style="text-align: right">{{number_format($sheet['rekap'][$l][4]*100, 2, ",", "")}} %</td>
                            <td colspan="2" style="text-align: right">{{number_format($sheet['rekap'][$l][6]*100, 2, ",", "")}} %</td>
                            <td colspan="2" style="text-align: right">{{number_format($sheet['rekap'][$l][8]*100, 2, ",", "")}} %</td>
                            <td style="text-align: right">{{number_format($sheet['rekap'][$l][10]*100, 2, ",", "")}} %</td>
                        </tr>
                <?php }
                }
                ?>
                <tr>
                    <td style="background-color:#DADADA;">{{$sheet['rekap'][14-$a][2]}} {{$sheet['rekap'][14-$a][3]}}</td>
                    <td style=" text-align: center"> WNI</td>
                    <td colspan="2" style=" text-align: center">Min 80%</td>
                    <td colspan="2" style="text-align: center">Min 50%</td>
                    <th></th>
                </tr>
                <tr>
                    <td style="text-align: left; width: 30%;">{{$sheet['rekap'][16-$a][3]}}</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][16-$a][4]*100, 2, ",", "")}} %</td>
                    <td colspan="2" style="text-align: right">{{number_format($sheet['rekap'][16-$a][6]*100, 2, ",", "")}} %</td>
                    <td colspan="2" style="text-align: right">{{number_format($sheet['rekap'][16-$a][8]*100, 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][16-$a][10]*100, 2, ",", "")}} %</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align: left;">{{$sheet['rekap'][17-$a][3]}}</td>
                    <td rowspan="2" style="text-align: right">{{number_format($sheet['rekap'][17-$a][4]*100, 2, ",", "")}} %</td>
                    <td style="text-align: center">{{$sheet['rekap'][17-$a][6]}} </td>
                    <td style="text-align: center">{{$sheet['rekap'][17-$a][7]}} </td>
                    <td style="text-align: center">{{$sheet['rekap'][17-$a][8]}} </td>
                    <td style="text-align: center">{{$sheet['rekap'][17-$a][9]}} </td>
                    <td rowspan="2" style="text-align: right">{{number_format($sheet['rekap'][18-$a][10]*100, 2, ",", "")}} %</td>
                </tr>
                <tr>
                    <td style="text-align: right">{{number_format($sheet['rekap'][18-$a][17]*100, 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][18-$a][18]*100, 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][18-$a][19]*100, 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][18-$a][20]*100, 2, ",", "")}} %</td>
                </tr>
                <tr>
                    <td style="background-color:#DADADA;">{{$sheet['rekap'][19-$a][2]}} {{$sheet['rekap'][19-$a][3]}}</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][19-$a][4]*100, 2, ",", "")}} %</td>
                    <td colspan="2" style="text-align: right">{{number_format($sheet['rekap'][19-$a][6]*100, 2, ",", "")}} %</td>
                    <td colspan="2" style="text-align: right">{{number_format($sheet['rekap'][19-$a][8]*100, 2, ",", "")}} %</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][19-$a][10]*100, 2, ",", "")}} %</td>
                </tr>

                <tr>
                    <td colspan="6" style="text-align: center">{{$sheet['rekap'][20-$a][2]}}</td>
                    <td style="text-align: right">{{number_format($sheet['rekap'][20-$a][10]* 100, 2, ",", "")}} %</td>
                </tr>

            </table>
            <p style="padding-left: 15px">Nilai TKDN Kendaraan Listrik Berbasis Baterai =
                <?php
                echo number_format($sheet['rekap'][20 - $a][10] * 100, 2, ",", "") . '% ';
                echo '(' . terbilang(number_format($sheet['rekap'][20 - $a][10] * 100, 2, ",", "")) . ')';
                ?> </p>

            </p>

        <?php }

        ?>
        {{--
    <?php
    if (isset($cek->rekapitulasi)) {
        $sheet['rekap'] = $cek->rekapitulasi;
        // print_r($sheet['rekap']);die();
    ?>
        <div class="page_break"></div>
        <div class="header">
            <table style="width:100%">
                <tr>
                    <td style="padding-top:20px">
                        <img src="{{public_path('/img/logoKemenperin.png')}}" style="width:150px;">
        </td>
        <td style="padding-top:15px">
            <img src="{{public_path('/img/logosci.png')}}" style="width:80px;float: right;">
        </td>
        </tr>
        </table>
        </div>

        <hr>
        <br>
        <p style="padding-left: 15px">Rekapitulasi Penilaian TKDN Elektronika dan Telematika</p>

        <table class="table3">
            <tr>
                <td width="20%">Penyedia Barang/Jasa</td>
                <td width="1%"> : </td>
                <td width="50%"> {{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td> : </td>
                <td>{{@$alamat[0]->alamat}} </td>
            </tr>
            <tr>
                <td>Diproduksi Oleh</td>
                <td> : </td>
                <td>{{@$profilLokal[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Hasil Produksi</td>
                <td> : </td>
                <td>{{$dataVerif[0]->bidang_usaha}}</td>
            </tr>
            <tr>
                <td>Jenis Produk</td>
                <td> : </td>
                <td>{{$dataVerif[0]->jenis_produk}}</td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td> : </td>
                <td>{{$dataVerif[0]->tipe}}</td>
            </tr>
            <tr>
                <td>Spesifikasi</td>
                <td> : </td>
                <td>{{$dataVerif[0]->spesifikasi}}</td>
            </tr>
            <tr>
                <td>Merek</td>
                <td> : </td>
                <td>{{$dataVerif[0]->merk}}</td>
            </tr>
            <tr>
                <td>Komponen Utama</td>
                <td> : </td>
                <td> {{$files->nama_jenis}}</td>
            </tr>
        </table>
        <br>
        <table class="table4">
            <tr>
                <th>Uraian</th>
                <th>Bobot</th>
                <th>KDN</th>
                <th>KLN</th>
                <th>TKDN (%)</th>
            </tr>
            <tr>
                <td>I. TKDN Manufaktur</td>
                <td>70,00%</td>
                <td> %</td>
                <td> %</td>
                <td> %</td>
            </tr>
            <tr>
                <td>II. TKDN Pengembangan</td>
                <td>30,00%</td>
                <td>{{$sheet['rekap'][19][6]*100}} %</td>
                <td>{{$sheet['rekap'][19][8]*100}} %</td>
                <td>{{$sheet['rekap'][19][10]*100}} %</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">TKDN Produk Digital</td>
                <td>{{$sheet['rekap'][19][10]*100}} %</td>
            </tr>
        </table>
        <p style="padding-left: 15px">Nilai TKDN Produk Digital = {{($sheet['rekap'][19][10]*100)}} %</p>

        <?php } ?>--}}

        @endforeach

    </main>

    <?php
    function changeFormat($tgl)
    {
        if ($tgl != "") {
            $explode = explode("-", $tgl);
            $arrBulan = array(
                "00" => "",
                "01" => "Januari",
                "02" => "Februari",
                "03" => "Maret",
                "04" => "April",
                "05" => "Mei",
                "06" => "Juni",
                "07" => "Juli",
                "08" => "Agustus",
                "09" => "September",
                "10" => "Oktober",
                "11" => "November",
                "12" => "Desember",
            );
            $tgl = (int)@$explode[2] . ' ' . @$arrBulan[$explode[1]] . ' ' . @$explode[0];
            return $tgl;
        } else {
            return '    -';
        }
    }


    function konversi($x)
    {

        $x = abs($x);
        $angka = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan",   "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";

        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = konversi($x - 10) . " Belas";
        } else if ($x < 100) {
            $temp = konversi($x / 10) . " Puluh" . konversi($x % 10);
        } else if ($x < 200) {
            $temp = " Seratus" . konversi($x - 100);
        } else if ($x < 1000) {
            $temp = konversi($x / 100) . " Ratus" . konversi($x % 100);
        } else if ($x < 2000) {
            $temp = " Seribu" . konversi($x - 1000);
        } else if ($x < 1000000) {
            $temp = konversi($x / 1000) . " Ribu" . konversi($x % 1000);
        } else if ($x < 1000000000) {
            $temp = konversi($x / 1000000) . " Juta" . konversi($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = konversi($x / 1000000000) . " Milyar" . konversi($x % 1000000000);
        }

        return $temp;
    }

    function tkoma($x)
    {
        $str = stristr($x, ",");
        $ex = explode(',', $x);
        $var = '';
        if (($ex[1] / 10) >= 1) {
            $var = abs($ex[1]);
        }
        $string = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan",   "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";

        $var2 = $ex[1] / 10;
        $pjg = strlen($str);
        $i = 1;


        if ($var >= 1 && $var < 12) {
            $temp .= " " . $string[$var];
        } else if ($var > 12 && $var < 20) {
            $temp .= konversi($var - 10) . " ";
        } else if ($var > 20 && $var < 100) {
            $temp .= konversi($var / 10) . " " . konversi($var % 10);
        } else {
            if ($var2 < 1) {

                while ($i < $pjg) {
                    $char = substr($str, $i, 1);
                    $i++;
                    $temp .= " " . $string[$char];
                }
            }
        }
        return $temp;
    }

    function terbilang($x)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(konversi(x));
        } else {
            $poin = trim(tkoma($x));
            $hasil = trim(konversi($x));
        }

        if ($poin && $poin != "Nol Nol") {
            $hasil = $hasil . " Koma " . $poin . ' Persen';
        } else {
            $hasil = $hasil . ' Persen';
        }
        return $hasil;
    }

    ?>
</body>

</html>