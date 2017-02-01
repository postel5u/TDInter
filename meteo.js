$.ajax( {
  url: 'https://freegeoip.net/json/',
  type: 'GET',
  dataType: 'jsonp',
  success: function(location) {
     $.ajax({
       url: 'https://ip-api.com/xml/'+location.ip,
       type: 'GET',
       success: function(xml){

         var mymap = L.map('mapid').setView([$(xml).find('lat')[0].textContent,$(xml).find('lon')[0].textContent], 13);
         L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
             attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
             maxZoom: 18,
             id: 'your.mapbox.project.id',
             accessToken: 'your.mapbox.public.access.token'
         }).addTo(mymap);
       },
       error: function(e){
         console.log("test");
       }
     });
  },
  error: function(e){
    console.log(e);
  }
} );
