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

        <p style="text-align:center "><b> RINGKASAN EKSEKUTIF</b></p>

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
                    <th style="width:20%"> Bidang Usaha / Jenis Industri </th>
                    <th> Jenis Produk </th>
                    <th> Tipe </th>
                    <th> Spesifikasi </th>
                    <th> Standar Produk </th>
                    <th> Merek </th>
                    <th style="width: 13%"> Capaian TKDN </th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataVerif as $idx => $data)
                <tr>
                    <td>{{$idx+1}}</td>
                    <td>{{$data->bidang_usaha}}</td>
                    <td>{{$data->jenis_produk}}</td>
                    <td>{{$data->tipe}}</td>
                    <td>{{$data->spesifikasi}}</td>
                    <td>{{$data->standar_produk}}</td>
                    <td>{{$data->merk}}</td>
                    <td>{{$data->capaian_tkdn}} %</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>
            <b>
                PT. SUCOFINDO (Persero) <br>
                SBU Perdagangan, Industri dan Kelautan <br>
                Bagian Fasilitasi Kandungan Lokal,
            </b>
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


        <p style="text-align:center "><b> PROFIL PERUSAHAAN</b></p>


        <div class="dspace"> </div>

        <p>
            <b>I. UMUM</b>
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
            <b>II. ASPEK LEGAL</b>
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
            <b>III. DATA PRODUK YANG DIVERIFIKASI</b>
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
                    <td style="border-right-style: none;"> Jenis Produk </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->jenis_produk}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kode HS </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kode_hs}} </td>
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
                <tr>
                    <td style="border-right-style: none;"> Nilai TKDN </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->capaian_tkdn}} % </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Terbilang </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{terbilang(number_format($data->capaian_tkdn,2,",","."))}} </td>
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
                    <td style="border-right-style: none;"> Kapasitas Produksi Ijin </td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kapasitas_izin}} </td>
                </tr>
            </tbody>
        </table>

        <div class="page_break"></div>

        @endforeach

        <p style="text-align:center "><b> LAPORAN VERIFIKASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</b></p>

        <div class="dspace"> </div>

        <div class="dspace"> </div>

        <p><b>I. LATAR BELAKANG</b></p>

        <p style="padding-left: 15px">
            Sesuai dengan Peraturan Menteri Perindustrian Republik Indonesia Nomor 03/M-IND/PER/1/2014 tentang Pedoman Peningkatan Produk Dalam Negeri dalam Pengadaan Barang/Jasa Pemerintah yang Tidak Dibiayai dari Anggaran Pendapatan dan Belanja Negara / Anggaran Pendapatan dan Belanja Daerah
            dan Surat Persetujuan Penilaian TKDN dari Kementerian Perindustrian No. {{$dataVerif[0]->nomor_persetujuan}}
            dan Permohonan Verifikasi TKDN {{$profil[0]->nama_perusahaan}}, PT. SUCOFINDO (Persero) melakukan verifikasi penilaian capaian Tingkat Komponen Dalam Negeri (TKDN) Barang/Jasa Produksi Dalam Negeri.
        </p>

        <div class="space"> </div>

        <p style="padding-left: 15px">
            Dalam hal ini PT. SUCOFINDO (Persero) telah melakukan penilaian capaian Tingkat Komponen Dalam Negeri (TKDN) terhadap {{$profil[0]->nama_perusahaan}}
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

        <p><b> II. TUJUAN </b> </p>

        <p style="padding-left: 15px">
            Tujuan dari verifikasi capaian TKDN adalah sebagai berikut:
        </p>

        <div class="space"> </div>

        <p style="padding-left: 15px">
        <ol>
            <li style="text-align: justify;">Pemastian penggunaan produk dalam negeri terhadap penyediaan barang/jasa produk Modul Surya.</li>
            <li style="text-align: justify;">Mengetahui nilai capaian TKDN produk Modul Surya yang dihasilkan oleh perusahaan.</li>
        </ol>
        </p>

        <div class="space"> </div>

        <p><b> III. DASAR HUKUM </b></p>

        <p style="padding-left: 15px;vertical-align: middle">
            {!! $laporan[0]->dasar_hukum !!}
        </p>

        <div class="space"> </div>

        <p><b> IV. METODOLOGI </b></p>

        <p style="padding-left: 15px"> a. Desk Study</p>
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

        <p><b>V. KRITERIA PENILAIAN TKDN</b></p>

        <ol type="a">
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri dihitung berdasarkan pembobotan terhadap Kandungan Bahan Baku, Proses Penelitian dan Pengembangan, Proses Produksi dan Proses Pengemasan.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Pembobotan dalam penghitungan TKDN sebagaimana dimaksud berdasarkan tahapan proses.
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Penentuan Komponen Dalam Negeri atau Komponen Luar Negeri berdasarkan kriteria :
                <ul>
                    <li>Untuk Bahan (Material) berdasarkan negara asal barang (Country of Origin)</li>
                    <li>Untuk Tenaga kerja berdasarkan kewarganegaraan</li>
                    <li>Untuk Mesin Produksi berdasarkan kepemilikan.</li>
                </ul>
            </li>
            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Tingkat Komponen Dalam Negeri untuk Modul Surya dilakukan dengan menggunakan pembobotan
                perhitungan sebagai berikut:

                <table class="table5" style="width: 550px;margin-left:50px;text-align:center">
                    <tr style="background-color: #8EAADB">
                        <th width="10%">No</th>
                        <th width="70%">Faktor Penentuan Bobot Perusahaan</th>
                        <th width="20%">Bobot</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px">Material</td>
                        <td>91,00%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px">Tenaga Kerja</td>
                        <td>5,00%</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td style="text-align: left;padding-left: 5px">Mesin Produksi</td>
                        <td>4,00%</td>
                    </tr>
                </table>
                <br>
                Adapun perhitungan TKDN untuk material Modul Surya dilakukan berdasarkan rincian pembobotan dengan uraian sebagai berikut:

                <table class="table5" style="width: 550px;margin-left:50px;text-align:center">
                    <tr style="background-color: #8EAADB">
                        <th width="10%">No</th>
                        <th width="70%">Uraian</th>
                        <th width="20%">Bobot </th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px">Sel Surya</td>
                        <td>50,00%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px">Tempered Glass</td>
                        <td>12,00%</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td style="text-align: left;padding-left: 5px">PV Junction Box</td>
                        <td>8,00%</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td style="text-align: left;padding-left: 5px">Backsheet</td>
                        <td>4,00%</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td style="text-align: left;padding-left: 5px">Frame</td>
                        <td>9,00%</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td style="text-align: left;padding-left: 5px">Film Eva</td>
                        <td>4,00%</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td style="text-align: left;padding-left: 5px">PV Ribbon</td>
                        <td>2,00%</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td style="text-align: left;padding-left: 5px">Solar Silicon</td>
                        <td>2,00%</td>
                    </tr>
                </table>
                <br>
                Dan untuk perhitungan material Sel Surya dilakukan berdasarkan rincian pembobotan dengan uraian sebagai
                berikut :

                <table class="table5" style="width: 550px;margin-left:50px;text-align:center">
                    <tr style="background-color: #8EAADB">
                        <th width="10%">No</th>
                        <th width="70%">Uraian</th>
                        <th width="20%">Bobot </th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left;padding-left: 5px">Pengadaan Pasir Silika</td>
                        <td>2,50%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="text-align: left;padding-left: 5px">Pembuatan Silicon Metallurgical Grade</td>
                        <td>7,50%</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td style="text-align: left;padding-left: 5px">Pembuatan Silicon Solar </td>
                        <td>15,00%</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td style="text-align: left;padding-left: 5px">Pembuatan Ingot</td>
                        <td>5,00%</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td style="text-align: left;padding-left: 5px">Pembuatan Brick</td>
                        <td>2,50%</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td style="text-align: left;padding-left: 5px">Pembuatan Wafer</td>
                        <td>2,50%</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td style="text-align: left;padding-left: 5px">Pembuatan Blue Cell</td>
                        <td>7,50%</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td style="text-align: left;padding-left: 5px">Printing Cell</td>
                        <td>7,50%</td>
                    </tr>

                </table>
            </li>
        </ol>


        <div class="dspace"></div>

        <p><b> VI. RUANG LINGKUP </b></p>
        <p style="padding-left: 15px">Pelaksanaan verifikasi capaian TKDN yang dilakukan PT. SUCOFINDO (Persero) meliputi :</p>
        <p style="padding-left: 35px">

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
            </li>

            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Melakukan penyusunan laporan capaian TKDN produk yang diverifikasi.
            </li>
            </li>

            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Menyerahkan laporan hasil verifikasi capaian TKDN kepada Kementerian Perindustrian Republik Indonesia.
            </li>
            </li>

            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Verifikasi TKDN tidak meliputi penelaahan berkaitan dengan keabsahan dokumen-dokumen yang diberikan
                oleh perusahaan.
            </li>
            </li>

            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Data yang tidak disertai dokumen pendukung dinyatakan sebagai Komponen Luar Negeri.
            </li>
            </li>

            <li style="text-align: justify;line-height: 2;vertical-align: middle">
                Semua informasi yang tercantum dalam laporan penilaian TKDN ini adalah berdasarkan data dan dokumen
                yang diberikan oleh perusahaan sesuai dengan kondisi di lapangan.
            </li>
        </ol>

        <div class="page_break"></div>

        <p style="text-align: center;"><b>REKAPITULASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</b></p>

        <div class="space"></div>

        @foreach($dataProduk as $idx => $data)
        @if($idx != 0)
        <div class="page_break"></div>
        @endif

        <p>Rekapitulasi Penilaian TKDN Modul Surya</p>
        <table class="table3">
            <tbody style="vertical-align: top;">
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
                    <td>Merek</td>
                    <td>:</td>
                    <td>{{$dataVerif[0]->merk}} </td>
                </tr>
            </tbody>
        </table>

        <br>
        <table class="table4">
            <thead style="vertical-align:middle;text-align:center;background-color: #8EAADB;">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Komponen Modul Surya</th>
                    <th colspan="2">Kriteria</th>
                    <th rowspan="2">Bobot (%)</th>
                    <th rowspan="2">TKDN (%)</th>
                </tr>
                <tr>
                    <th>Dalam Negeri</th>
                    <th>Luar Negeri</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php $a = $data['formhitung']; ?>
                <tr>
                    <td colspan="6">{{$a[0][0]}}</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td colspan="5" style="text-align:left">Solar Cell</td>
                </tr>
                <tr>
                    <td rowspan="8"></td>
                    <td style="text-align:left">Pengadaan Pasir Silika</td>
                    @if($a[2][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[2][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[2][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Pembuatan Silicon Metallurgical Grade</td>
                    @if($a[3][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[3][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[3][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Pembuatan Silicon Solar Grade</td>
                    @if($a[4][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[4][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[4][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Pembuatan Ingot</td>
                    @if($a[5][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[5][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[5][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Pembuatan Brick</td>
                    @if($a[6][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[6][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[6][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Pembuatan Wafer</td>
                    @if($a[7][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[7][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[7][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Pembuatan Blue cell</td>
                    @if($a[8][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[8][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[8][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td style="text-align:left">Printing Cell</td>
                    @if($a[9][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[9][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[9][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td style="text-align:left">Tempered Glass</td>
                    @if($a[10][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[10][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[10][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td style="text-align:left"> PV Junction Box</td>
                    @if($a[11][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[11][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[11][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td style="text-align:left"> Backsheet</td>
                    @if($a[12][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[12][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[12][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td style="text-align:left"> Frame</td>
                    @if($a[13][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[13][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[13][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td style="text-align:left"> Film Eva</td>
                    @if($a[14][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[14][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[14][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td style="text-align:left"> PV Ribbon</td>
                    @if($a[15][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[15][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[15][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td style="text-align:left"> Solar Silicon</td>
                    @if($a[16][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[16][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[16][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td colspan="6">{{$a[17][0]}}</td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td style="text-align:left"> Tenaga Kerja Langsung</td>
                    @if($a[18][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[18][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[18][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <td colspan="6">{{$a[19][0]}}</td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td style="text-align:left"> Mesin Produksi</td>
                    @if($a[20][9] != "0")
                    <td>x</td>
                    <td></td>
                    @else
                    <td></td>
                    <td>x</td>
                    @endif
                    <td>{{number_format($a[20][8]*100,2,",",".")}}</td>
                    <td>{{number_format($a[20][9]*100,2,",",".")}}</td>
                </tr>
                <tr>
                    <th colspan="4" style="background-color: #8EAADB;">Total Bobot</th>
                    <th>100,00</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="5" style="background-color: #8EAADB;">Total Bobot</th>
                    <td>{{number_format($a[22][9]*100,2,",",".")}}</td>
                </tr>
            </tbody>
        </table>
        <p>Nilai TKDN Produk Modul Surya = {{number_format($a[22][9]*100,2,",",".")}}% (<i>{{ terbilang(number_format($a[22][9]*100,2,",",".")) }}</i>)</p>

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