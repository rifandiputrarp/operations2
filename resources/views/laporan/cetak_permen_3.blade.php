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

        .table2 td {
            padding: 2px;
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
            {{$profil[0]->nama_perusahaan}} merupakan perusahaan dengan komposisi saham {{$profil[0]->saham_negeri}}% dimiliki oleh Warga Negara Indonesia dan {{$profil[0]->saham_luar_negeri}}% dimiliki oleh Warga Negara Asing,
            dengan akta pendirian perusahaan no. {{$profil[0]->akta_pendirian}} tanggal {{changeFormat($profil[0]->tanggal_akta)}} oleh {{$profil[0]->notaris}}
            dan Izin Usaha No. {{$profil[0]->ijin_usaha}} yang diterbitkan oleh {{$profil[0]->penerbit_ijin}} pada tanggal {{changeFormat($profil[0]->tanggal_terbit_ijin)}}.
        </p>

        <div class="space"> </div>

        <p>
            Verifikasi TKDN dimulai dengan kunjungan pabrik {{$profil[0]->nama_perusahaan}}
            pada tanggal {{changeFormat(@$surtug->tgl_surtug)}}
            @if(@$surtug->tgl_akhir_surtug != "" && @$surtug->tgl_akhir_surtug != @$surtug->tgl_surtug)
            sampai dengan {{changeFormat(@$surtug->tgl_akhir_surtug)}}
            @endif
            yang berlokasi di {{@$alamat[0]->alamat}}.
        </p>

        <div class="space"> </div>

        <p>
            Adapun hasil verifikasi terhadap produk {{$profil[0]->nama_perusahaan}} sebagaimana ditunjukkan dalam tabel berikut :
        </p>

        <table class="table1" style="text-align: center;">
            <thead>
                <tr>
                    <th style="width:1%"> No </th>
                    <th> Bidang Usaha / Jenis Industri </th>
                    <th> Kategori Produk </th>
                    <th> Bentuk Sediaan </th>
                    <th> Kemasan </th>
                    <th> Nama Obat </th>
                    <th style="width: 13%">Capaian TKDN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataVerif as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->nama_kelompok}}</td>
                    <td>{{$value->jenis_produk}}</td>
                    <td>{{$value->tipe}}</td>
                    <td>{{$value->spesifikasi}}</td>
                    <td>{{$value->merk}}</td>
                    <td>{{$value->capaian_tkdn}}%</td>
                </tr>
                @endforeach
            </tbody>


        </table>

        <p>
            <b>PT. SUCOFINDO (Persero) </b> <br>
            <b>SBU Perdagangan, Industri dan Kelautan </b> <br>
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
            <b><u>I. UMUM</u></b>
        </p>

        <table class="table2">
            <tr>
                <td>a. Nama Perusahaan</td>
                <td colspan="2">: {{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td colspan="3">b. Alamat</td>
            </tr>
            <tr>
                <td style="padding-left:45px !important;">i. Kantor Pusat </td>
                <td colspan="2" style="padding-top:-20px">
                    <table>
                        <tr>
                            <td>:</td>
                            <td>{{@$alamat_pusat[0]->alamat}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kelurahan</td>
                <td>: {{@$alamat_pusat[0]->kelurahan}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kecamatan</td>
                <td>: {{@$alamat_pusat[0]->kecamatan}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kab / Kota</td>
                <td>: {{@$alamat_pusat[0]->kabupaten}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Provinsi</td>
                <td>: {{@$alamat_pusat[0]->provinsi}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kode Pos</td>
                <td>: {{@$alamat_pusat[0]->kode_pos}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Telepon</td>
                <td>: {{@$alamat_pusat[0]->telepon}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Fax</td>
                <td>: {{@$alamat_pusat[0]->fax}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Email</td>
                <td>: {{@$alamat_pusat[0]->email}}</td>
            </tr>

            <tr>
                <td style="padding-top:20px"></td>
            </tr>

            <tr>
                <td style="padding:0 45px !important;">ii. Pabrik</td>
                <td colspan="2">
                    <table>
                        <tr>
                            <td>:</td>
                            <td>{{@$alamat[0]->alamat}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kelurahan</td>
                <td>: {{@$alamat[0]->kelurahan}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kecamatan</td>
                <td>: {{@$alamat[0]->kecamatan}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kab / Kota</td>
                <td>: {{@$alamat[0]->kabupaten}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Provinsi</td>
                <td>: {{@$alamat[0]->provinsi}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Kode Pos</td>
                <td>: {{@$alamat[0]->kode_pos}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Telepon</td>
                <td>: {{@$alamat[0]->telepon}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Fax</td>
                <td>: {{@$alamat[0]->fax}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:11px !important;">Email</td>
                <td>: {{@$alamat[0]->email}}</td>
            </tr>

            <tr>
                <td style="padding-top:20px"></td>
            </tr>

            <tr>
                <td>c. Status Perusahaan</td>
                <td colspan="2"> : {{$profil[0]->status}}</td>
            </tr>
            <tr>
                <td>d. Pejabat Penghubung</td>
                <td colspan="2">: {{$profil[0]->pejabat}} </td>
            </tr>
            <tr>
                <td>e. Jabatan</td>
                <td colspan="2"> : {{$profil[0]->jabatan}}</td>
            </tr>
        </table>

        <div class="dspace"> </div>

        <p>
            <b><u>II. ASPEK LEGAL</u></b>
        </p>

        <table class="table2">
            <tr>
                <td style="padding: 0 36px 0 0">a. Akta Pendirian</td>
                <td>: No. {{$profil[0]->akta_pendirian}} Tanggal {{changeFormat($profil[0]->tanggal_akta)}} Nama Notaris {{$profil[0]->notaris}}</td>
            </tr>
            <tr>
                <td>b. NPWP</td>
                <td>: {{$profil[0]->npwp}}</td>
            </tr>
            @if($profil[0]->ijin_usaha != "")
            <tr>
                <td>c. Ijin Usaha</td>
                <td>: {{$profil[0]->ijin_usaha}} </td>
            </tr>
            @elseif($profil[0]->nib != "")
            <tr>
                <td>c. Nomor Izin Berusaha</td>
                <td>: {{$profil[0]->nib}} </td>
            </tr>
            @endif
        </table>

        <div class="page_break"></div>


        <p>
            <b><u>III. DATA PRODUK YANG DIVERIFIKASI</u></b>
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
                    <td style="border-right-style: none;"> Bidang Usaha </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->bidang_usaha}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kategori Produk </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->jenis_produk}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kode HS </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kode_hs}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Bentuk Sediaan </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->tipe}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kemasan </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->spesifikasi}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Nama Obat </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->merk}}</td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Nilai TKDN </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->capaian_tkdn}} % </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Terbilang </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{terbilang(number_format($data->capaian_tkdn,2,",",".")) }} </td>
                </tr>

                <tr>
                    <td style="border-right-style: none;"> Nomor Ijin Edar (NIE) </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->nie}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Standar Produk </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->standar_produk}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kapasitas Produksi Izin </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kapasitas_izin}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kapasitas Produksi Sesuai VKI </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kapasitas_vki}} </td>
                </tr>
            </tbody>
        </table>

        <div class="dspace"></div>

        @endforeach

        <div class="page_break"></div>

        <p style="font-weight: bold;text-align:center"> LAPORAN VERIFIKASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</p>

        <div class="dspace"> </div>


        <p style="font-weight:bold">I. LATAR BELAKANG</p>

        <p style="padding-left: 15px">
            Sesuai dengan Peraturan Menteri Perindustrian Republik Indonesia Nomor 03/M-IND/PER/1/2014 tentang Pedoman Peningkatan Produk Dalam Negeri dalam Pengadaan Barang/Jasa Pemerintah yang Tidak Dibiayai dari Anggaran Pendapatan dan Belanja Negara / Anggaran Pendapatan dan Belanja Daerah
            dan Surat Persetujuan Penilaian TKDN dari Kementerian Perindustrian No. {{$dataVerif[0]->nomor_persetujuan}}
            dan Permohonan Verifikasi TKDN {{@$profil[0]->nama_perusahaan}}, PT. SUCOFINDO (Persero) melakukan verifikasi penilaian capaian Tingkat Komponen Dalam Negeri (TKDN) Barang/Jasa Produksi Dalam Negeri.
        </p>

        <div class="space"> </div>

        <p style="padding-left: 15px">
            Dalam hal ini PT SUCOFINDO (PERSERO) telah melakukan penilaian capaian Tingkat Komponen Dalam Negeri (TKDN) terhadap {{$profil[0]->nama_perusahaan}}
            pada tanggal {{changeFormat(@$surtug->tgl_surtug)}}
            @if(@$surtug->tgl_akhir_surtug != "" && @$surtug->tgl_akhir_surtug != @$surtug->tgl_surtug)
            sampai dengan {{changeFormat(@$surtug->tgl_akhir_surtug)}}
            @endif
            bertempat di Pabrik di alamat {{@$alamat[0]->alamat}} dengan rincian produk sebagai berikut
        </p>

        <div class="space"> </div>

        <table class="table2" style="margin-left: 10px">
            <tr>
                <td style="padding-right:50px"> Kelompok Barang/Jasa</td>
                <td> : </td>
                <td> {{$dataVerif[0]->nama_kelompok}} </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Bidang Usaha</td>
                <td> : </td>
                <td> {{$dataVerif[0]->bidang_usaha}} </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Jenis Produk</td>
                <td> : </td>
                <td> {{$dataVerif[0]->jenis_produk}} </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Tipe</td>
                <td> : </td>
                <td> Terlampir </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Spesifikasi</td>
                <td> : </td>
                <td> Terlampir </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Merek</td>
                <td> : </td>
                <td> Terlampir </td>
            </tr>

        </table>

        <div class="space"> </div>

        <h3> II. TUJUAN </h3>

        <p style="padding-left: 15px">
            Tujuan dari verifikasi capaian TKDN adalah sebagai berikut:
        </p>

        <ol>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Pemastian penggunaan produk dalam negeri terhadap penyediaan barang/jasa produk Farmasi.</li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">Mengetahui nilai capaian TKDN produk Farmasi yang dihasilkan oleh perusahaan.</li>
        </ol>

        <div class="space"> </div>

        <p style="font-weight: bold;"> III. DASAR HUKUM </p>

        <p style="padding-left: 15px;vertical-align: middle">
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

        <p style="font-weight: bold;">V. KRITERIA PENILAIAN TKDN</p>

        <ol type="a">
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri dihitung berdasarkan pembobotan terhadap Kandungan Bahan Baku, Proses Penelitian dan Pengembangan, Proses Produksi dan Proses Pengemasan.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Pembobotan dalam penghitungan TKDN sebagaimana dimaksud berdasarkan tahapan proses.
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Penentuan Komponen Dalam Negeri atau Komponen Luar Negeri berdasarkan kriteria :
                <ul>
                    <li>Untuk Bahan (Material) berdasarkan negara asal barang (Country of Origin)</li>
                    <li>Untuk Tenaga kerja berdasarkan kewarganegaraan </li>
                    <li>Untuk Mesin Produksi berdasarkan kepemilikan.</li>
                </ul>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Penelusuran penilaian Kandungan Bahan Baku dilakukan sampai dengan produsen tingkat 2 (Layer 2).
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Produk Farmasi dilakukan dengan menggunakan pembobotan perhitungan sebagai berikut:

                <table class="table5" style="width: 500px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="70%">Faktor Penentuan Bobot Perusahaan</th>
                        <th width="30%">Bobot Maksimum</th>
                    </tr>
                    <tr>
                        <td>I</td>
                        <td style="text-align: left;padding-left: 5px">Kandungan Bahan Baku</td>
                        <td>50,00%</td>
                    </tr>
                    <tr>
                        <td>II</td>
                        <td style="text-align: left;padding-left: 5px">Proses Penelitian dan Pengembangan</td>
                        <td>30,00%</td>
                    </tr>
                    <tr>
                        <td>III</td>
                        <td style="text-align: left;padding-left: 5px">Proses Produksi</td>
                        <td>15,00%</td>
                    </tr>
                    <tr>
                        <td>IV</td>
                        <td style="text-align: left;padding-left: 5px">Proses Pengemasan</td>
                        <td>5,00%</td>
                    </tr>
                </table>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Produk Farmasi dilakukan dengan menggunakan pembobotan perhitungan sebagai berikut:

                <table class="table5" style="width: 500px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="70%">Uraian</th>
                        <th width="30%">Bobot</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px">Bahan Baku Aktif</td>
                        <td>65,00%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px">Bahan Baku Tambahan</td>
                        <td>35,00%</td>
                    </tr>
                </table>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Proses Penelitian dan Pengembangan dilakukan dengan menggunakan perincian bobot perhitungan sebagai berikut:

                <table class="table5" style="width: 500px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="70%">Uraian</th>
                        <th width="30%">Bobot</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px">Pengembangan Obat Baru</td>
                        <td>25,00%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px">Uji Klinis</td>
                        <td>30,00%</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td style="text-align: left;padding-left: 5px">Formulasi</td>
                        <td>35,00%</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td style="text-align: left;padding-left: 5px">BA/BE</td>
                        <td>10,00%</td>
                    </tr>
                </table>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Proses Produksi dilakukan dengan menggunakan perincian bobot perhitungan sebagai berikut:

                <table class="table5" style="width: 500px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="70%">Uraian</th>
                        <th width="30%">Bobot</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px">Pencampuran</td>
                        <td>60,00%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px"><i>Dosage Forming</i></td>
                        <td>40,00%</td>
                    </tr>
                </table>
                <div class="page_break"></div>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Tingkat Komponen Dalam Negeri untuk Proses Pengemasan dilakukan dengan menggunakan perincian bobot perhitungan sebagai berikut:

                <table class="table5" style="width: 500px;margin-left:30px;text-align:center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="70%">Uraian</th>
                        <th width="30%">Bobot</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px"><i>Batch Release</i></td>
                        <td>50,00%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px">Pengemasan Primer</td>
                        <td>40,00%</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td style="text-align: left;padding-left: 5px">Pengemasan Sekunder</td>
                        <td>10,00%</td>
                    </tr>
                </table>
            </li>
            <li style="text-align: justify;line-height:2;vertical-align:middle">
                Formulasi perhitungan TKDN produk Farmasi adalah sebagai berikut :
                <ul>
                    <li>TKDN Produk Farmasi <br>% TKDN Produk Farmasi = <br> <b>(50% x TKDN Kandungan Bahan Baku) + (30% x TKDN Proses Penelitian dan Pengembangan) + (15% x TKDN Proses Produksi) + (5% x TKDN Proses Pengemasan)</b></li>
                </ul>
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
                Semua informasi yang tercantum dalam laporan penilaian TKDN ini adalah berdasarkan data dan dokumen yang diberikan oleh perusahaan sesuai dengan kondisi di lapangan.
            </li>
        </ol>

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>

        <p>Rekapitulasi Penilaian TKDN Produk Farmasi</p>
        <table class="table3">
            <tr>
                <td>Nama Perusahaan</td>
                <td>:</td>
                <td>{{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{@$alamat[0]->alamat}}</td>
            </tr>
            <tr>
                <td>Jenis Industri</td>
                <td>:</td>
                <td>{{$dataVerif[0]->nama_kelompok}} </td>
            </tr>
            <tr>
                <td>Kategori Produk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->jenis_produk}} </td>
            </tr>
            <tr>
                <td>Bentuk Sediaan</td>
                <td>:</td>
                <td>{{$dataVerif[0]->tipe}} </td>
            </tr>
            <tr>
                <td>Kemasan</td>
                <td>:</td>
                <td>{{$dataVerif[0]->spesifikasi}} </td>
            </tr>
            <tr>
                <td>Standar Produk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->standar_produk}} </td>
            </tr>
            <tr>
                <td>Sertifikat Produk</td>
                <td>:</td>
                <td>{{$dataVerif[0]->sertifikat_produk}} </td>
            </tr>
            <tr>
                <td>Nama Obat</td>
                <td>:</td>
                <td>{{$dataVerif[0]->merk}} </td>
            </tr>
        </table>

        <br>
        <table class="table4">
            <thead style="vertical-align:middle;text-align:center;background-color: #389fff;">
                <tr>
                    <th>No</th>
                    <th>Faktor Penentuan Bobot Perusahaan</th>
                    <th>Nilai Bobot Akhir</th>
                    <th>Bobot Maksimum</th>
                    <th>Sub Total Nilai TKDN</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php $a = $data['rekapitulasi']; ?>
                <tr>
                    <td style="text-align: left;font-weight: bold;">I</td>
                    <td style="text-align: left;font-weight: bold;;">Kandungan Bahan Baku</td>
                    <td>{{ number_format($a[0][4]*100,2,",",".") }}%</td>
                    <td style="font-weight: bold">{{ number_format($a[0][5]*100,2,",",".") }}%</td>
                    <td>{{ number_format($a[0][6]*100,2,",",".") }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left;font-weight: bold;">II</td>
                    <td style="text-align: left;font-weight: bold;;">Proses Penelitian dan Pengembangan</td>
                    <td>{{ number_format($a[1][4]*100,2,",",".") }}%</td>
                    <td style="font-weight: bold">{{ number_format($a[1][5]*100,2,",",".") }}%</td>
                    <td>{{ number_format($a[1][6]*100,2,",",".") }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left;font-weight: bold;">III</td>
                    <td style="text-align: left;font-weight: bold;;">Proses Produksi</td>
                    <td>{{ number_format($a[2][4]*100,2,",",".") }}%</td>
                    <td style="font-weight: bold">{{ number_format($a[2][5]*100,2,",",".") }}%</td>
                    <td>{{ number_format($a[2][6]*100,2,",",".") }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left;font-weight: bold;">IV</td>
                    <td style="text-align: left;font-weight: bold;;">Proses Pengemasan</td>
                    <td>{{ number_format($a[3][4]*100,2,",",".") }}%</td>
                    <td style="font-weight: bold">{{ number_format($a[3][5]*100,2,",",".") }}%</td>
                    <td>{{ number_format($a[3][6]*100,2,",",".") }}%</td>
                </tr>
                <tr>
                    <td colspan="3" style="background-color: #389fff;"><b>Total Bobot</b></td>
                    <td><b>100,00%</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" style="background-color: #389fff;"><b>Total TKDN</b></td>
                    <td><b>{{ number_format($a[4][6]*100,2,",",".") }}%</b></td>
                </tr>
            </tbody>
        </table>
        <p>Nilai TKDN Produk Farmasi = {{ number_format($a[4][6]*100,2,",",".") }} <i>({{ terbilang(number_format($a[4][6]*100,2,",",".")) }})</i></p>
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