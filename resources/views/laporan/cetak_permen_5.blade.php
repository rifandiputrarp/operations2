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
            {{$profil[0]->nama_perusahaan}} merupakan perusahaan dengan komposisi saham {{$profil[0]->saham_negeri}}% dimiliki oleh Warga Negara Indonesia dan {{$profil[0]->saham_luar_negeri}}% dimiliki oleh Warga Negara Asing.
        </p>

        <div class="space"> </div>

        <p>
            Dalam Laporan ini jenis produk yang diverifikasi Tingkat Komponen Dalam Negeri (TKDN) oleh PT. SUCOFINDO (Persero) adalah {{$dataVerif[0]->jenis_produk}}, {{$dataVerif[0]->tipe}}.
        </p>

        <div class="space"> </div>

        <p>
            Adapun hasil verifikasi terhadap produk {{$dataVerif[0]->jenis_produk}}, {{$dataVerif[0]->tipe}} ditunjukkan oleh Tabel berikut ini :
        </p>

        <table class="table1" style="margin-left:-10px;font-size: 8pt;">
            <thead>
                <tr>
                    <th rowspan="3" style="text-align:center"> Jenis Produk </th>
                    <th rowspan="3" style="text-align:center"> Tipe </th>
                    <th rowspan="3" style="text-align:center"> Nilai TKDN (%) </th>
                    <th colspan="3" style="text-align:center"> Manufaktur (%) </th>
                    <th colspan="3" style="text-align:center"> Pengembangan (%) </th>
                    <th colspan="3" style="text-align:center"> Aplikasi (%) </th>
                </tr>
                <tr>
                    <th rowspan="2" style="text-align:center">Capaian TKDN</th>
                    <th colspan="2" style="text-align:center">Komposisi</th>
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
                    <th style="text-align:center">KDN</th>
                    <th style="text-align:center">KLN</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                @foreach($dataVerif as $idx => $data)
                <tr>
                    <td>{{$data->jenis_produk}}</td>
                    <td>{{$data->tipe}}</td>
                    <td>{{ number_format($dataProduk[$idx]['rekap']['tkdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['manufaktur']['tkdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['manufaktur']['kdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['manufaktur']['kln'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['pengembangan']['tkdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['pengembangan']['kdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['pengembangan']['kln'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['software']['tkdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['software']['kdn'],2,",",".") }}</td>
                    <td>{{ number_format($dataProduk[$idx]['software']['kln'],2,",",".") }}</td>
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



        <p style="font-weight: bold;text-align:center"> PROFIL PERUSAHAAN</p>

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

        <div class="space"> </div>

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


        <div class="space"> </div>

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

        <div class="page_break"></div>

        <p>
            <b><u>IV. DATA PRODUK YANG DIVERIFIKASI</u></b>
        </p>

        @foreach($dataVerif as $idx => $data)
        <br>

        <table class="table1">
            <tbody style="vertical-align: top;">
                <tr>
                    <td style="width: 35%;border-right-style: none;"> Kelompok Barang / Jasa </td>
                    <td style="width: 3%;border-right-style: none;border-left-style: none;"> : </td>
                    <td style="width: 62%;border-left-style: none;">{{$data->nama_kelompok}} </td>
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
                    <td style="border-right-style: none;"> Merek </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->merk}} </td>
                </tr>
            </tbody>
        </table>

        <div class="page_break"></div>

        @endforeach


        <p style="font-weight: bold;text-align:center"> LAPORAN VERIFIKASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</p>

        <div class="dspace"> </div>


        <p style="font-weight: bold;">I. LATAR BELAKANG</p>

        <p style="padding-left: 15px">
            Sesuai dengan Surat Persetujuan Penilaian TKDN dari Direktorat Jenderal Industri Logam, Mesin, Alat Transportasi dan Elektronika Kementrian Perindustrian Republik Indonesia nomor {{$dataVerif[0]->nomor_persetujuan}}
            dan Permohonan Verifikasi TKDN dari {{$profil[0]->nama_perusahaan}} perihal pekerjaan verifikasi capaian Tingkat Komponen Dalam Negeri (TKDN) untuk Barang/Jasa Produksi Dalam Negeri, PT. SUCOFINDO (Persero) telah melakukan verifikasi TKDN terhadap
            @if(@$profilLokal[0]->nama_perusahaan == @$profilPengembang[0]->nama_perusahaan)
            {{@$profilLokal[0]->nama_perusahaan}} sebagai pabrikan lokal dan pengembang.
            @else
            {{@$profilLokal[0]->nama_perusahaan}} sebagai pabrikan lokal dan {{@$profilPengembang[0]->nama_perusahaan}} sebagai pengembang.
            @endif
        </p>

        <div class="space"> </div>

        <p style="font-weight: bold;">II. TUJUAN</p>

        <p style="padding-left: 15px">
            Tujuan dari verifikasi capaian TKDN adalah sebagai berikut:
        </p>


        <ol>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Pemastian penggunaan produk dalam negeri terhadap penyediaan barang/jasa produk Smartphone, Komputer Genggam (Handheld) dan Komputer Tablet.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Mengetahui nilai capaian TKDN produk Smartphone, Komputer Genggam (Handheld) dan Komputer Tablet yang dihasilkan oleh perusahaan.</li>
        </ol>

        <p style="font-weight: bold;">III. DASAR HUKUM</p>

        <p style="padding-left: 15px;vertical-align: middle">
            {!! $laporan[0]->dasar_hukum !!}
        </p>

        <div class="space"> </div>

        <p style="font-weight: bold;">IV. METODOLOGI</p>

        <p style="padding-left: 15px;margin-top:2;margin-bottom:2"> a. <i>Desk Study</i></p>
        <p style="padding-left: 35px;margin-top:2;margin-bottom:2"> <i>Desk Study</i> merupakan metode yang dilakukan dengan menggunakan proses pengecekan terhadap literatur maupun dokumen tertulis. Proses yang dilakukan dengan metoda ini dapat dipertanggung jawabkan karena didukung oleh literatur ataupun dokumen tertulis.</p>
        <p style="padding-left: 15px;margin-top:2;margin-bottom:2"> b. Wawancara / <i>Interview</i></p>
        <p style="padding-left: 35px;margin-top:2;margin-bottom:2"> Proses wawancara merupakan proses lanjutan dari <i>Desk Study</i>, dimana wawancara dilakukan secara langsung dengan pihak yang memiliki kompetensi untuk memberikan penjelasan terhadap seluruh kegiatan yang diverifikasi. Dalam kegiatan verifikasi TKDN, proses wawancara menjadi suatu hal yang sangat penting karena dapat digali informasi-informasi yang tidak diperoleh dari dokumen tertulis maupun hasil pengamatan langsung di lapangan.</p>
        <p style="padding-left: 15px;margin-top:2;margin-bottom:2"> c. Verifikasi Lapangan</p>
        <p style="padding-left: 35px;margin-top:2;margin-bottom:2"> Proses verifikasi lapangan merupakan kegiatan kunjungan lapangan untuk melakukan pengamatan langsung di lapangan. Dengan menggunakan metoda ini, proses verifikasi yang sebelumnya hanya berdasarkan literatur dan dokumen tertulis menjadi lebih akurat karena didukung oleh hasil pengamatan langsung di lapangan.</p>
        <p style="padding-left: 15px;margin-top:2;margin-bottom:2"> d. Komparasi</p>
        <p style="padding-left: 35px;margin-top:2;margin-bottom:2"> Proses komparasi adalah metoda membandingkan hasil kegiatan verifikasi dengan referensi yang sudah ada untuk produk sejenis. Dengan menggunakan metoda ini, verifikator memiliki Baganan atau pemahaman yang lebih jelas mengenai objek yang akan diverifikasi. Disamping itu, diperoleh informasi yang lebih lengkap dari objek yang akan diperiksa, sehingga dapat dilakukan proses analisa terhadap hasil yang dilakukan.</p>
        <p style="padding-left: 15px;margin-top:2;margin-bottom:2"> e. Engineering Judgement </p>
        <p style="padding-left: 35px;margin-top:2;margin-bottom:2"> Dalam pelaksanaan kegiatan verifikasi, dimungkinkan terdapat data & dokumen yang kurang memadai untuk diolah menjadi informasi yang dibutuhkan, sehingga diperlukan pendekatan teknis yang dilakukan dengan menggunakan metoda <i>engineering judgement</i>. </p>
        <p style="padding-left: 35px;margin-top:2;margin-bottom:2"> Metode <i>engineering judgement</i> mengutamakan proses verifikasi dapat menggunakan data dan informasi sekunder lainnya yang dapat dipertanggungjawabkan.</p>

        <div class="space"> </div>

        <p style="font-weight: bold;">V. KRITERIA PENILAIAN TKDN</p>

        <ol type="a">
            <li style="text-align: justify;line-height:2;vertical-align:middle">Tingkat Komponen Dalam Negeri Manufaktur dihitung berdasarkan pembobotan terhadap material, tenaga kerja dan mesin produksi.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Tingkat Komponen Dalam Negeri Pengembangan dihitung berdasarkan pembobotan terhadap Lisensi, Firmware, Desain Industri, dan Desain Tata Letak.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Tingkat Komponen Dalam Negeri Aplikasi dihitung berdasarkan pembobotan terhadap Rancang Bangun, Hak Cipta, Tenaga Kerja, Sertifikasi Kompetensi dan Alat Kerja.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Pembobotan dalam penghitungan TKDN sebagaimana dimaksud berdasarkan tahapan proses</li><br>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Penentuan Komponen Dalam Negeri atau Komponen Luar Negeri berdasarkan kriteria : <br>
                <ul>
                    <li>Untuk Bahan (Material) berdasarkan negara asal barang (Country of Origin)</li>
                    <li>Untuk Tenaga kerja berdasarkan kewarganegaraan</li>
                    <li>Untuk Mesin Produksi berdasarkan penggunaan.</li>
                    <li>Untuk Lisensi berdasarkan kepemilikan.</li>
                    <li>Untuk Firmware, Desain Industri, Desain Tata Letak, Rancang Bangun, Hak Cipta, Tenaga Kerja, Sertifikasi Kompetensi, dan Alat Kerja berdasarkan tahapan proses.</li>
                </ul>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Penelusuran penilaian TKDN Manufaktur dilakukan sampai dengan produsen tingkat 2 (Layer 2).
            </li>


            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Manufaktur dilakukan dengan menggunakan perincian bobot perhitungan sebagai berikut: <br>
                <ul>
                    <li>Material <br>
                        <table class="table5" style="width: 500px;margin-left:10px;text-align:center">
                            <tr>
                                <th width="10%">No</th>
                                <th width="60%">Komponen Pengembangan</th>
                                <th width="30%">Bobot TKDN</th>
                            </tr>
                            <tr>
                                <td> 1 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Touch Display Module Component </td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td> 2 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Bonding (Full Lamination) </td>
                                <td>8%</td>
                            </tr>
                            <tr>
                                <td> 3 </td>
                                <td style="text-align: left;padding-left: 5px;"> Kamera Depan </td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td> 4 </td>
                                <td style="text-align: left;padding-left: 5px;"> Kamera Belakang </td>
                                <td>10%</td>
                            </tr>
                            <tr>
                                <td> 5 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Main and Sub Printed Circuit Board (PCB) Components </td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td> 6 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Printed Circuit Board (PCB) Assembly </td>
                                <td>8%</td>
                            </tr>
                            <tr>
                                <td> 7 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Enclosure Casing Assembly Set </td>
                                <td>10%</td>
                            </tr>
                            <tr>
                                <td> 8 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Flexible Connectror (FPC) </td>
                                <td>4%</td>
                            </tr>
                            <tr>
                                <td> 9 </td>
                                <td style="text-align: left;padding-left: 5px;"> Baterai </td>
                                <td>8%</td>
                            </tr>
                            <tr>
                                <td> 10 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Vibration Motor </td>
                                <td>3%</td>
                            </tr>
                            <tr>
                                <td> 11 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Speaker and Earpiece </td>
                                <td>3%</td>
                            </tr>
                            <tr>
                                <td> 12 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Interconnect Electrical Wire Assembly </td>
                                <td>3%</td>
                            </tr>
                            <tr>
                                <td> 13 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Earphone </td>
                                <td>4%</td>
                            </tr>
                            <tr>
                                <td> 14 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Charger </td>
                                <td>3%</td>
                            </tr>
                            <tr>
                                <td> 15 </td>
                                <td style="text-align: left;padding-left: 5px;font-style:italic"> Cable </td>
                                <td>3%</td>
                            </tr>
                            <tr>
                                <td> 16 </td>
                                <td style="text-align: left;padding-left: 5px;"> Pengemasan Produk (Packing) </td>
                                <td>3%</td>
                            </tr>

                        </table>
                    </li>
                    <div class="page_break"> </div>
                    <li>Tenaga Kerja<br>
                        <table class="table5" style="width: 500px;margin-left:10px;text-align:center">
                            <tr>
                                <th width="10%">No</th>
                                <th width="60%">Komponen Pengembangan</th>
                                <th width="30%">Bobot TKDN</th>
                            </tr>
                            <tr>
                                <td> 1 </td>
                                <td style="text-align: left;padding-left: 5px;"> Tenaga Kerja Perakitan</td>
                                <td>0,5%</td>
                            </tr>
                            <tr>
                                <td> 2 </td>
                                <td style="text-align: left;padding-left: 5px;"> Tenaga Kerja Pengujian</td>
                                <td>1%</td>
                            </tr>
                            <tr>
                                <td> 3 </td>
                                <td style="text-align: left;padding-left: 5px;"> Tenaga Kerja Pengemasan</td>
                                <td>0,5%</td>
                            </tr>
                        </table>
                    </li>
                    <li>Mesin Produksi <br>
                        <table class="table5" style="width: 500px;margin-left:10px;text-align:center">
                            <tr>
                                <th width="10%">No</th>
                                <th width="60%">Komponen Pengembangan</th>
                                <th width="30%">Bobot TKDN</th>
                            </tr>
                            <tr>
                                <td> 1 </td>
                                <td style="text-align: left;padding-left: 5px;"> Mesin Perakitan</td>
                                <td>0,5%</td>
                            </tr>
                            <tr>
                                <td> 2 </td>
                                <td style="text-align: left;padding-left: 5px;"> Mesin Pengujian</td>
                                <td>1%</td>
                            </tr>
                        </table>
                    </li>
                </ul>
            </li>

            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Pengembangan dilakukan dengan menggunakan perincian bobot perhitungan sebagai berikut:

                <table class="table5" style="width: 550px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="60%">Komponen Pengembangan</th>
                        <th width="30%">Bobot TKDN</th>
                    </tr>
                    <tr>
                        <th> 1 </th>
                        <th style="text-align: left;padding-left: 5px;"> Lisensi</th>
                        <td>10%</td>
                    </tr>
                    <tr>
                        <th> 2 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Firmware</th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> a. Pengembangan Sistem Operasi</td>
                        <td> 20%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> b. Pengembangan <i>Man Machine Interface</i></td>
                        <td> 10%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> c. <i>Injection Software</i> Aplikasi</td>
                        <td>5%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> d. <i>Testing & Debugging</i></td>
                        <td> 5%</td>
                    </tr>
                    <tr>
                        <th> 3 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Desain Industri</th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> a. Desain Produk (<i>Product Design</i>)</td>
                        <td> 10%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> b. Desain Mekanik (<i>Mechanical Design</i>)</td>
                        <td> 10%</td>
                    </tr>
                    <tr>
                        <th> 4 </th>
                        <th style="text-align: left;padding-left: 5px;" colspan="2"> Desain Tata Letak</th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> a. Diagaram Skematik</td>
                        <td> 10%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> b. Desain Papan Sirkuit (PCB)</td>
                        <td> 10%</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td style="text-align: left;padding-left: 5px;"> c. Pengujian dan Kalibrasi PCBA SMT (<i>Jig Test Development</i></td>
                        <td> 10%</td>
                    </tr>

                </table>
            </li>

            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Formulasi perhitungan TKDN produk Smartphone, Komputer Genggam (Handheld) dan Komputer Tablet terdiri dari 2 (dua) skema sebagai berikut : <br>
                <ul>
                    <li>TKDN Hardware <br>
                        % TKDN Hardware = <br>
                        <b>(70% x TKDN Manufaktur) + (20% x TKDN Pengembangan) + (10% x TKDN Aplikasi)</b>
                    </li>
                    <li>
                        TKDN Software <br>
                        % TKDN Software = <br>
                        <b>(10% x TKDN Manufaktur) + (20% x TKDN Pengembangan) + (70% x TKDN Aplikasi)</b>
                    </li>
            </li>
        </ol>

        <div class="space"> </div>

        <p style="font-weight: bold;"> VI. RUANG LINGKUP </p>
        <p style="padding-left: 15px">Pelaksanaan verifikasi capaian TKDN yang dilakukan PT. SUCOFINDO (Persero) meliputi :</p>
        <ol type="a">
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Melakukan verifikasi lapangan terhadap proses produksi produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Melakukan pemeriksaan dan verifikasi dokumen pendukung capaian TKDN terkait produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Melakukan penghitungan capaian TKDN produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Melakukan penyusunan laporan capaian TKDN produk yang diverifikasi.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Menyerahkan laporan hasil verifikasi capaian TKDN kepada Kementerian Perindustrian Republik Indonesia.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Verifikasi TKDN tidak meliputi penelaahan berkaitan dengan keabsahan dokumen-dokumen yang diberikan oleh perusahaan.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Data yang tidak disertai dokumen pendukung dinyatakan sebagai Komponen Luar Negeri.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Semua informasi yang tercantum dalam laporan penilaian TKDN ini adalah berdasarkan data dan dokumen yang diberikan oleh perusahaan sesuai dengan kondisi di lapangan
            </li>
        </ol>

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>

        <p>Rekapitulasi Penilaian TKDN Manufaktur</p>
        <table class="table3">
            <tbody style="vertical-align: top;">
                <tr>
                    <td>Penyedia Barang / Jasa</td>
                    <td>:</td>
                    <td>{{$profil[0]->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{@$alamat[0]->alamat}}</td>
                </tr>
                <tr>
                    <td>Diproduksi Oleh</td>
                    <td>:</td>
                    <td>{{$profilLokal[0]->nama}} </td>
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
                    <td>Merek</td>
                    <td>:</td>
                    <td>{{$dataVerif[0]->merk}} </td>
                </tr>
            </tbody>
        </table>
        <div class="space"> </div>
        <br>
        <?php $a = $data['manufaktur'] ?>
        <b>- Material</b>
        <table class="table4" style="text-align:center;font-size: 9pt;">
            <tr>
                <th>Kriteria Penilaian</th>
                <th>Deskripsi</th>
                <th>Bobot Maksimum</th>
                <th>Bobot</th>
                <th>Checklist</th>
                <th>KDN</th>
            </tr>
            <!--  1  Touch Display Module (TDM) -->
            <tr>
                <td rowspan="4" style="vertical-align: middle;text-align: left;">1 Touch Display Module (TDM)</td>
                <td style="text-align:left;">- Touch Display Module (TDM) produksi Luar Negeri</td>
                <td rowspan="4" style="vertical-align: middle;">12,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[1][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="4" style="vertical-align: middle;">{{number_format($a[1][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Touch Panel atau Cover Glass produksi Dalam Negeri</td>
                <td>6,00%</td>
                <td>
                    @if($a[2][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Display (layar tampilan) produksi Dalam Negeri</td>
                <td>6,00%</td>
                <td>
                    @if($a[3][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Touch Panel atau Cover Glass dan Display produksi Dalam Negeri</td>
                <td>12,00%</td>
                <td>
                    @if($a[4][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 2 Bonding (Lamination) -->
            <tr>
                <td rowspan="3" style="vertical-align: middle;text-align: left;">2 Bonding (Lamination)</td>
                <td style="text-align:left;">- Tidak Ada</td>
                <td rowspan="3" style="vertical-align: middle;">4,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[5][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="3" style="vertical-align: middle;">{{number_format($a[5][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Metode Air Gap</td>
                <td>2,00%</td>
                <td>
                    @if($a[6][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Metode Full Lamination</td>
                <td>4,00%</td>
                <td>
                    @if($a[7][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 3 Kamera Depan -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">3 Kamera Depan</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">5,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[8][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[8][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>5,00%</td>
                <td>
                    @if($a[9][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 4 Kamera Belakang -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">4 Kamera Belakang</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">10,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[10][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[10][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>10,00%</td>
                <td>
                    @if($a[11][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 5 Main and Sub PCB’s Components -->
            <tr>
                <td rowspan="4" style="vertical-align: middle;text-align: left;">5 Main and Sub PCB’s Components</td>
                <td style="text-align:left;">- Semua Komponen produksi Luar Negeri</td>
                <td rowspan="4" style="vertical-align: middle;">12,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[12][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="4" style="vertical-align: middle;">{{number_format($a[12][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- 1 – 4 Komponen produksi Dalam Negeri</td>
                <td>n/4 x 5%</td>
                <td>
                    @if($a[13][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Papan Sirkuit produksi Dalam Negeri</td>
                <td>6,00%</td>
                <td>
                    @if($a[14][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- 5 atau lebih Komponen Elektronik dan Non-Elektronik produksi Dalam Negeri</td>
                <td>6,00%</td>
                <td>
                    @if($a[15][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 6 PCB Assembly (Surface Mount Technology) -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">6 PCB Assembly (Surface Mount Technology)</td>
                <td style="text-align:left;">- Proses SMT di Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">8,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[16][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[16][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Proses SMT di Dalam Negeri</td>
                <td>8,00%</td>
                <td>
                    @if($a[17][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 7 Enclosure Casing Assembly Set -->
            <tr>
                <td rowspan="3" style="vertical-align: middle;text-align: left;">7 Enclosure Casing Assembly Set</td>
                <td style="text-align:left;">- Semua Komponen produksi Luar Negeri</td>
                <td rowspan="3" style="vertical-align: middle;">10,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[18][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="3" style="vertical-align: middle;">{{number_format($a[18][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Plastic Injection atau Metal Stamping Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[19][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Plastik Injection atau Metal Stamping </td>
                <td>10,00%</td>
                <td>
                    @if($a[20][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 8 Flexible Connector -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">8 Flexible Connector</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">4,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[21][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[21][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>4,00%</td>
                <td>
                    @if($a[22][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 9 Battery -->
            <tr>
                <td rowspan="3" style="vertical-align: middle;text-align: left;">9 Battery</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="3" style="vertical-align: middle;">8,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[23][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="3" style="vertical-align: middle;">{{number_format($a[23][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Pengemasan Battery Dalam Negeri</td>
                <td>4,00%</td>
                <td>
                    @if($a[24][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Cell dan Pengemasan Dalam Negeri</td>
                <td>8,00%</td>
                <td>
                    @if($a[25][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 10 Vibration Motor -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">10 Vibration Motor</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">3,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[26][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[26][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[27][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 11 Speaker and Earpiece -->
            <tr>
                <td rowspan="3" style="vertical-align: middle;text-align: left;">11 Speaker and Earpiece</td>
                <td style="text-align:left;">- Speaker dan Earpiece produksi Luar Negeri</td>
                <td rowspan="3" style="vertical-align: middle;">3,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[28][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="3" style="vertical-align: middle;">{{number_format($a[28][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Speaker atau Earpiece produksi Dalam Negeri</td>
                <td>2,00%</td>
                <td>
                    @if($a[29][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Speaker dan Earpiece produksi Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[30][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 12 Interconnect Electrical Wire Assembly -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">12 Interconnect Electrical Wire Assembly</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">3,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[31][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[31][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[32][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 13 Earphone -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">13 Earphone</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">4,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[33][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[33][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>4,00%</td>
                <td>
                    @if($a[34][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 14 Charger -->
            <tr>
                <td rowspan="3" style="vertical-align: middle;text-align: left;">14 Charger</td>
                <td style="text-align:left;">- Charger atau Adaptor produksi Luar Negeri</td>
                <td rowspan="3" style="vertical-align: middle;">3,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[35][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="3" style="vertical-align: middle;">{{number_format($a[35][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Hanya proses Perakitan Casing dan PCBA di Dalam Negeri</td>
                <td>1,50%</td>
                <td>
                    @if($a[36][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Perakitan Casing dan PCBA serta pembuatan PCB di Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[37][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 15 Kabel -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">15 Kabel</td>
                <td style="text-align:left;">- Produksi Luar Negeri</td>
                <td rowspan="2" style="vertical-align: middle;">3,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[38][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[38][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Produksi Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[39][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 16 Pengemasan (Packing) -->
            <tr>
                <td rowspan="3" style="vertical-align: middle;text-align: left;">16 Pengemasan (Packing)</td>
                <td style="text-align:left;">- Gift Box, Manual Book dan Labeling produksi Luar Negeri</td>
                <td rowspan="3" style="vertical-align: middle;">3,00%</td>
                <td>1,00%</td>
                <td>
                    @if($a[40][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="3" style="vertical-align: middle;">{{number_format($a[40][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Gift Box atau Manual Book dan Labeling produksi Dalam Negeri</td>
                <td>2,00%</td>
                <td>
                    @if($a[41][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">- Gift Box, Manual Book dan Labeling produksi Dalam Negeri</td>
                <td>3,00%</td>
                <td>
                    @if($a[42][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- TOTAL -->
            <tr>
                <th colspan="5">TOTAL KDN MATERIAL</th>
                <th>{{number_format($a[43][7]*100,2,',','.')}}</th>
            </tr>
        </table>
        <br>
        <div class="page_break"></div>
        <b>- Tenaga Kerja</b>
        <table class="table4" style="text-align:center;font-size: 9pt;">
            <tr>
                <th>Kriteria Penilaian</th>
                <th>Deskripsi</th>
                <th>Bobot Maksimum</th>
                <th>Bobot</th>
                <th>Checklist</th>
                <th>KDN</th>
            </tr>
            <!-- 1 Tenaga Kerja Perakitan -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">1 Tenaga Kerja Perakitan</td>
                <td style="text-align:left;">- Tidak Ada</td>
                <td rowspan="2" style="vertical-align: middle;">0,50%</td>
                <td>0,00%</td>
                <td>
                    @if($a[46][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[46][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Ada</td>
                <td>0,50%</td>
                <td>
                    @if($a[47][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 2 Tenaga Kerja Pengujian -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">2 Tenaga Kerja Pengujian</td>
                <td style="text-align:left;">- Tidak Ada</td>
                <td rowspan="2" style="vertical-align: middle;">1,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[48][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[48][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Ada</td>
                <td>1,00%</td>
                <td>
                    @if($a[49][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 3 Tenaga Kerja Pengemasan -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">3 Tenaga Kerja Pengemasan</td>
                <td style="text-align:left;">- Tidak Ada</td>
                <td rowspan="2" style="vertical-align: middle;">0,50%</td>
                <td>0,00%</td>
                <td>
                    @if($a[50][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[50][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Ada</td>
                <td>0,50%</td>
                <td>
                    @if($a[51][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- TOTAL -->
            <tr>
                <th colspan="5">TOTAL KDN TENAGA KERJA</th>
                <th>{{number_format($a[52][7]*100,2,',','.')}}%</th>
            </tr>
        </table>
        <br>
        <div class="space"> </div>
        <div class="space"> </div>
        <div class="space"> </div>
        <b>- Mesin Produksi</b>
        <table class="table4" style="text-align:center;font-size: 9pt;">
            <tr>
                <th>Kriteria Penilaian</th>
                <th>Deskripsi</th>
                <th>Bobot Maksimum</th>
                <th>Bobot</th>
                <th>Checklist</th>
                <th>KDN</th>
            </tr>
            <!-- 1 Mesin Perakitan -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">1 Mesin Perakitan</td>
                <td style="text-align:left;">- Tidak Ada</td>
                <td rowspan="2" style="vertical-align: middle;">1,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[55][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[55][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Ada</td>
                <td>1,00%</td>
                <td>
                    @if($a[56][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- 2 Mesin Pengujian -->
            <tr>
                <td rowspan="2" style="vertical-align: middle;text-align: left;">2 Mesin Pengujian</td>
                <td style="text-align:left;">- Tidak Ada</td>
                <td rowspan="2" style="vertical-align: middle;">2,00%</td>
                <td>0,00%</td>
                <td>
                    @if($a[57][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
                <td rowspan="2" style="vertical-align: middle;">{{number_format($a[57][7]*100,2,',','.')}}%</td>
            </tr>
            <tr>
                <td style="text-align:left;">- Ada</td>
                <td>2,00%</td>
                <td>
                    @if($a[58][8] == "true")
                    <input style="margin-left: 30px;" type="checkbox" checked>
                    @endif
                </td>
            </tr>
            <!-- TOTAL -->
            <tr>
                <th colspan="5">TOTAL KDN MESIN PRODUKSI</th>
                <th>{{number_format($a[59][7]*100,2,',','.')}}%</th>
            </tr>
        </table>
        <div class="space"> </div>
        <div class="space"> </div>
        <table class="table4" style="text-align:center;font-size: 9pt;">
            <tr>
                <th colspan="5">TOTAL TKDN MANUFAKTUR</th>
                <th>{{number_format($a[60][6]*100,2,',','.')}}%</th>
            </tr>
        </table>
        <p>Nilai TKDN Manufaktur = {{number_format($a[60][6]*100,2,',','.')}}% ( <i>{{ terbilang(number_format($a[60][6]*100,2,',','.')) }}</i> )</p>
        @endforeach

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>

        <p>Rekapitulasi Penilaian TKDN Pengembangan</p>
        <table class="table3">
            <tbody style="vertical-align: top;">
                <tr>
                    <td>Penyedia Barang / Jasa</td>
                    <td>:</td>
                    <td>{{$profil[0]->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{@$alamat[0]->alamat}}</td>
                </tr>
                <tr>
                    <td>Didesain Oleh</td>
                    <td>:</td>
                    <td>{{$profilPengembang[0]->nama_perusahaan}} </td>
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
                    <td>Merek</td>
                    <td>:</td>
                    <td>{{$dataVerif[0]->merk}} </td>
                </tr>
            </tbody>
        </table>
        <div class="space"> </div>
        <br>

        <table class="table4" style="text-align:center;font-size: 9pt;">
            <tr>
                <th>Variabel Pengembangan</th>
                <th>Bobot Maksimal</th>
                <th>KDN</th>
                <th>Keterangan</th>
            </tr>
            <?php $a = $data['pengembangan'] ?>
            <tr>
                <td colspan="4" style="background-color: #DADADA;text-align: left;">I. Lisensi</td>
            </tr>
            <tr>
                <td style="text-align:left">1. Lisensi (Izin penggunaan chipset)</td>
                <td>10,00%</td>
                <td>{{number_format($a[1][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td colspan="4" style="background-color: #DADADA;text-align: left;">II. Firmware</td>
            </tr>
            <tr>
                <td style="text-align:left">1. Pengembangan OS </td>
                <td>20,00%</td>
                <td>{{number_format($a[5][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align:left">2. Man Machine Interface</td>
                <td>10,00%</td>
                <td>{{number_format($a[6][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align:left">3. Injection Software Application </td>
                <td>5,00%</td>
                <td>{{number_format($a[7][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align:left">4. Testing & Debugging (Testing Machine)</td>
                <td>5,00%</td>
                <td>{{number_format($a[8][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td colspan="4" style="background-color: #DADADA;text-align: left;">III. Desain Industri</td>
            </tr>
            <tr>
                <td style="text-align:left">1. Desain Industri (Desain Produk)</td>
                <td>10,00%</td>
                <td>{{number_format($a[12][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align:left">2. Desain Industri (Desain Mekanik/Kerangka Dalam)</td>
                <td>10,00%</td>
                <td>{{number_format($a[13][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td colspan="4" style="background-color: #DADADA;text-align: left;">IV. Desain Tata Letak</td>
            </tr>
            <tr>
                <td style="text-align:left">1. Tata Letak (Schematic design)</td>
                <td>10,00%</td>
                <td>{{number_format($a[15][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align:left">2. PCBA Layout</td>
                <td>10,00%</td>
                <td>{{number_format($a[16][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align:left">3. PCBA SMT (Testing & Calibration Software)</td>
                <td>10,00%</td>
                <td>{{number_format($a[17][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
            <tr>
                <td>TOTAL TKDN PENGEMBANGAN</td>
                <td></td>
                <td>{{number_format($a[18][9]*100,2,',','.')}}%</td>
                <td>-</td>
            </tr>
        </table>
        <p>Nilai TKDN Pengembangan = {{number_format($a[18][9]*100,2,',','.')}}% ( <i>{{ terbilang(number_format($a[18][9]*100,2,',','.')) }}</i> )</p>
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