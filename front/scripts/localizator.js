$(document).ready(function () {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        var apiKey = API_KEY;
        var geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

        // GET ENDEREÇO BASEADO NAS COORDENADAS
        
        // $.get(geocodeUrl, function (data) {
        //   if (data.status === "OK") {
        //     var address = data.results[0].formatted_address;
        //     $("#form-place").val(address);
        //     console.log(data.results[0]);
        //   } else {
        //     console.error("Erro ao converter coordenadas:", data.status);
        //   }
        // });
      },
      function (error) {
        console.error("Erro ao obter localização:", error.message);
      }
    );
  } else {
    console.log("Geolocalização não é suportada neste navegador.");
  }
});
