@extends('layouts.app')
@section('map')
<script>
    function initMap() {
      var uluru = {lat: -25.344, lng: 131.036};
      var map = new google.maps.Map(document.getElementById('map'), {zoom: 4, center: uluru});
      var marker = new google.maps.Marker({position: uluru, map: map});
    }
</script>

@endsection