@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('content')
    <div class="">

    </div>
    <div id="map" style="width: 100%; height: 100%"></div>
@endsection

@push('js')
    <script>
        function initMap() {
            var unesa = {lat: -7.250445, lng: 112.768845};

            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 10, center: unesa}
            );

            var marker;

            infoWindow = new google.maps.InfoWindow;
            
            if (navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    marker = new google.maps.Marker({position:pos, map:map})

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Location found.');
                    infoWindow.open(map);
                    map.setCenter(pos);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
    </script>
    {{--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDM5VCloED9E1qo3UK00gpuQklBnwEv6wg&callback=initMap">--}}
    {{--</script>--}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd3dSy2ivrW8j-Pmz12_bs2rwSaCapCx8&callback=initMap"></script>
@endpush