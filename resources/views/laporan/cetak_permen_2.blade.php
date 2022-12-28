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
            height: 2cm;
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

        .table1Produk td {
            border: 1px solid black;
            padding: 10px;
            vertical-align: top;
        }

        .table1Produk {
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

        #p_daskum li {
            vertical-align: middle;
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
        <p style="text-align: center;"><b> RINGKASAN EKSEKUTIF</b></p>

        <div class="dspace"> </div>

        <p>
            {{$profil[0]->nama_perusahaan}} merupakan perusahaan dengan komposisi saham {{$profil[0]->saham_negeri}}% dimiliki oleh Warga Negara Indonesia dan {{$profil[0]->saham_luar_negeri}}% dimiliki oleh Warga Negara Asing,
            dengan akta pendirian perusahaan no. {{$profil[0]->akta_pendirian}} tanggal {{changeFormat($profil[0]->tanggal_akta)}} oleh {{$profil[0]->notaris}}
            dan Izin Usaha No. {{$profil[0]->ijin_usaha}} yang diterbitkan oleh {{$profil[0]->penerbit_ijin}} pada tanggal {{changeFormat($profil[0]->tanggal_terbit_ijin)}}.
        </p>

        <div class="space"> </div>

        <p>
            Dalam Laporan ini jenis produk yang diverifikasi Tingkat Komponen Dalam Negeri (TKDN) oleh PT. SUCOFINDO (Persero) adalah {{$dataVerif[0]->jenis_produk}}, {{$dataVerif[0]->tipe}}.
        </p>

        <div class="space"> </div>

        <p>
            Adapun hasil verifikasi terhadap produk {{$dataVerif[0]->jenis_produk}}, {{$dataVerif[0]->tipe}} ditunjukkan oleh Tabel berikut ini :
        </p>

        <table class="table1">
            <thead>
                <tr>
                    <th rowspan="3" style="text-align:center"> Jenis Produk </th>
                    <th rowspan="3" style="text-align:center"> Tipe </th>
                    <th rowspan="3" style="text-align:center"> Nilai TKDN (%) </th>
                    <th colspan="3" style="text-align:center"> Manufaktur (%) </th>
                    <th colspan="3" style="text-align:center"> Pengembangan (%) </th>
                </tr>
                <tr>
                    <th rowspan="2" style="text-align:center">Capaian TKDN</th>
                    <th colspan="2" style="text-align:center">Komposisi</th>
                    <th rowspan="2" style="text-align:center">Capaian TKDN</th>
                    <th colspan="2" style="text-align:center">Komposisi</th>
                </tr>
                <tr>
                    <th style="text-align:center">KDN</th>
                    <th style="text-align:center">KLN</th>
                    <th style="text-align:center">KDN</th>
                    <th style="text-align:center">KLN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataFiles as $idx => $data)
                <tr>
                    <td>{{$data->jenis_produk}}</td>
                    <td>{{$data->tipe}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][6][7]*100,2)}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][4][7]*100,2)}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][4][5]*100,2)}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][4][6]*100,2)}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][5][7]*100,2)}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][5][5]*100,2)}}</td>
                    <td style="text-align:center">{{number_format($dataProduk[$idx]['rekapitulasi'][5][6]*100,2)}}</td>
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



        <div class="head">
            <h3> PROFIL PERUSAHAAN</h3>
        </div>

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
                <td>{{$profil[0]->pejabat}} &nbsp;&nbsp; Jabatan : {{$profil[0]->jabatan}}</td>
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
            <b><u>II. PABRIKAN LOKAL (ELECTRONIC MANUFACTURING SERVICES)</u></b>
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
                <td>{{@$profilLokal[0]->pejabat}} &nbsp;&nbsp; Jabatan : {{@$profilLokal[0]->jabatan}}</td>
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
            <b><u>III. PENGEMBANGAN (DESIGN HOUSE)</u></b>
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
                <td>{{@$profilPengembang[0]->pejabat}} &nbsp;&nbsp; Jabatan : {{@$profilPengembang[0]->jabatan}}</td>
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


        <div class="page_break"> </div>

        <p>
            <b><u>IV. DATA PRODUK YANG DIVERIFIKASI</u></b>
        </p>

        @foreach($dataVerif as $idx => $data)
        <table class="table1Produk">
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
                <td style="border-right-style: none;"> Merek </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->merk}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Spesifikasi </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->spesifikasi}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Kode HS</td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->kode_hs}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Standar Produk </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->standar_produk}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Sertifikat Produk </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->sertifikat_produk}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Merek </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->merk}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Kapasitas Izin </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->kapasitas_izin}} </td>
            </tr>
            <tr>
                <td style="border-right-style: none;"> Kapasitas VKI </td>
                <td style="border-right-style: none;border-left-style: none;"> : </td>
                <td style="border-left-style: none;">{{$data->kapasitas_vki}} </td>
            </tr>
        </table>
        <div class="page_break"></div>

        @endforeach


        <p style="text-align: center;"><b> LAPORAN VERIFIKASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</b></p>

        <div class="dspace"> </div>


        <p style="font-weight: bold;">I. LATAR BELAKANG</p>

        <p style="padding-left: 15px">
            Sesuai dengan Permohonan Verifikasi TKDN {{$profil[0]->nama_perusahaan}}
            tanggal {{changeFormat(@$oc[0]->tanggal)}} perihal pekerjaan verifikasi capaian Tingkat Komponen Dalam Negeri (TKDN) untuk Barang/Jasa Produksi Dalam Negeri,
            PT. SUCOFINDO (Persero) telah melakukan verifikasi TKDN terhadap
            {{@$profilLokal[0]->nama_perusahaan}} sebagai Pabrikan Lokal
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

        <p style="font-weight: bold;"> II. TUJUAN </p>

        <p style="padding-left: 15px">
            Tujuan dari verifikasi capaian TKDN adalah sebagai berikut:
        </p>

        <ol>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Pemastian penggunaan produk dalam negeri terhadap penyediaan barang/jasa produk Elektronika dan Telematika.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Mengetahui nilai capaian TKDN produk Elektronika dan Telematika yang dihasilkan oleh perusahaan.</li>
        </ol>

        <div class="space"> </div>

        <p style="font-weight: bold;"> III. DASAR HUKUM </p>

        <p id="p_daskum">
            {!! $laporan[0]->dasar_hukum !!}
        </p>

        <div class="space"> </div>

        <p style="font-weight: bold;"> IV. METODOLOGI </p>

        <p style="padding-left: 15px"> a. <i>Desk Study</i></p>
        <p style="padding-left: 35px"> <i>Desk Study</i> merupakan metode yang dilakukan dengan menggunakan proses pengecekan terhadap literatur maupun dokumen tertulis. Proses yang dilakukan dengan metoda ini dapat dipertanggung jawabkan karena didukung oleh literatur ataupun dokumen tertulis.</p>
        <p style="padding-left: 15px"> b. Wawancara / <i>Interview</i></p>
        <p style="padding-left: 35px"> Proses wawancara merupakan proses lanjutan dari <i>Desk Study</i>, dimana wawancara dilakukan secara langsung dengan pihak yang memiliki kompetensi untuk memberikan penjelasan terhadap seluruh kegiatan yang diverifikasi. Dalam kegiatan verifikasi TKDN, proses wawancara menjadi suatu hal yang sangat penting karena dapat digali informasi-informasi yang tidak diperoleh dari dokumen tertulis maupun hasil pengamatan langsung di lapangan.</p>
        <p style="padding-left: 15px"> c. Verifikasi Lapangan</p>
        <p style="padding-left: 35px"> Proses verifikasi lapangan merupakan kegiatan kunjungan lapangan untuk melakukan pengamatan langsung di lapangan. Dengan menggunakan metoda ini, proses verifikasi yang sebelumnya hanya berdasarkan literatur dan dokumen tertulis menjadi lebih akurat karena didukung oleh hasil pengamatan langsung di lapangan.</p>
        <p style="padding-left: 15px"> d. Komparasi</p>
        <p style="padding-left: 35px"> Proses komparasi adalah metoda membandingkan hasil kegiatan verifikasi dengan referensi yang sudah ada untuk produk sejenis. Dengan menggunakan metoda ini, verifikator memiliki Baganan atau pemahaman yang lebih jelas mengenai objek yang akan diverifikasi. Disamping itu, diperoleh informasi yang lebih lengkap dari objek yang akan diperiksa, sehingga dapat dilakukan proses analisa terhadap hasil yang dilakukan.</p>
        <p style="padding-left: 15px"> e. Engineering Judgement </p>
        <p style="padding-left: 35px"> Dalam pelaksanaan kegiatan verifikasi, dimungkinkan terdapat data & dokumen yang kurang memadai untuk diolah menjadi informasi yang dibutuhkan, sehingga diperlukan pendekatan teknis yang dilakukan dengan menggunakan metoda <i>engineering judgement</i>. </p>
        <p style="padding-left: 35px"> Metode <i>engineering judgement</i> mengutamakan proses verifikasi dapat menggunakan data dan informasi sekunder lainnya yang dapat dipertanggungjawabkan.</p>

        <div class="space"> </div>

        <p style="font-weight: bold;"> V. KRITERIA PENILAIAN TKDN </p>
        <ol type="a">
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri Manufaktur dihitung berdasarkan perbandingan antara harga barang jadi dikurangi harga komponen luar negeri terhadap harga barang jadi.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Harga barang jadi sebagaimana dimaksud adalah biaya produksi yang dikeluarkan untuk memproduksi barang
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri Pengembangan dihitung berdasarkan pembobotan terhadap Piranti Lunak, Desain Industri, dan Desain Tata Letak.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Pembobotan dalam penghitungan TKDN sebagaimana dimaksud berdasarkan tahapan proses.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Penentuan Komponen Dalam Negeri atau Komponen Luar Negeri berdasarkan kriteria :
                <ul>
                    <li>Untuk Bahan Baku (Material) berdasarkan negara asal barang (Country of Origin)</li>
                    <li>Untuk Tenaga kerja berdasarkan kewarganegaraan</li>
                    <li>Untuk Mesin Produksi berdasarkan kepemilikan.</li>
                    <li>Untuk Piranti Lunak, Desain Industri, Desain Tata Letak, berdasarkan tahapan proses.</li>
                </ul>
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Penelusuran penilaian TKDN Manufaktur dilakukan sampai dengan produsen tingkat 2 (Layer 2).
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri untuk Manufaktur dilakukan dengan menggunakan Formulasi perhitungan TKDN Barang Manufaktur sebagai berikut :
                <br>
                <p style="padding-left: 0px;padding-bottom:0px;margin-bottom:0px;font-size:9pt">% TKDN Barang Manufaktur = <u>Biaya Produksi Total – Biaya Produksi Komponen Luar Negeri</u> x 100% </p>
                <p style="padding-left: 250px;padding-top:0px;margin-top:0px;font-size:9pt">Biaya Produksi Total</p>
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri untuk Pengembangan dilakukan dengan menggunakan perincian bobot perhitungan sebagai berikut:

                <table class="table5" style="width: 550px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="50%">Komponen Pengembangan</th>
                        <th width="20%">Digital</th>
                        <th width="20%">Non Digital</th>
                    </tr>
                    <tr>
                        <th>1.</th>
                        <th style="text-align: left;padding-left: 5px" colspan="3">Piranti Lunak</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">a. Source Code dan Compile</td>
                        <td>23,33%</td>
                        <td rowspan="3"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">b. Develop User Interface</td>
                        <td>5,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">c. Testing & Debugging</td>
                        <td>5,00%</td>
                    </tr>
                    <tr>
                        <th>2.</th>
                        <th style="text-align: left;padding-left: 5px;" colspan="3">Desain Industri</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">a. Product Design</td>
                        <td>13,34%</td>
                        <td>20,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">b. Mechanical Design</td>
                        <td>10,00%</td>
                        <td>15,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">c. Computer Numerical Control (CNC) or mock up</td>
                        <td>10,00%</td>
                        <td>15,00%</td>
                    </tr>
                    <tr>
                        <th>3.</th>
                        <th style="text-align: left;padding-left: 5px" colspan="3">Desain Tata Letak</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">a. Schematic Diagram</td>
                        <td>8,33%</td>
                        <td>10,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">b. Engineering Validation Testing/Bread Boarding</td>
                        <td>5,00%</td>
                        <td>10,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">c. Design Circuit Board (Printed Circuit Board/PCB)</td>
                        <td>10,00%</td>
                        <td>10,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">d. Design/Production Prototyping</td>
                        <td>5,00%</td>
                        <td>10,00%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left;padding-left: 5px;font-style:italic">e. Testing and Calibration Printed Circuit Board Assembly Surface Mounted Technology (PCBA SMT)/Jig Test Developmet</td>
                        <td>5,00%</td>
                        <td>10,00%</td>
                    </tr>
                </table>
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Formulasi perhitungan TKDN produk Elektronika dan Telematika sebagai berikut :
                <p style="padding-left: 15px">
                    % TKDN Produk Digital = (70% x TKDN Manufaktur) + (30% x TKDN Pengembangan)<br>
                    % TKDN Produk Non Digital = (80% x TKDN Manufaktur) + (20% x TKDN Pengembangan)<br>
                </p>
            </li>
        </ol>

        <div class="space"></div>

        <p style="font-weight: bold;"> VI. RUANG LINGKUP </p>

        <p style="padding-left: 15px">
            Pelaksanaan verifikasi capaian TKDN yang dilakukan PT. Sucofindo (Persero) meliputi :
        </p>
        <ol type="a">
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan verifikasi lapangan terhadap proses produksi produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan pemeriksaan dan verifikasi dokumen pendukung capaian TKDN terkait produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan penghitungan capaian TKDN produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan penyusunan laporan capaian TKDN produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Menyerahkan laporan hasil verifikasi capaian TKDN kepada Kementerian Perindustrian Republik Indonesia.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Verifikasi TKDN tidak meliputi penelaahan berkaitan dengan keabsahan dokumen-dokumen yang diberikan oleh penyedia barang/jasa.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Data yang tidak disertai dokumen pendukung dinyatakan sebagai Komponen Luar Negeri.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Semua informasi yang tercantum dalam laporan penilaian TKDN ini adalah berdasarkan data dan dokumen yang diberikan oleh perusahaan sesuai dengan kondisi di lapangan.
            </li>
        </ol>
        </p>

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>
        <p style="font-size:11px">Rekapitulasi Penilaian TKDN Manufaktur</p>
        <table class="table3">
            <tr>
                <td width="30%">Penyedia Barang / Jasa</td>
                <td width="3%">:</td>
                <td width="67%">{{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{@$alamat[0]->alamat}}</td>
            </tr>
            <tr>
                <td>Diproduksi Oleh</td>
                <td>:</td>
                <td>{{@$profilLokal[0]->nama_perusahaan}} </td>
            </tr>
            <tr>
                <td>Hasil Produksi</td>
                <td>:</td>
                <td>{{$dataVerif[0]->nama_kelompok}} </td>
            </tr>
            <tr>
                <td>Jenis Produk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->jenis_produk}} </td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td>:</td>
                <td>{{$dataVerif[0]->tipe}} </td>
            </tr>
            <tr>
                <td>Spesifikasi</td>
                <td>:</td>
                <td>{{$dataVerif[0]->spesifikasi}} </td>
            </tr>
            <tr>
                <td>Merk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->merk}} </td>
            </tr>
        </table>

        <br>

        <table class="table4">
            <thead style="vertical-align:middle;text-align:center">
                <tr>
                    <th rowspan="2">Uraian</th>
                    <th colspan="3">Biaya (%)</th>
                    <th rowspan="2">TKDN (%)</th>
                </tr>
                <tr>
                    <th>KDN</th>
                    <th>KLN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $a = $data['manufaktur'];
                $view = '';
                $align = '';
                $totalBiayaTotal = $a[14][5];
                for ($i = 3; $i < count($a); $i++) { ?>
                    <tr>
                        @if((strpos($a[$i][1], "Bahan (material) Langsung") !== false) || (strpos($a[$i][1], "Tenaga kerja Langsung") !== false) || (strpos($a[$i][1], "Biaya Tidak Langsung Pabrik (Factory Overhead)") !== false))
                        <td colspan="5" style="background-color:#DADADA;">{{$a[$i][0]}} &nbsp; {{$a[$i][1]}}</td>
                        @else
                        @if($a[$i][0] == "Biaya Produksi")
                        <td><b>{{$a[$i][0]}}</b></td>
                        <?php
                        if ($a[$i][3] != null) {
                            $a[$i][3] = number_format(($a[$i][3] / $a[$i][5] * 100), 2);
                        } else {
                            $a[$i][3] = "-";
                        }
                        if ($a[$i][4] != null) {
                            $a[$i][4] = number_format(($a[$i][4] / $a[$i][5] * 100), 2);
                        } else {
                            $a[$i][4] = "-";
                        }
                        if ($a[$i][5] != null) {
                            if ($a[$i][5] == "0") {
                                $a[$i][5] = '-';
                            } else {
                                $a[$i][5] = number_format(($a[$i][5] / $totalBiayaTotal * 100), 2, ",", ".");
                            }
                        } else {
                            $a[$i][5] = "-";
                        }
                        if ($a[$i][6] !== null) {
                            $a[$i][6] = number_format($a[$i][6], 2);
                        }
                        ?>
                        @else
                        <td>{{$a[$i][0]}} &nbsp; {{$a[$i][1]}}</td>
                        <?php
                        if ($a[$i][3] != null) {
                            $a[$i][3] = number_format(($a[$i][3] / $a[$i][5] * 100), 2);
                        } else {
                            $a[$i][3] = "-";
                        }
                        if ($a[$i][4] != null) {
                            $a[$i][4] = number_format(($a[$i][4] / $a[$i][5] * 100), 2);
                        } else {
                            $a[$i][4] = "-";
                        }
                        if ($a[$i][5] != null) {
                            if ($a[$i][5] == "0") {
                                $a[$i][5] = '-';
                            } else {
                                $a[$i][5] = number_format(($a[$i][5] / $totalBiayaTotal * 100), 2, ",", ".");
                            }
                        } else {
                            $a[$i][5] = "-";
                        }
                        if ($a[$i][6] !== null) {
                            $a[$i][6] = number_format($a[$i][6], 2);
                        }
                        ?>
                        @endif
                        <td style="text-align:center">{{$a[$i][3]}}</td>
                        <td style="text-align:center">{{$a[$i][4]}}</td>
                        <td style="text-align:center">{{$a[$i][5]}}</td>
                        <td style="text-align:center">{{$a[$i][6]}}</td>
                        @endif
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <p>Nilai TKDN Manufaktur = {{number_format($a[14][6],2)}} % <i>( {{ terbilang(number_format($a[14][6],2,",",".")) }} )</i></p>

        @endforeach

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>

        <p style="font-size:11px">Rekapitulasi Penilaian TKDN Pengembangan</p>
        <table class="table3">
            <tr>
                <td width="30%">Penyedia Barang / Jasa</td>
                <td width="3%">:</td>
                <td width="67%">{{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{@$alamat[0]->alamat}}</td>
            </tr>
            <tr>
                <td>Didesain Oleh</td>
                <td>:</td>
                <td>{{@$profilPengembang[0]->nama_perusahaan}} </td>
            </tr>
            <tr>
                <td>Hasil Produksi</td>
                <td>:</td>
                <td>{{$dataVerif[0]->nama_kelompok}} </td>
            </tr>
            <tr>
                <td>Jenis Produk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->jenis_produk}} </td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td>:</td>
                <td>{{$dataVerif[0]->tipe}} </td>
            </tr>
            <tr>
                <td>Spesifikasi</td>
                <td>:</td>
                <td>{{$dataVerif[0]->spesifikasi}} </td>
            </tr>
            <tr>
                <td>Merk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->merk}} </td>
            </tr>
        </table>

        <br>

        <table class="table4">
            <thead style="vertical-align:middle;text-align:center">
                <tr>
                    <th>Komponen Pengembangan</th>
                    <th>Bobot Maksimal</th>
                    <th>Bobot Dokumen</th>
                    <th>KDN</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                <?php $a = $data['pengembangan']; ?>
                <tr>
                    <td colspan="5" style="background-color:#DADADA;text-align: left;">1. Piranti Lunak</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">a. Compile dan Source Code</td>
                    <td>23,33%</td>
                    <td>{{number_format($a[3][10]*100,2)}}</td>
                    <td>{{number_format($a[3][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">b. Develop User Interface</td>
                    <td>5,00%</td>
                    <td>{{number_format($a[4][10]*100,2)}}</td>
                    <td>{{number_format($a[4][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">c. Testing and Debugging</td>
                    <td>5,00%</td>
                    <td>{{number_format($a[5][10]*100,2)}}</td>
                    <td>{{number_format($a[5][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td colspan="5" style="background-color:#DADADA;text-align: left;">2. Desain Industri</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">a. Product Design</td>
                    <td>13,34%</td>
                    <td>{{number_format($a[8][10]*100,2)}}</td>
                    <td>{{number_format($a[8][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">b. Mechanical Design</td>
                    <td>10,00%</td>
                    <td>{{number_format($a[9][10]*100,2)}}</td>
                    <td>{{number_format($a[9][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">c. Computer Numerical Control (CNC) or mock up</td>
                    <td>10,00%</td>
                    <td>{{number_format($a[10][10]*100,2)}}</td>
                    <td>{{number_format($a[10][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td colspan="5" style="background-color:#DADADA;text-align: left;">3. Desain Tata Letak</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">a. Schematic Diagram</td>
                    <td>8,33%</td>
                    <td>{{number_format($a[13][10]*100,2)}}</td>
                    <td>{{number_format($a[13][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">b. Engineering Validation Testing/Bread Boarding</td>
                    <td>5,00%</td>
                    <td>{{number_format($a[14][10]*100,2)}}</td>
                    <td>{{number_format($a[14][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">c. Design Circuit Board (Printed Circuit Board/PCB)</td>
                    <td>10,00%</td>
                    <td>{{number_format($a[15][10]*100,2)}}</td>
                    <td>{{number_format($a[15][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">d. Design/Production Prototyping</td>
                    <td>5,00%</td>
                    <td>{{number_format($a[16][10]*100,2)}}</td>
                    <td>{{number_format($a[16][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:left;font-style:italic">e. Testing and Calibration Printed Circuit Board Assembly Surface Mounted Technology (PCBA SMT)/Jig Test Developmet</td>
                    <td>5,00%</td>
                    <td>{{number_format($a[17][10]*100,2)}}</td>
                    <td>{{number_format($a[17][11]*100,2)}}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="text-align:center">TOTAL TKDN PENGEMBANGAN</td>
                    <td></td>
                    <td></td>
                    <td>{{number_format($a[18][11]*100,2)}}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>Nilai TKDN Pengembangan = {{number_format($a[18][11]*100,2)}} % <i>( {{ terbilang(number_format($a[18][11]*100,2,",",".")) }} )</i></p>

        @endforeach

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>

        <p style="font-size:11px">Rekapitulasi Penilaian TKDN Elektronika dan Telematika</p>
        <table class="table3">
            <tr>
                <td width="30%">Penyedia Barang / Jasa</td>
                <td width="3%">:</td>
                <td width="67%">{{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{@$alamat[0]->alamat}}</td>
            </tr>
            <tr>
                <td>Diproduksi Oleh</td>
                <td>:</td>
                <td>{{@$profilLokal[0]->nama_perusahaan}} </td>
            </tr>
            <tr>
                <td>Didesain Oleh</td>
                <td>:</td>
                <td>{{@$profilPengembang[0]->nama_perusahaan}} </td>
            </tr>
            <tr>
                <td>Hasil Produksi</td>
                <td>:</td>
                <td>{{$dataVerif[0]->nama_kelompok}} </td>
            </tr>
            <tr>
                <td>Jenis Produk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->jenis_produk}} </td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td>:</td>
                <td>{{$dataVerif[0]->tipe}} </td>
            </tr>
            <tr>
                <td>Spesifikasi</td>
                <td>:</td>
                <td>{{$dataVerif[0]->spesifikasi}} </td>
            </tr>
            <tr>
                <td>Merk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->merk}} </td>
            </tr>
        </table>

        <br>

        <table class="table4">
            <thead style="vertical-align:middle;text-align:center">
                <tr>
                    <th>Uraian</th>
                    <th>Bobot</th>
                    <th>KDN</th>
                    <th>KLN</th>
                    <th>TKDN</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                <?php $a = $data['rekapitulasi']; ?>
                <tr>
                    <td style="text-align:left">I. TKDN Manufaktur</td>
                    <td>{{number_format($a[4][2]*100,2)}}</td>
                    <td>{{number_format($a[4][5]*100,2)}}</td>
                    <td>{{number_format($a[4][6]*100,2)}}</td>
                    <td>{{number_format($a[4][7]*100,2)}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">II. TKDN Pengembangan</td>
                    <td>{{number_format($a[5][2]*100,2)}}</td>
                    <td>{{number_format($a[5][5]*100,2)}}</td>
                    <td>{{number_format($a[5][6]*100,2)}}</td>
                    <td>{{number_format($a[5][7]*100,2)}}</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;">TKDN Produk Digital</td>
                    <?php $totalProdukDigital = ($a[4][7] * 100) + ($a[5][7] * 100); ?>
                    <td>{{number_format($totalProdukDigital,2)}}</td>
                </tr>
            </tbody>
        </table>
        <p>Nilai TKDN Produk Digital = {{number_format($totalProdukDigital,2)}} % <i>( {{ terbilang(number_format($totalProdukDigital,2,",",".")) }} )</i></p>

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