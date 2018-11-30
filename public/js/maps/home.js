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
            detailToko: null,
            markerIcon: {},
            detailChart: {
                jam: null,
                hari: null
            },
            clusteringData: []
        },

        mounted: function () {
            this.initmarkerIcon()
            this.initMap()
            this.initMarkerToko()
            this.geolocation()
            this.initAutocomplete()
            this.daftarPerusahaan = window.data.daftarPerusahaan
        },

        methods: {
            initmarkerIcon: function () {
                this.markerIcon.kuning = {
                    url: window.data.icons.kuning
                }

                this.markerIcon.biru = {
                    url: window.data.icons.biru
                }

                this.markerIcon.hijau = {
                    url: window.data.icons.hijau
                }
            },

            initMap: function () {
                var that = this

                this.map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 8,
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
                    fillOpacity: 0.25,
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

            /**
             * Menambahkan marker pada map
             *
             * @param {Objek} camar Objek Toko
             */
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
                    that.bukaDetailMinimarket(e, camar)
                })

                this.markers.push(marker)
            },

            /**
             * Menampilkan detail toko pada sidebar
             *
             * @param {event} event Event
             * @param {Object} toko Objek toko
             */
            bukaDetailMinimarket: function (event, toko) {
                var that = this

                this.map.setZoom(18)
                this.map.panTo(new google.maps.LatLng(toko.lat, toko.lng))

                this.status = 'detail'
                this.detailToko = toko

                this.$nextTick(function () {
                    that.waktuPopulerChart(that.detailToko)
                })
            },

            /**
             * Menampilkan chart untuk transaksi per jam dan per hari
             * pada sidebar
             *
             * @param {Object} toko Objek Toko
             */
            waktuPopulerChart: function (toko) {
                var that = this

                if (this.detailChart.jam != null)
                    this.detailChart.jam.destroy()

                if (this.detailChart.hari != null)
                    this.detailChart.hari.destroy()


                that.detailChart.jam = new Chart(document.getElementById('transaksi-per-jam'), {
                    type: 'bar',
                    data: {
                        labels: ['7-8', '8-9', '9-10', '10-11', '11-12', '12-13', '13-14', '14-15', '15-16', '16-17', '17-18', '18-19', '19-20', '20-21'],
                        datasets: [{
                            label: '# transaksi',
                            data: toko.transaksi_per_jam,
                            backgroundColor: 'rgb(54, 162, 235)',
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                })

                axios.get(window.actionUrl.detailTransaksiPerHari + '/' + toko.id).then(function (response) {
                    that.detailChart.hari = new Chart(document.getElementById('transaksi-per-hari'), {
                        type: 'bar',
                        data: {
                            labels: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                            datasets: [{
                                label: '# transaksi',
                                data: response.data,
                                backgroundColor: 'rgb(54, 162, 235)',
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    })
                })
            },

            parseDataUntukClustering: function () {
                this.clusteringData = window.data.daftarToko.map(function (toko) {
                    return toko.transaksi_per_jam
                })
            },

            clustering: function () {
                let that = this
                var iconColor = [
                    this.markerIcon.biru,
                    this.markerIcon.kuning,
                    this.markerIcon.hijau
                ]

                this.parseDataUntukClustering()

                var kmeans = new Kmeans(this.clusteringData, 3, function (err, result) {
                    for (var cluster in result) {
                        for (var row in result[cluster]) {
                            console.log(result[cluster][row])
                            var toko = that.markers[result[cluster][row].index]
                            toko.setIcon(iconColor[cluster])
                        }
                    }
                })
            }
        }
    })
}
