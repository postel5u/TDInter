var apikey = '075bed26690f3fe3dd9e9e46091ed4405277f1ec';
$.ajax( {
    url: 'https://freegeoip.net/json/'+"lol",
    type: 'GET',
    dataType: 'jsonp',
    success: function(location) {

        var mymap = L.map('mapid').setView([location.latitude ,location.longitude ], 15);
        //var marker = L.marker([location.latitude, location.longitude], {color : 'red'}).addTo(mymap);
        var circle = L.circle([location.latitude, location.longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 25
        }).addTo(mymap);

        circle.bindPopup("<b>Je suis ici !</b>").openPopup();

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGF1bmF5MTJ1IiwiYSI6ImNpeW4ybTcyaDAwMGkycXBjd2ppemNnbHEifQ.8uPe0vZvhSFFPhPazNHmvQ'
        }).addTo(mymap);

        $.ajax({
            url: "https://api.jcdecaux.com/vls/v1/stations?contract=Nancy&apiKey="+apikey,
            type: 'GET',
            datatype: 'json',
            success: function(success) {
                success.forEach(function(element){
                    //console.log(element);
                    var marker = L.marker([element.position.lat, element.position.lng]).addTo(mymap);
                    marker.bindPopup("<b>" + element.address + "</b><br/><p>Vélos disponibles : " + element.available_bikes +"<br/>Places disponibles : " + element.available_bike_stands + "</p>")
                })
            },
            error: function(e) {
                console.log(e.status);
            }
        })
    },
    error: function(e){
        console.log(e.status);
        switch (e.status) {
          case 400:
            $("#mapid").html("<h1>Erreur : "+e.status+"<br/>Problème dû à la requète.</h1>");
            break;
          case 401:
            $("#mapid").html("<h1>Erreur : "+e.status+"<br/>Problème dû à la requète.</h1>");
            break;
          case 403:
            $("#mapid").html("<h1>Erreur : "+e.status+"<br/>Problème dû à la requète.</h1>");
            break;
          case 404:
            $("#mapid").html("<h1>Erreur : "+e.status+"<br/>Problème dû à la requète.</h1>");
            break;
          case 500:
            $("#mapid").html("<h1>Erreur : "+e.status+"<br/>Problème dû au serveur.</h1>");
            break;
          case 503:
            $("#mapid").html("<h1>Erreur : "+e.status+"<br/>Problème dû au serveur.</h1>");
            break;
          default:

        }
    }
});
