function initMap() {
    new Vue({
        el: '#app',
        data: {
            map: null,
            markers: [],
            daftarPerusahaan: [],
            daftarToko: [],
            center: {lat:  -7.3129590, lng: 112.7273454},
            searchQuery: {
                lat: null,
                lng: null,
                perusahaan: null
            },
            distances: [],
            center: null,
            status: 'index',
            detailToko: null
        },

        mounted: function () {
            this.initMap()
            this.initMarkerToko()
            this.geolocation()
            this.initAutocomplete()
            this.daftarPerusahaan = window.data.daftarPerusahaan
        },

        methods: {
            initMap: function () {
                var that = this

                this.map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 15,
                        center: that.center,
                        streetViewControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                        styles: [
                            {
                                "featureType": "poi",
                                "stylers": [
                                    {"visibility": "off" }
                                ]
                            }
                        ]
                    }
                )
            },

            initMarkerToko: function () {
                let that = this

                window.data.daftarToko.map(function (item, index) {
                    that.addMarker(item)
                })
            },

            geolocation: function () {
                var that = this

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        var position = {
                            lat: pos.coords.latitude,
                            lng: pos.coords.longitude
                        }
                        that.map.setCenter(position);
                    })
                }
            },

            initAutocomplete: function () {
                // Autocomplete
                var that = this

                var input = (document.getElementById('search-autocomplete'));
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.setTypes([]);
                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (place.geometry) {
                        var lat = place.geometry.location.lat()
                        var lng = place.geometry.location.lng()
                        that.searchQuery.lat = lat
                        that.searchQuery.lng = lng
                        that.map.panTo({
                            lat, lng
                        })
                        that.updateCircle()
                        that.cariTokoTerdekat()
                    }
                });
            },

            radius: function (x) {
                return x * Math.PI / 180
            },

            updateCircle: function () {
                if (this.center !== null)
                    this.center.setMap(null)

                var that = this

                this.center = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: that.map,
                    center: new google.maps.LatLng(
                        that.searchQuery.lat,
                        that.searchQuery.lng
                    ),
                    radius: 1000
                });
            },

            cariTokoTerdekat: function() {
                var lat = this.searchQuery.lat
                var lng = this.searchQuery.lng
                var that = this

                this.markers.map(function (item) {
                    item.setMap(null)
                })

                this.markers = []
                this.daftarToko = []

                window.data.daftarToko.map(function (item) {
                    var jarak = google.maps.geometry.spherical.computeDistanceBetween(
                        new google.maps.LatLng(lat, lng),
                        new google.maps.LatLng(item.lat, item.lng)
                    )

                    if (jarak < 1000) {
                        that.addMarker(item)
                        that.daftarToko.push(item)
                    }
                })

                this.status = 'search'
            },

            addMarker: function (camar) {
                var that = this

                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(camar.lat),
                        lng: parseFloat(camar.lng)
                    },
                    map: that.map
                })

                marker.addListener('click', function (e) {
                    that.map.panTo(marker.getPosition())
                })

                this.markers.push(marker)
            },

            bukaDetailMinimarket: function (event, toko) {
                var that = this

                this.map.setZoom(18)
                this.map.panTo(new google.maps.LatLng(toko.lat, toko.lng))

                this.status = 'detail'
                this.detailToko = toko
            }
        }
    })
}
