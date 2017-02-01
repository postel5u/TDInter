$.ajax( {
  url: 'https://freegeoip.net/json/',
  type: 'GET',
  dataType: 'jsonp',
  success: function(location) {

    var mymap = L.map('mapid').setView([location.latitude ,location.longitude ], 13);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoibGF1bmF5MTJ1IiwiYSI6ImNpeW4ybTcyaDAwMGkycXBjd2ppemNnbHEifQ.8uPe0vZvhSFFPhPazNHmvQ'
    }).addTo(mymap);
  },
  error: function(e){
    console.log(e);
  }
} );
