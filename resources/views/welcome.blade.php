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
    <link rel="stylesheet" href="{{ asset('css/carbon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .content {
            padding: 0;
            margin-top: 0;
        }

        #app, #map {
            height: 100vh;
        }

        #tools {
            height: 100vh;
            overflow-y: auto;
            background-color: #fff;
        }

        .bdr {
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <div class="page-wrapper">

        <div class="main-container">

            <div class="content">

                <div id="app">

                    <div class="container-fluid p-0">
                        <div class="row m-0 p-0">
                            <div class="col-lg-4 m-0 p-0">
                                <div id="tools">
                                    <div class="card border-0 mb-0">
                                        <div class="card-body p-0">
                                            <div class="search p-3">
                                                <input type="text" class="form-control" id="search-autocomplete"/>
                                                <select class="custom-select" v-model="searchQuery.perusahaan">
                                                    <option :value="null">Semua Minimarket</option>
                                                    <option v-for="perusahaan in daftarPerusahaan">@{{ perusahaan.nama }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="card-body" v-if="status === 'index'">
                                            <div class="btn btn-primary btn-lg" @click="clustering">
                                                Lakukan Clustering
                                            </div>
                                        </div>

                                        <div class="card-body" v-if="status === 'search'">
                                            <div class="list-group">
                                                <a href="#" @click.prevent="bukaDetailMinimarket($event, toko)" class="list-group-item" v-for="toko in daftarToko">
                                                    @{{ toko.alamat }}
                                                </a>
                                            </div>
                                        </div>

                                        {{-- <div class="card-body p-3" > --}}
                                        <template v-if="status === 'detail'">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>Jenis</td>
                                                        <td>@{{ detailToko.get_perusahaan.nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>@{{ detailToko.alamat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Latitude</td>
                                                        <td>@{{ detailToko.lat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Longitude</td>
                                                        <td>@{{ detailToko.lng }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        {{-- </div> --}}

                                            <div class="card-body">
                                                <h5>Rata-rata Transaksi Per Jam</h5>
                                                <canvas style="width: 100%;height 200px" id="transaksi-per-jam"></canvas>

                                                <h5>Rata-rata Transaksi Per Hari</h5>
                                                <canvas style="width: 100%;height 200px" id="transaksi-per-hari"></canvas>

                                                <h5>Barang Populer</h5>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 m-0 p-0">
                                <div id="map"></div>
                            </div>
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
    <script>
        window.data = {
            daftarToko: @json($daftarToko),
            daftarPerusahaan: @json($daftarPerusahaan),
            icons: {
                biru: '{{ asset('images/marker_biru.png') }}',
                kuning: '{{ asset('images/marker_kuning.png') }}',
                hijau: '{{ asset('images/marker_hijau.png') }}'
            }
        }
        window.actionUrl = {
            detailTransaksiPerJam: '{{ route('ringkasan.transaksi.perjam', ['toko' => '']) }}',
            detailTransaksiPerHari: '{{ route('ringkasan.transaksi.perhari', ['toko' => '']) }}'
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd3dSy2ivrW8j-Pmz12_bs2rwSaCapCx8&libraries=places,geometry&callback=initMap"></script>
</body>
</html>
