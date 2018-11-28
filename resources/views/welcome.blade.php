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
            height: 100%;
            width: 100%
        }

        #tools {
            z-index: +10;
            position: absolute;
            top: 0;
            left: 0;
            width: 300px;
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

                    <div id="tools">
                        <div class="card border-0">
                            <div class="card-body p-0">
                                <div class="search p-3">
                                    <input type="text" class="form-control" id="search-autocomplete"/>
                                    <select class="custom-select" v-model="searchQuery.perusahaan">
                                        <option :value="null">Semua Minimarket</option>
                                        <option v-for="perusahaan in daftarPerusahaan">@{{ perusahaan.nama }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-body" v-if="status === 'search'">
                                <div class="list-group">
                                    <a href="#" @click.prevent="bukaDetailMinimarket($event, toko)" class="list-group-item" v-for="toko in daftarToko">
                                        @{{ toko.alamat }}
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-3" v-if="status === 'detail'">
                                @{{ detailToko.alamat }}
                            </div>
                        </div>
                    </div>

                    <div id="map"></div>
                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/carbon.js') }}"></script>
    <script>
        window.data = {
            daftarToko: @json($daftarToko),
            daftarPerusahaan: @json($daftarPerusahaan)
        }
        window.actionUrl = {
            search: '{{ route('toko.search') }}'
        }
    </script>
    <script src="{{ asset('js/maps/home.js') }}"></script>
    <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd3dSy2ivrW8j-Pmz12_bs2rwSaCapCx8&libraries=places,geometry&callback=initMap"></script>
</body>
</html>
