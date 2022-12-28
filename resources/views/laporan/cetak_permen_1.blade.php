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
            /*font-family: Arial, Helvetica, sans-serif;*/
            font-size: 9pt;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            font-family: "Arial Narrow", Arial, sans-serif;
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
            vertical-align: top;
            /*border: 1px solid black;*/
        }

        .table3 {
            border: 1px solid black;
            width: 100%;
        }

        .table3 td {
            vertical-align: top;
            /*border: 1px solid black;*/
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
            font-family: "Arial Narrow", Arial, sans-serif;
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
                    <img src="{{public_path('/img/logoidsurv1.png')}}" style="width:170px;">
                </td>
                @endif
                @if($tahunLaporan->tahun == '2021')
                <td style="padding-top:15px">
                    <img src="{{public_path('/img/logosci.png')}}" style="width:70px;float: right;">
                </td>
                @else
                <td style="padding-top:1px">
                    <img src="{{public_path('/img/scinew.png')}}" style="width:85px;float: right;">
                </td>
                @endif
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
        <!-- daftar isi -->
        <!-- 
            <script type="text/php">
                $GLOBALS['entity_page'][] =  $pdf->get_page_number();   
                $GLOBALS["entity_page_number"] = 1;     
                foreach ($GLOBALS['entity_page'] as $key => $val) {
                    $GLOBALS["entity_y"] = 88;
                    $GLOBALS["entity_val"]  = 0;
                    $GLOBALS["entity_per_page"] = 36;
                    if($val) {
                        $pdf->page_script('
                        if(isset($GLOBALS["entity_page"][$GLOBALS["entity_val"]])) {
                            if($PAGE_NUM == $GLOBALS["entity_page_number"]){
                                $x = 505;
                                $y = $GLOBALS["entity_y"];
                                $font = $fontMetrics->get_font("Open Sans", "Helvetica Neue", "Helvetica, Arial, sans-serif");

                                $pdf->text($x, $y, $GLOBALS["entity_page"][$GLOBALS["entity_val"]]."", $font, 7, array(0, 0, 0, 1));
                                $GLOBALS["entity_y"] = $GLOBALS["entity_y"] + 19;
                                $GLOBALS["entity_val"] = $GLOBALS["entity_val"] + 1;
                                if (($GLOBALS["entity_val"] + 1) % $GLOBALS["entity_per_page"] == 0 ) {
                                    $GLOBALS["entity_page_number"] = $GLOBALS["entity_page_number"] + 1;
                                    $GLOBALS["entity_y"] = 31;
                                }
                            }
                        }');
                    }
                }
            </script>
            <div class="page_break"></div> 
            -->

        <p style="text-align: center;"><b> RINGKASAN EKSEKUTIF</b></p>
        <div class="dspace"> </div>
        <p>
            {{$profil[0]->nama_perusahaan}} merupakan perusahaan dengan komposisi saham {{$profil[0]->saham_negeri}}% dimiliki oleh Warga Negara Indonesia dan {{$profil[0]->saham_luar_negeri}}% dimiliki oleh Warga Negara Asing,
            dengan akta pendirian perusahaan no. {{$profil[0]->akta_pendirian}} tanggal {{changeFormat($profil[0]->tanggal_akta)}} oleh Notaris {{$profil[0]->notaris}}
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
            Pelaksanaan Verifikasi TKDN dilakukan dimulai dengan kunjungan pabrik {{$profil[0]->nama_perusahaan}}
            pada tanggal {{changeFormat(@$surtug->tgl_surtug)}}
            @if(@$surtug->tgl_akhir_surtug != "" && @$surtug->tgl_akhir_surtug != @$surtug->tgl_surtug)
            sampai dengan {{changeFormat(@$surtug->tgl_akhir_surtug)}}
            @endif
            yang berlokasi di {{@$alamat[0]->alamat}}.
        </p>

        <div class="space"> </div>

        <p>
            Adapun hasil verifikasi terhadap produk {{$profil[0]->nama_perusahaan}} sebagaimana ditunjukan oleh tabel berikut:
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




        <div class="head">
            <h3> PROFIL PERUSAHAAN</h3>
        </div>

        <div class="dspace"> </div>

        <p>
            <b><u>I. UMUM</u></b>
        </p>

        <table class="table2" style="width: 100%;padding-right: 73.92px;">
            <tr>
                <td style="width:35%"></td>
                <td style="width:20%"></td>
                <td style="width:45%"></td>
            </tr>
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
                    <td style="border-right-style: none;"> Jenis Industri </td>
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
                    <td style="border-left-style: none;">
                        <?php
                        echo '(' . terbilang(number_format($data->capaian_tkdn, 2, ",", "")) . ')';
                        ?>
                    </td>
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
                    <td style="border-right-style: none;"> Kapasitas Produksi Ijin / Tahun</td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kapasitas_izin}} </td>
                </tr>
                <tr>
                    <td style="border-right-style: none;"> Kapasitas Produksi Sesuai VKI / Tahun</td>
                    <td style="border-right-style: none;border-left-style: none;"> : </td>
                    <td style="border-left-style: none;">{{$data->kapasitas_vki}} </td>
                </tr>
            </tbody>
        </table>

        <div class="page_break"> </div>

        @endforeach

        <p>
            <b><u>IV. PENERAPAN SISTEM MANAJEMEN DAN STANDARISASI</u></b>
        </p>

        <table class="table1" style="text-align:center;">
            <tr>
                <th> Jenis Standar</th>
                <th> No. Sertifikat</th>
                <th> Tanggal</th>
                <th> Badan Sertifikat</th>
            </tr>
            @if(!isset($perusahaan_standar[0]))
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
            @else
            @foreach($perusahaan_standar as $key => $value)
            <tr>
                <td> {{$value->jenis_standar}} </td>
                <td> {{$value->no_sertifikat}} </td>
                <td> {{changeFormat($value->tanggal)}} </td>
                <td> {{$value->badan_sertifikat}} </td>
            </tr>
            @endforeach
            @endif
        </table>

        <div class="page_break"></div>




        <p style="text-align: center;"><b> LAPORAN VERIFIKASI TINGKAT KOMPONEN DALAM NEGERI (TKDN)</b></p>

        <div class="dspace"> </div>

        <p><b> PENDAHULUAN </b></p>

        <div class="dspace"> </div>

        <p><b>I. LATAR BELAKANG</b></p>

        <p style="padding-left: 15px">
            Sesuai dengan Peraturan Menteri Perindustrian Republik Indonesia Nomor 02/M-IND/PER/2/2014 tentang Pedoman Peningkatan Penggunaan Produk Dalam Negeri Dalam Pengadaan Barang/Jasa Pemerintah.
            PT SUCOFINDO (PERSERO) melakukan verifikasi penilaian capaian Tingkat Komponen Dalam Negeri (TKDN) Barang/Jasa Produksi Dalam Negeri.
        </p>

        <div class="space"> </div>

        <p style="padding-left: 15px">
            Dalam hal ini PT SUCOFINDO (PERSERO) telah melakukan penilaian capaian Tingkat Komponen Dalam Negeri (TKDN) terhadap {{$profil[0]->nama_perusahaan}}
            pada tanggal {{changeFormat(@$surtug->tgl_surtug)}}
            @if(@$surtug->tgl_akhir_surtug != "" && @$surtug->tgl_akhir_surtug != @$surtug->tgl_surtug)
            sampai dengan {{changeFormat(@$surtug->tgl_akhir_surtug)}}
            @endif
            bertempat di alamat {{@$alamat[0]->alamat}} sebagai berikut :
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
                <td>@if (count($dataVerif) > 1)
                        Terlampir
                    @else
                         {{$dataVerif[0]->tipe}} 
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Spesifikasi</td>
                <td> : </td>
                <td>@if (count($dataVerif) > 1)
                        Terlampir
                    @else
                         {{$dataVerif[0]->spesifikasi}} 
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding-right:50px"> Merek</td>
                <td> : </td>
                <td> {{$dataVerif[0]->merk}} </td>
            </tr>

        </table>

        <div class="space"> </div>

        <p><b> II. TUJUAN </b></p>

        <p style="padding-left: 15px">
            Verifikasi TKDN bertujuan untuk memperoleh capaian besaran komponen dalam negeri terhadap produk yang
            diproduksi oleh {{$profil[0]->nama_perusahaan}}, dengan lingkup kegiatan verifikasi adalah sebagai berikut :
        </p>

        <div class="space"> </div>

        <ul>
            <li>
                Verifikasi Komponen - Komponen Biaya
            </li>
        </ul>
        <p style="padding-left: 45px">
            Verifikasi komponen - komponen biaya dilakukan dengan cara menelaah dokumen-dokumen pengeluaran biaya
            untuk proses produksi yang diberikan oleh layer 1 dan layer 2. Dokumen pengeluaran biaya dimaksud antara lain
            Invoice, Kwitansi, Rekapitulasi Gaji, Daftar Aktiva Perusahaan dan bukti pengeluaran biaya tidak langsung pabrik
            (factory overhead).
        </p>
        <ul>
            <li>
                Verifikasi Fisik </p>
            </li>
        </ul>
        <p style="padding-left: 45px">
            Verifikasi fisik ini dilakukan dengan mengunjungi lokasi pabrik untuk mengetahui bahwa proses produksi benar -
            benar dilakukan oleh perusahaan. Adapun verifikasi ini dilakukan sebagai berikut :
        </p>

        <ol style="display: block;
                      list-style-type: decimal;
                      margin-top: 1em;
                      margin-bottom: 1em;
                      margin-left: 45px;
                      margin-right: 0;
                      padding-left: 40px;">
            <li style="margin-bottom:1em"> Verifikasi proses produksi {{$dataVerif[0]->jenis_produk}}</li>
            <li style="margin-bottom:1em"> Menyesuaikan dokumen Mapping Proses Produksi dengan kondisi sebenarnya di pabrik</li>
            <li style="margin-bottom:1em"> Verifikasi mesin-mesin yang dipakai produksi </li>
            <li style="margin-bottom:1em"> Verifikasi bahan baku yang dipakai di pabrik</li>
            <li style="margin-bottom:1em"> Verifikasi jumlah karyawan bagian produksi</li>
        </ol>
        <ul>
            <li>
                Membuat Laporan
            </li>
        </ul>
        <p style="padding-left: 45px">
            Membuat laporan verifikasi TKDN yang berisi evaluasi capain TKDN, analisa dan rekomendasi jika memungkinkan.
            Laporan hasil verifikasi capaian TKDN selanjutnya disampaikan ke Kementerian Perindustrian, untuk dievaluasi dan
            ditandasahkan.
        </p>
        <div class="space"> </div>

        <p><b> III. DASAR HUKUM </b></p>

        {!! $laporan[0]->dasar_hukum !!}

        <div class="space"> </div>

        <p><b> IV. METODOLOGI </b></p>

        <ul style="text-align:justify;">
            <li style="margin-bottom:1em;line-height: 1.6;">Tingkat Komponen Dalam Negeri untuk barang dihitung berdasarkan perbandingan antara harga barang jadi dikurangi harga komponen luar negeri terhadap harga barang jadi </li>
            <li style="margin-bottom:1em;line-height: 1.6;">Harga barang jadi sebagaimana dimaksud adalah biaya produksi yang dikeluarkan untuk memproduksi barang</li>


            <li style="margin-bottom:1em;line-height: 1.6;">Penentuan Komponen Dalam Negeri atau Komponen Luar Negeri berdasarkan kriteria</li>
            <ul>
                <li style="margin-bottom:1em;line-height: 1.6;">Untuk Bahan (Material) berdasarkan Negara Asal Barang (Country of Origin) </li>
                <li style="margin-bottom:1em;line-height: 1.6;">Untuk Tenaga kerja berdasarkan Kewarganegaraan </li>
                <li style="margin-bottom:1em;line-height: 1.6;">Untuk Alat Kerja/Fasilitas berdasarkan Kepemilikan dan Negara asal </li>
            </ul>
            <li style="margin-bottom:1em;line-height: 1.6;">Penelusuran penilaian TKDN barang dilakukan sampai dengan produsen tingkat 2 (Layer 2). </li>
        </ul>
        <p style="padding-left: 15px">
            Formulasi perhitungan TKDN Barang adalah : <br>
            % TKDN Barang = <u>Biaya Produksi Total - Biaya Produksi Komponen Luar Negeri </u> x 100% <br>
        </p>

        <p style="padding-left: 250px">Biaya Produksi Total</p>

        <div class="page_break"> </div>

        <p><b> V. BATASAN </b></p>

        <p style="padding-left: 15px">Pelaksanaan verifikasi capaian TKDN yang dilakukan PT SUCOFINDO (PERSERO) dibatasi hal-hal sebagai berikut</p>

        <ul>
            <li style="margin-bottom:1em;line-height: 1.6;">Semua pernyataan dan data yang tercantum dalam laporan penilaian TKDN ini adalah benar adanya sesuai dengan pengetahuan dan itikad baik dari PT SUCOFINDO (PERSERO). </li>
            <li style="margin-bottom:1em;line-height: 1.6;">PT SUCOFINDO (PERSERO) tidak melakukan penilaian kewajaran terhadap biaya, jumlah dan harga </li>
            <li style="margin-bottom:1em;line-height: 1.6;">Verifikasi klasifikasi biaya, jumlah dan harga didasarkan pada dokumen pendukung yang diserahkan oleh penyedia barang/jasa. </li>
            <li style="margin-bottom:1em;line-height: 1.6;">Beberapa dokumen-dokumen yang telah diverifikasi karena bersifat sangat rahasia, maka proses penyimpanannya dilakukan oleh penyedia barang/jasa </li>
            <li style="margin-bottom:1em;line-height: 1.6;">PT SUCOFINDO (PERSERO) tidak melakukan penelaahan berkaitan dengan keabsahan dokumen-dokumen yang diberikan oleh penyedia barang/jasa. </li>
            <li style="margin-bottom:1em;line-height: 1.6;">Data yang tidak disertai dokumen pendukung dinyatakan sebagai Komponen Luar Negeri </li>
        </ul>

        <p><b> VI. PENELAAHAN DOKUMEN </b></p>

        <p style="padding-left: 15px">Berdasarkan hasil penelaahan dokumen yang dilakukan oleh verifikator TKDN diperoleh hal-hal berikut ini :</p>

        <ul>
            <li style="margin-bottom:1em;line-height: 1.6;">Komposisi Saham</li>
            <ul>
                <li style="margin-bottom:1em;line-height: 1.6;">Saham Milik Dalam Negeri : {{$profil[0]->saham_negeri}} % </li>
                <li style="margin-bottom:1em;line-height: 1.6;">Saham Milik Luar Negeri : {{$profil[0]->saham_luar_negeri}} % </li>
            </ul>
            <li style="margin-bottom:1em;line-height: 1.6;">Ijin Usaha Industri diterbitkan oleh {{$profil[0]->penerbit_ijin}} dengan nomor {{$profil[0]->ijin_usaha}} </li>

            @if(@$penugasan[0]->check_self == "on")
            <li style="margin-bottom:1em;line-height: 1.6;">Nilai {{@$penugasan[0]->nilai_self}} % TKDN yang dinyatakan sendiri (Self Assessment) </li>
            @else
            <li style="margin-bottom:1em;line-height: 1.6;">Nilai % TKDN yang dinyatakan sendiri (Self Assessment) tidak ada </li>
            @endif

            <li style="margin-bottom:1em;line-height: 1.6;"> Pemasok bahan baku (layer 2) sebanyak {{@$penugasan[0]->jml_vendor}} perusahaan dengan {{@$penugasan[0]->jml_bahan_baku}} produk. </li>

            <li style="margin-bottom:1em;line-height: 1.6;">Dokumen pendukung terdiri dari Invoice, Faktur Pajak, Kwitansi, Flow chart produksi, Bill of Material (BOM), Slip Gaji, Kartu Tanda Penduduk, Struktur Organisasi Perusahaan dan bukti biaya factory overhead. </li>
            <li style="margin-bottom:1em;line-height: 1.6;">Foto mesin, bahan baku dan produk jadi terlampir.</li>
        </ul>

        @foreach($dataProduk as $idx => $data)

        <div class="page_break"></div>

        <p>Formulir 1.9 : Rekapitulasi Penilaian TKDN Barang</p>
        <table class="table3">
            <tr>
                <td>Penyedia Barang / Jasa</td>
                <td>: {{$profil[0]->nama_perusahaan}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>
                    <table style="padding: 0px">
                        <tr>
                            <td style="vertical-align: top;padding: 0px;">:</td>
                            <td style="vertical-align: top;padding: 0px;">{{@$alamat[0]->alamat}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Hasil Produksi</td>
                <td>: {{$dataVerif[$idx]->bidang_usaha}}</td>
            </tr>
            <tr>
                <td>Jenis Produk</td>
                <td>: {{$dataVerif[$idx]->jenis_produk}} </td>
            </tr>
            <tr>
                <td>Spesifikasi</td>
                <td>: {{$dataVerif[$idx]->spesifikasi}} </td>
            </tr>
            <tr>
                <td>Standar Produk</td>
                <td>: {{$dataVerif[$idx]->standar_produk}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:right"><b>Produk {{$idx+1}}</b></td>
            </tr>
        </table>

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
                $a = $data['dataExcel'];
                $view = '';
                $align = '';
                $totalBiayaTotal = $a[14][6];
                for ($i = 3; $i < count($a); $i++) { ?>
                    <tr>
                        @if((strpos($a[$i][2], "Bahan (material) Langsung") !== false) || (strpos($a[$i][2], "Tenaga kerja Langsung") !== false) || (strpos($a[$i][2], "Biaya Tidak Langsung Pabrik (Factory Overhead)") !== false))
                        <td colspan="5" style="background-color:#DADADA;">{{$a[$i][1]}} &nbsp; {{$a[$i][2]}}</td>
                        @else
                        @if($a[$i][1] == "Biaya Produksi")
                        <td><b>{{$a[$i][1]}}</b></td>
                        <?php $nilai_tkdn = $a[$i][7]; ?>
                        @else
                        <td>{{$a[$i][1]}} &nbsp; {{$a[$i][2]}}</td>
                        @endif
                        <?php
                        if ($a[$i][4] != null) {
                            $a[$i][4] = number_format(($a[$i][4] / $a[$i][6] * 100), 2, ",", ".");
                        } else {
                            $a[$i][4] = "-";
                        }
                        if ($a[$i][5] != null) {
                            $a[$i][5] = number_format(($a[$i][5] / $a[$i][6] * 100), 2, ",", ".");
                        } else {
                            $a[$i][5] = "-";
                        }
                        if ($a[$i][6] != null) {
                            if ($a[$i][6] == "0") {
                                $a[$i][6] = '-';
                            } else {
                                $a[$i][6] = number_format(($a[$i][6] / $totalBiayaTotal * 100), 2, ",", ".");
                            }
                        } else {
                            $a[$i][6] = "-";
                        }
                        if ($a[$i][7] !== null) {
                            $a[$i][7] = number_format($a[$i][7], 2, ",", ".");
                        }
                        ?>
                        <td style="text-align:center">{{ $a[$i][4] }}</td>
                        <td style="text-align:center">{{ $a[$i][5] }}</td>
                        <td style="text-align:center">{{ $a[$i][6] }}</td>
                        <td style="text-align:center">{{ $a[$i][7] }}</td>
                        @endif
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <p>Nilai TKDN Produk = {{ number_format($nilai_tkdn,2,",",".") }} %</p>
        <p><i>Dengan huruf ( {{ terbilang(number_format($nilai_tkdn,2,",",".")) }})</i></p>
        <p><i>Besar nilai TKDN diatas telah diverifikasi oleh PT SUCOFINDO (PERSERO) sesuai dengan ketentuan yang berlaku</i></p>

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
            $temp .= konversi($var - 10) . " Belas";
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
