<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Informasi Geografis Minimarket</title>

    <!-- Bootstrap & carbon -->
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.3/css/lightslider.min.css"/>
    {{-- <link rel="stylesheet" href="{{ asset('css/carbon.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div class="page-wrapper">

        <div class="content">

            <div id="app">

                <nav class="navbar navbar-expand-lg navbar-blue">
                    <div class="container-fluid p-0">
                        <div class="row" style="width: 100%">
                            <div class="col-lg-4">
                                <form class="d-flex form-search" @submit.prevent="">
                                    <div class="flex-grow-1 input-group">
                                        <input type="search" id="search-autocomplete" style="width: 60%">
                                        <div class="input-group-append" style="width: 40%">
                                            <select style="width: 100%" v-model="searchQuery.perusahaan">
                                                <option :value="null">Semua</option>
                                                <option v-for="perusahaan in daftarPerusahaan">@{{ perusahaan.nama }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="col-lg-8">
                                <div class="btn btn-outline-light mt-1 bdr" @click="clustering" v-if="status">
                                    Clustering
                                </div>

                                <div class="btn btn-outline-light mt-1 bdr ml-2" @click="tampilkanSemuaToko" v-if="markerYangDitampilkan < markers.length">
                                    Tampilkan Semua Toko
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid p-0 full-height">
                    {{-- Content --}}
                    <div class="row m-0 p-0 full-height">
                        <div class="col-lg-4 m-0 p-0 full-height">
                            <div id="tools">
                                <div class="card border-0 mb-0">

                                    <div class="card-body" v-if="status === 'search'">
                                        <div class="list-group search-result">
                                            <div @click.prevent="bukaDetailMinimarket($event, toko)" class="list-group-item border-0 mb-2" v-for="toko in daftarToko">
                                                <p class="text-blue"><b>@{{ toko.alamat }}</b></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <b>Transaksi dalam 7 hari terakhir</b>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-light-orange badge-pill badge-lg text-orange">
                                                            @{{ toko.jumlah_transaksi }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <template v-if="status === 'index'">
                                        <div class="p-3">
                                            <h1>Selamat Datang</h1>
                                            <h4>Sistem Informasi Geografis Minimarket</h4>

                                            <hr>

                                            <div v-if="fetchingData.status" class="alert alert-info border-0 mt-3">
                                                <b>Tunggu Sebentar</b><br>
                                                <span>Kami sedang mengambil data ...</span>

                                                <div class="progress mt-2" style="height: 10px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%" role="progressbar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <template v-if="status === 'detail'">
                                        <div class="p-3 d-flex bg-gray">
                                            <div>
                                                <h5 class="m-0">@{{ detailToko.get_perusahaan.nama }}</h5>
                                                <p class="p-0">@{{ detailToko.alamat }}</p>

                                                <hr>

                                                <div class="d-flex">
                                                    <div class="flex-fill">
                                                        <b class="pl-2">Latitude</b>
                                                        <br>
                                                        <span class="badge badge-pill badge-hg badge-light-blue">
                                                            @{{ detailToko.lat }}
                                                        </span>
                                                    </div>

                                                    <div class="pl-2 flex-fill">
                                                        <b class="pl-3">Longitude</b>
                                                        <br>
                                                        <span class="badge badge-pill badge-hg badge-light-blue">
                                                            @{{ detailToko.lng }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="foto" class="row ml-0 mr-0 mt-2 mb-2 p-0">
                                            <div v-for="foto in detailToko.get_foto" class="col-lg-4">
                                                <div class="card">
                                                    <img style="height: 100px;width: 100%" class="card-img-top" :src="foto.dir">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3 bg-light-blue">
                                            <b><h5 class="text-blue">Keterangan Toko</h5></b>
                                            <template v-if="detailToko.catatan == null">
                                                <p class="m-0">Tidak ada keterangan tambahan.</p>
                                            </template>
                                            <template v-html="detailToko.catatan"></template>
                                        </div>

                                        <div class="card-body">
                                            <h5>Rata-rata Transaksi Per Jam</h5>
                                            <canvas style="width: 100%;height 200px" id="transaksi-per-jam"></canvas>

                                            <hr>

                                            <h5>Rata-rata Transaksi Per Hari</h5>
                                            <canvas style="width: 100%;height 200px" id="transaksi-per-hari"></canvas>

                                            <hr>

                                            <h5>Barang Populer</h5>
                                            <ul class="list-group list-group-borderless">
                                                <li class="list-group-item" v-for="barang in detailToko.barangPopuler" :key="barang.id">
                                                    <h6 class="text-blue m-0"><b>@{{ barang.nama }}</b></h6>
                                                    <span>Rp @{{ barang.pivot.harga }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 m-0 p-0 full-height">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/carbon.js') }}"></script>
    <script src="{{ asset('js/kmeans.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="{{ asset('js/maps/home.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.3/js/lightslider.min.js"></script>
    <script>
        window.data = {
            daftarPerusahaan: @json($daftarPerusahaan),
            icons: {
                biru: '{{ asset('images/marker_biru.png') }}',
                kuning: '{{ asset('images/marker_kuning.png') }}',
                hijau: '{{ asset('images/marker_hijau.png') }}'
            },
            csrf: '{{ csrf_token() }}'
        }
        window.actionUrl = {
            detailTransaksiPerJam: '{{ route('ringkasan.transaksi.perjam', ['toko' => '']) }}',
            detailTransaksiPerHari: '{{ route('ringkasan.transaksi.perhari', ['toko' => '']) }}',
            getBarangPopuler: '{{ route('toko.barang.populer', ['toko' => '']) }}',
            fetchingData: '{{ route('fetch.data') }}'
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd3dSy2ivrW8j-Pmz12_bs2rwSaCapCx8&libraries=places,geometry&callback=initMap"></script>
</body>
</html>
