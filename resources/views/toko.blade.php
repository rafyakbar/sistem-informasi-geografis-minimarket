@extends('layouts.carbon.app')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <button class="btn btn-info" id="dm">Daftar Minimarket</button>
    <button class="btn btn-primary" id="tm">Tambah Minimarket</button>

    <div class="card card-body">
        <div id="daftar-toko">
            <form action="{{ url()->current() }}">
                <div class="row">
                    <div class="col-lg-2">
                        <select class="form-control" name="perusahaan">
                            <option value="">{{ empty($perusahaan) ? 'Pilih Perusahaan' : $perusahaan }}</option>
                            <option value="">-</option>
                            @foreach($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->nama }}">{{ $perusahaan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="npkk" placeholder="contoh filter menurut negara, provinsi, kota dan kecamatan : indonesia,jawa timur,surabaya,ketintang|indonesia,jawa tengah,semarang," value="{{ $npkk }}">
                    </div>
                    <div class="col-lg-2">
                        <div class="btn-group">
                            <input type="submit" class="btn btn-info" value="Filter">
                            <button class="btn btn-link">{{ $tokos->total() }} data sesuai filter</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>No</td>
                        <td width="9%">Perusahaan</td>
                        <td>Negara</td>
                        <td>Provinsi</td>
                        <td>Kota</td>
                        <td>Kecamatan</td>
                        <td width="15%">Alamat</td>
                        <td>Latitude</td>
                        <td>Longitude</td>
                        <td width="15%">Catatan</td>
                        <td>Aksi</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tokos as $toko)
                        <tr>
                            <td>{{ ($tokos->currentpage() * $tokos->perpage()) + ($loop->iteration) - $tokos->perpage() }}</td>
                            <td>
                                <select class="form-control" name="perusahaan_id" id="perusahaan-{{ $toko->id }}">
                                    <option value="{{ $toko->perusahaan_id }}">{{ $toko->getPerusahaan(false)->nama }}</option>
                                    @foreach($perusahaans as $perusahaan)
                                        @if($toko->perusahaan_id != $perusahaan->id)
                                            <option value="{{ $perusahaan->nama }}">{{ $perusahaan->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input id="negara-{{ $toko->id }}" type="text" class="form-control" value="{{ $toko->negara }}">
                            </td>
                            <td>
                                <input id="provinsi-{{ $toko->id }}" type="text" class="form-control" value="{{ $toko->provinsi }}">
                            </td>
                            <td>
                                <input id="kota-{{ $toko->id }}" type="text" class="form-control" value="{{ $toko->kota }}">
                            </td>
                            <td>
                                <input id="kecamatan-{{ $toko->id }}" type="text" class="form-control" value="{{ $toko->kecamatan }}">
                            </td>
                            <td>
                                <textarea id="alamat-{{ $toko->id }}" class="form-control">{{ $toko->alamat }}</textarea>
                            </td>
                            <td>
                                <input id="lat-{{ $toko->id }}" type="text" class="form-control" value="{{ $toko->lat }}">
                            </td>
                            <td>
                                <input id="lng-{{ $toko->id }}" type="text" class="form-control" value="{{ $toko->lng }}">
                            </td>
                            <td>
                                <textarea id="catatan-{{ $toko->id }}" class="form-control">{{ $toko->catatan }}</textarea>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button onclick="event.preventDefault(); update('{{ $toko->id }}', $('#perusahaan-{{ $toko->id }}').val(), $('#negara-{{ $toko->id }}').val(), $('#provinsi-{{ $toko->id }}').val(), $('#kota-{{ $toko->id }}').val(), $('#kecamatan-{{ $toko->id }}').val(), $('#alamat-{{ $toko->id }}').val(), $('#lat-{{ $toko->id }}').val(), $('#lng-{{ $toko->id }}').val(), $('#catatan-{{ $toko->id }}').val())" class="btn btn-success btn-sm">S</button>
                                    <a href="{{ route('admin.toko.delete', ['id' => encrypt($toko->id)]) }}" class="btn btn-danger btn-sm">H</a>
                                </div>
                                <button class="btn btn-info btn-sm">Image</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $tokos->links() }}
        </div>

        <div id="tambah-toko" style="display: none">
            <h4>Tambah minimarket berdasarkan lokasi</h4>
            <form action="{{ route('admin.toko.store.many') }}" method="post" id="formaddmany">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <select class="form-control" name="perusahaan">
                            @foreach($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <select class="form-control" name="lokasi" id="kp" style="width: 100%">
                            @foreach($kp as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <input type="submit" id="addmany" class="btn btn-success" value="Tambahkan">
                    </div>
                </div>

            </form>
            <hr>
            <h4>Tambah 1 1</h4>
            <div class="row">
                <div class="col-lg-6">
                    <form action="{{ route('admin.toko.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Perusahaan</label>
                                <br>
                                <select class="form-control" name="perusahaan">
                                    @foreach($perusahaans as $perusahaan)
                                        <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Foto-foto</label>
                                <br>
                                <input type="file" class="form-control" name="foto" multiple accept="image/*">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                <label>Negara</label>
                                <br>
                                <input id="negara" type="text" name="negara" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>Provinsi</label>
                                <br>
                                <input id="provinsi" type="text" name="provinsi" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>Kota</label>
                                <br>
                                <input id="kota" type="text" name="kota" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>Kecamatan</label>
                                <br>
                                <input id="kecamatan" type="text" name="kecamatan" class="form-control">
                            </div>
                        </div>
                        <br>
                        <label>Alamat</label>
                        <textarea id="alamat" class="form-control" name="alamat"></textarea>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Latitude</label>
                                <br>
                                <input id="lat" type="text" name="lat" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Longitude</label>
                                <br>
                                <input id="lng" type="text" name="lng" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Aksi</label>
                                <br>
                                <div class="btn-group">
                                    <button class="btn btn-info" title="Geocode dari alamat" id="geocode" type="button">Geocode</button>
                                    <button class="btn btn-primary" title="Reverse Geocode" id="reverse" type="button">Reverse</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan" rows="5" placeholder="Tambahkan info seperti jam buka dll"></textarea>
                        <br>
                        <input type="submit" class="btn btn-success" value="Simpan">
                        <button id="geolocation" type="button" class="btn btn-info">Geolocation</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div id="map" style="height: 100%;width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <form style="display: none" id="form-update" action="{{ route('admin.toko.update') }}" method="post">
        @csrf
        <input type="hidden" id="update-id" name="id">
        <input type="hidden" id="update-perusahaan_id" name="perusahaan_id">
        <input type="hidden" id="update-negara" name="negara">
        <input type="hidden" id="update-provinsi" name="provinsi">
        <input type="hidden" id="update-kota" name="kota">
        <input type="hidden" id="update-kecamatan" name="kecamatan">
        <input type="hidden" id="update-alamat" name="alamat">
        <input type="hidden" id="update-lat" name="lat">
        <input type="hidden" id="update-lng" name="lng">
        <input type="hidden" id="update-catatan" name="catatan">
    </form>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#kp').select2();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        var unesa, map, marker;

        $('#tm').click(function () {
            $('#daftar-toko').hide()
            $('#tambah-toko').show()
        })

        $('#dm').click(function () {
            $('#tambah-toko').hide()
            $('#daftar-toko').show()
        })

        $('#geocode').click(function () {
            var alamat = $('#alamat').val()

            if (alamat != ''){
                $(this).html('Geocoding...')

                $.ajax({
                    type: 'get',
                    url: '{{ route('admin.geocode') }}',
                    data: {
                        alamat: alamat
                    },
                    success: function (response) {
                        var data = JSON.parse(response)

                        if (data.length != 0){
                            $('#lat').val(data[0].lat)
                            $('#lng').val(data[0].lon)

                            marker.setPosition(new google.maps.LatLng(data[0].lat, data[0].lon))
                            map.setCenter(new google.maps.LatLng(data[0].lat, data[0].lon))

                            $('#geocode').html('Geocode')
                        } else {
                            $('#geocode').html('Geocode')
                            alert('Alamat tidak ditemukan')
                        }
                    },
                    error: function () {
                        $('#geocode').html('Geocode')
                        alert('Gagal mengambil data')
                    }
                })
            } else {
                alert('Alamat tidak boleh kosong!')
            }
        })

        $('#reverse').click(function () {
            var lat = $('#lat').val()
            var lng = $('#lng').val()
            if (lat != '' && lng != ''){
                $(this).html('Reversing...')

                $.ajax({
                    type: 'get',
                    url: '{{ route('admin.reverse') }}',
                    data: {
                        lat: lat,
                        lng: lng
                    },
                    success: function (response) {
                        var data = JSON.parse(response)

                        if (data.length != 0){
                            if (confirm('Apakah anda ingin memperbarui data lokasi?')){
                                $('#negara').val(data.address.country)
                                $('#provinsi').val(data.address.state)
                                $('#kota').val(data.address.city)
                                $('#kecamatan').val(data.address.county)
                                $('#alamat').val(data.display_name)
                            }

                            $('#reverse').html('Reverse')
                        } else {
                            $('#reverse').html('Reverse')
                            alert('Data tidak ditemukan')
                        }
                    },
                    error: function () {
                        $('#geocode').html('Geocode')
                        alert('Gagal mengambil data')
                    }
                })
            } else {
                alert('Latitude dan longitude harus terisi!')
            }
        })

        $('#geolocation').click(function () {
            geolocation()
        })

        function initMap() {
            unesa = {lat:  -7.3129590, lng: 112.7273454};

            map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 18,
                    center: unesa
                }
            );

            marker = new google.maps.Marker({
                draggable: true,
                position: unesa,
                map: map
            });

            marker.addListener('mouseup', function () {
                $('#lat').val(marker.getPosition().lat())
                $('#lng').val(marker.getPosition().lng())
            })
        }

        function geolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position, showError);
            } else {
                alert('Geolocation is not supported by this browser!')
            }
        }

        function position(position) {
            $('#lat').val(position.coords.latitude)
            $('#lng').val(position.coords.longitude)

            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)

            marker.setPosition(latlng)
            map.setCenter(latlng)

            $('#reverse').click()
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation!")
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable!")
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out!")
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred!")
                    break;
            }
        }

        function update(id, pi, negara, provinsi, kota, kecamatan, alamat, lat, lng, catatan) {
            $('#update-id').val(id)
            $('#update-perusahaan_id').val(pi)
            $('#update-negara').val(negara)
            $('#update-provinsi').val(provinsi)
            $('#update-kota').val(kota)
            $('#update-kecamatan').val(kecamatan)
            $('#update-alamat').val(alamat)
            $('#update-lat').val(lat)
            $('#update-lng').val(lng)
            $('#update-catatan').val(catatan)

            $('#form-update').submit()
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd3dSy2ivrW8j-Pmz12_bs2rwSaCapCx8&callback=initMap"></script>

    {{--<script async defer--}}
    {{--src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDM5VCloED9E1qo3UK00gpuQklBnwEv6wg&callback=initMap">--}}
    {{--</script>--}}
@endpush