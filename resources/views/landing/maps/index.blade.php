@extends('layouts.landing.index')
@section('content')

    <div class="content-config">
        <div id="map"></div>

        <button id="locationButton" class="btn btn-warning d-none">Set Pin Your Location</button>

        <input type="hidden" name="long" id="long">
        <input type="hidden" name="lat" id="lat">
    </div>




@endsection
@push('custom-js')
    <script>
        /**
         * Change the current page title
         * */
        window.location.pathname === '/maps' ? document.title = 'Maps' : ''


        /**
         * Get Logged user token
         * */
        let token = localStorage.getItem('accessToken')

        /**
         * Element Select
         * */
        let button = document.getElementById('locationButton')
        let longitude = document.getElementById('long')
        let latitude = document.getElementById('lat')
        /**
         * Mapbox API
         * */
        mapboxgl.accessToken = 'pk.eyJ1IjoiYWthc2gtd2JkIiwiYSI6ImNsMmVoZTRkNzAwcWIzYm52N2ljcWFkdmgifQ.09ZCXCfd8NEGvJoFqOzOyg';

        /**
         * By default, map showing center
         * */
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [12.550343, 55.665957],
            zoom: 5
        })

        /**
         * Mapbox find my location controller
         * */
        var geolocate = new mapboxgl.GeolocateControl();
        map.addControl(geolocate);

        /**
         * After clicking find my location button getting long & lat
         * */
        geolocate.on('geolocate', function (e) {
            var lon = e.coords.longitude;
            var latt = e.coords.latitude;

            if (token) {
                button.classList.remove('d-none')
            }

            longitude.value = lon
            latitude.value = latt
        });

        /**
         * After clicking anywhere in map getting long & lat
         * */
        map.on('click', function (e) {
            let coordinates = e;

            if (token) {
                button.classList.remove('d-none')
            }

            longitude.value = coordinates.lngLat.lng
            latitude.value = coordinates.lngLat.lat

        });


        /**
         * Set pin location button
         * */
        button.addEventListener('click', () => {
            let user = JSON.parse(localStorage.getItem('user'))
            let formData = new FormData()
            formData.append('long', longitude.value)
            formData.append('lat', latitude.value)
            formData.append('name', user.username)

            $.ajax({
                url: window.origin + '/api/set-location',
                type: 'POST',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                data: formData,
                success: function (res) {
                    toastr.success(res.message)
                    location.reload()
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            })


        })


        /**
         * Get user long & lat
         * */
        $(document).ready(function () {
            $.ajax({
                url: window.origin + '/api/get-location',
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    if(res.status === 'success' && res.data.length > 0){
                        res.data.forEach((item, i) => {
                            const popup = new mapboxgl.Popup({offset: 25}).setText(item.name);
                            new mapboxgl.Marker()
                                .setLngLat([item.long, item.lat])
                                .setPopup(popup)
                                .addTo(map);
                        })
                    }else{
                        console.log('login please')
                    }


                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        })


    </script>


@endpush
