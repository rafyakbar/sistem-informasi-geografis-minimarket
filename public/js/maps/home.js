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
            clusteringData: [],
            barangPopuler: [],
            lightSlider: null,
            fetchingData: {
                status: false,
                progress: 0
            }
        },

        mounted: function () {
            this.fetchData()
            this.initmarkerIcon()
            this.initMap()
            this.geolocation()
            this.initAutocomplete()
            this.daftarPerusahaan = window.data.daftarPerusahaan
        },

        methods: {
            /**
             * Melakukan pengambilan data
             */
            fetchData: function () {
                var that = this
                this.fetchingData.status = true

                axios.get(window.actionUrl.fetchingData).then(function (response) {
                    window.data.daftarToko = response.data
                    that.fetchingData.status = false
                    that.initMarkerToko()
                })
            },

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

            /**
             * Inisialisasi map
             */
            initMap: function () {
                var that = this

                this.map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 10,
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

            /**
             * Inisialisasi autocomplete
             */
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

                this.daftarToko = []

                this.markers.map(function (item, index) {
                    item.setVisible(true)
                    var jarak = google.maps.geometry.spherical.computeDistanceBetween(
                        new google.maps.LatLng(lat, lng),
                        new google.maps.LatLng(item.position.lat(), item.position.lng())
                    )

                    if (jarak < 1000) {
                        that.daftarToko.push(window.data.daftarToko[index])
                    }
                    else {
                        item.setVisible(false)
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
                    map: that.map,
                    label: {
                        text: camar.get_perusahaan.nama,
                        fontSize: '12px'
                    }
                })

                if (camar.icon) {
                    marker.setIcon(camar.icon)
                }

                marker.addListener('click', function (e) {
                    that.map.panTo(marker.getPosition())
                    that.bukaDetailMinimarket(e, camar)
                    that.detailToko = camar
                    that.$forceUpdate()
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
                toko.barangPopuler = []

                this.$nextTick(function () {
                    that.waktuPopulerChart(that.detailToko)
                })

                that.tampilkanBarangPopuler(that.detailToko)
            },

            tampilkanBarangPopuler: function (toko) {
                var that = this

                axios.get(window.actionUrl.getBarangPopuler + '/' + toko.id).then(function (response) {
                    toko.barangPopuler = response.data
                    that.$forceUpdate()
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
                            backgroundColor: '#5e94ff',
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
                                backgroundColor: '#5e94ff',
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

            /**
             * Melakukan clustering terhadap semua toko
             */
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
                            var toko = that.markers[result[cluster][row].index]
                            toko.setIcon(iconColor[cluster])
                        }
                    }
                })
            },

            tampilkanSemuaToko: function () {
                this.markers.map(function (item) {
                    item.setVisible(true)
                })
            }
        },

        watch: {
            'searchQuery.perusahaan': function (value) {
                var that = this

                window.data.daftarToko.map(function (item, index) {
                    that.markers[index].setVisible(true)

                    if (item.get_perusahaan.nama != value) {
                        that.markers[index].setVisible(false)
                    }
                })
            }
        },

        computed: {
            'markerYangDitampilkan': function () {
                return this.markers.filter(function (item) {
                    return item.visible
                }).length
            }
        }
    })
}
