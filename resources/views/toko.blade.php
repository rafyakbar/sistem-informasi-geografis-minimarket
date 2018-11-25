@extends('layouts.carbon.app')

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
                        <td>Perusahaan</td>
                        <td>Alamat</td>
                        <td>Latitude</td>
                        <td>Longitude</td>
                        <td>Aksi</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tokos as $toko)
                        <tr>
                            <td>{{ ($tokos->currentpage() * $tokos->perpage()) + ($loop->iteration) - $tokos->perpage() }}</td>
                            <td>{{ $toko->getPerusahaan(false)->nama }}</td>
                            <td>{{ $toko->alamat }}</td>
                            <td>{{ $toko->lat }}</td>
                            <td>{{ $toko->lng }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Detail/Edit</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $tokos->links() }}
        </div>

        <div id="tambah-toko" style="display: none">
            <div class="row">
                <div class="col-lg-6">
                    <form>
                        <label>Perusahaan</label>
                        <select class="form-control" name="perusahaan">
                            @foreach($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->nama }}">{{ $perusahaan->nama }}</option>
                            @endforeach
                        </select>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                <label>Negara</label>
                                <input type="text" name="negara" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>Provinsi</label>
                                <input type="text" name="provinsi" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>Kota</label>
                                <input type="text" name="provinsi" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label>Kecamatan</label>
                                <input type="text" name="provinsi" class="form-control">
                            </div>
                        </div>
                        <br>
                        <label>Alamat</label>
                        <textarea id="alamat" class="form-control" name="alamat"></textarea>
                        <br>
                        <div class="row">
                            <div class="col-lg-5">
                                <label>Latitude</label>
                                <input id="lat" type="text" name="lat" class="form-control">
                            </div>
                            <div class="col-lg-5">
                                <label>Longitude</label>
                                <input id="lng" type="text" name="lng" class="form-control">
                            </div>
                            <div class="col-lg-2">
                                <label>Aksi</label>
                                <button class="btn btn-info" title="Geocode dari alamat" id="geocode" type="button">Geocode</button>
                            </div>
                        </div>
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan" rows="5" placeholder="Tambahkan info seperti jam buka dll"></textarea>
                        <br>
                        <input type="submit" class="btn btn-success" value="Simpan">
                    </form>
                </div>
                <div class="col-lg-6">
                    <div id="map" style="height: 100%;width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
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

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd3dSy2ivrW8j-Pmz12_bs2rwSaCapCx8&callback=initMap"></script>

    {{--<script async defer--}}
    {{--src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDM5VCloED9E1qo3UK00gpuQklBnwEv6wg&callback=initMap">--}}
    {{--</script>--}}
@endpush