var locations = [];

function setCoords(coord_arr) {
  for (let i = 0; i < coord_arr.length; i++) {
    //coord_arr[i][2] contains description | coord[i][0] and coord[i][1] are latitude and longitude respectfully (type converted them to numbers first)
    locations.push([Number(coord_arr[i][0]), Number(coord_arr[i][1]), coord_arr[i][2], coord_arr[i][3], coord_arr[i][4]]);
  }
}

function refreshMap(coord_arr) {
    document.write(coord_arr[i][2]);
}

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: {lat: 34.057723, lng: -117.820096},
    });
  map.setOptions({
    styles: [
            {"featureType": "road",elementType: "labels",stylers:[{visibility: "off"}]},
            {"featureType": "poi",elementType: "labels.icon",stylers:[{visibility: "off"}]},
            {"featureType": "transit",elementType: "labels",stylers:[{visibility: "off"}]} 
            ]
  });

  var infowindow =  new google.maps.InfoWindow({});

  const icon = {
    url: "images/poop_emoji.png",
    scaledSize: new google.maps.Size(30, 30)
  };
  var marker, count
  for (count = 0; count < locations.length; count++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[count][0], locations[count][1]),
        map: map,
        title: locations[count][2],
        icon: icon
      });
  
  // when clicking on a marker display location and note (both optional)
  google.maps.event.addListener(marker, 'click', (function (marker, count) {
        return function () {
          infowindow.setContent('<h2 style="text-align:center">' + locations[count][2] + '</h1>' + '<p style ="text-align:center; font-size: 15px">' + locations[count][3] + '</p>' +
          '<p style = "text-align:center">' + locations[count][4] + '</p>');
          infowindow.open(map, marker);
        }
      })(marker, count));
    } //end for
  }