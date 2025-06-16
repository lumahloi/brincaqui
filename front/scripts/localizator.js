function checkCoordinates() {
  const lat = $("#latitude").val();
  const lng = $("#longitude").val();
  return lat && lng;
}

const API_KEY = "AIzaSyA5W-Sjx-cqEGl3-3QsG5r3AgUTaiUuzdw";
let googleMapsLoaded = false;

$(document).ready(function () {
  if (typeof google === "object" && typeof google.maps === "object") {
    googleMapsLoaded = true;
    initLocalizator();
  } else {
    const script = document.createElement("script");
    script.src = `https://maps.googleapis.com/maps/api/js?key=${API_KEY}&libraries=places&callback=initLocalizator`;
    script.async = true;
    script.defer = true;
    script.onerror = function () {
      console.error("Falha ao carregar a API do Google Maps");
    };
    document.head.appendChild(script);
  }
});

const addressInput = $("input[name='address']");

window.initLocalizator = function () {
  googleMapsLoaded = true;

  initAutocomplete(addressInput[0]);

  getCurrentLocation();
};

function getCurrentLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${API_KEY}`;

        $.get(geocodeUrl, function (data) {
          if (data.status === "OK" && data.results.length > 0) {
            const address = data.results[0].formatted_address;
            addressInput.val(address);
            $("#latitude").val(latitude);
            $("#longitude").val(longitude);
          }
        });
      },
      function (error) {
        console.warn("Erro de geolocalização:", error.message);
      }
    );
  }
}

function initAutocomplete(inputElement) {
  if (!googleMapsLoaded || !window.google.maps.places) {
    console.error("API do Google Maps Places não carregada");
    return;
  }

  const autocomplete = new google.maps.places.Autocomplete(inputElement, {
    types: ["geocode"],
    componentRestrictions: { country: "br" },
  });

  autocomplete.addListener("place_changed", function () {
    const place = autocomplete.getPlace();
    if (place.formatted_address) {
      addressInput.val(place.formatted_address);
      if (place.geometry && place.geometry.location) {
        $("#latitude").val(place.geometry.location.lat());
        $("#longitude").val(place.geometry.location.lng());

        $(document).trigger("coordinates:updated");
      }
    }
  });

  google.maps.event.addDomListener(inputElement, "keydown", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
    }
  });
}
