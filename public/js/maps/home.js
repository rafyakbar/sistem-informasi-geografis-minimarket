var vueMap = null

function initMap() {
    new Vue({
        el: '#app',
        data: {
            map: null,
            markers: [],
            center: {lat:  -7.3129590, lng: 112.7273454}
        },

        mounted: function () {
            this.initMap()
            this.initToko()
        },

        methods: {
            initMap: function () {
                var that = this

                this.map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 3,
                        center: that.center,
                        streetViewControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false
                    }
                )
            },

            initToko: function () {
                let that = this

                window.daftarToko.map(function (item, index) {
                    that.markers.push(new google.maps.Marker({
                        position: {
                            lat: parseFloat(item.lat),
                            lng: parseFloat(item.lng)
                        },
                        map: that.map
                    }))
                })
            }
        }
    })
}
