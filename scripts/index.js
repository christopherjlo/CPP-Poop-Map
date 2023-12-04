var locations = [];

function setCoords(coord_arr) {
  for (let i = 0; i < coord_arr.length; i++) {
    //coord_arr[i][2] contains description | coord[i][0] and coord[i][1] are latitude and longitude respectfully (type converted them to numbers first)
    locations.push([Number(coord_arr[i][0]), Number(coord_arr[i][1]), coord_arr[i][2]]);
  }
}

function refreshMap(coord_arr) {
    document.write(coord_arr[i][2]);
}

function refreshMap(coord_arr) {
    document.write(coord_arr[i][2]);
}
//FOR TESTING
// function printCoords(coord_arr) {
//   for (let i = 0; i < coord_arr.length; i++) {
//     document.write(coord_arr[i][0] + coord_arr[i][1]);
//     document.write("<br>");
//     document.write(typeof Numbercoord_arr[i][0]);
//   }
// }

function initMap() {
    var center = {lat: 34.057723, lng: -117.820096};
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: center
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
        title: "icon",//locations[count][0],
        icon: icon
      });
  
  // when clicking on a marker display location and note (both optional)
  google.maps.event.addListener(marker, 'click', (function (marker, count) {
        return function () {
          infowindow.setContent('<h1 style="text-align:center"> Insert location/tag here</h1>' + '<p style = "text-align:center">' + locations[count][2] + '</p>');
          infowindow.setContent('<h1 style="text-align:center"> Insert location/tag here</h1>' + '<p style = "text-align:center">' + locations[count][2] + '</p>');
          infowindow.open(map, marker);
        }
      })(marker, count));
    } //end for
  }
