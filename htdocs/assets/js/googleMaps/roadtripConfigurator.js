document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("roadtripMap")) {
        loadGoogleMapsScript(initMap);
    }
});

function loadGoogleMapsScript(callback) {
    if (typeof google === 'object' && typeof google.maps === 'object') {
        callback();
        return;
    }

    window.initMap = callback;

    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBmi4b0dEceKxa_3uBRgJWW0tU4kbFvluI&libraries=geometry,drawing,places&callback=initMap`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

let map;
let waypointTitles = [];

function initMap() {
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();

    // Get the select elements
    const startSelect = document.getElementById("start");
    const waypointsSelect = document.getElementById("waypoints");
    const endSelect = document.getElementById("end");

    // Set the start to the first waypoint
    if (startSelect.options.length > 0) {
        startSelect.selectedIndex = 0;
    }

    // Set the end to the last waypoint
    if (endSelect.options.length > 0) {
        endSelect.selectedIndex = endSelect.options.length - 1;
    }

    // Get the first waypoint's coordinates to set the map center
    const firstWaypointValue = startSelect.options[startSelect.selectedIndex].value;
    const [firstWaypointLat, firstWaypointLng] = firstWaypointValue.split(',').map(Number);

    map = new google.maps.Map(document.getElementById("roadtripMap"), {
        zoom: 10,
        center: { lat: firstWaypointLat, lng: firstWaypointLng },
    });

    directionsRenderer.setMap(map);

    // Automatically calculate and display the route when the map is initialized
    calculateAndDisplayRoute(directionsService, directionsRenderer);

    document.getElementById("submit").addEventListener("click", () => {
        calculateAndDisplayRoute(directionsService, directionsRenderer);
    });
}

function calculateAndDisplayRoute(directionsService, directionsRenderer) {
    const waypts = [];
    const start = document.getElementById("start").value;
    const end = document.getElementById("end").value;
    const startTitle = document.getElementById("start").selectedOptions[0].getAttribute('data-title');
    const endTitle = document.getElementById("end").selectedOptions[0].getAttribute('data-title');
    const checkboxArray = document.getElementById("waypoints");

    // Reset the waypoint titles array
    waypointTitles = [startTitle];

    for (let i = 0; i < checkboxArray.length; i++) {
        if (checkboxArray.options[i].selected) {
            waypts.push({
                location: checkboxArray[i].value,
                stopover: true,
            });
            waypointTitles.push(checkboxArray.options[i].getAttribute('data-title'));
        }
    }

    // Add the end title to the waypoint titles array
    waypointTitles.push(endTitle);

    directionsService.route({
        origin: start,
        destination: end,
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING,
    })
    .then((response) => {
        directionsRenderer.setDirections(response);

        const route = response.routes[0];
        const summaryPanel = document.getElementById("directions-panel");

        summaryPanel.innerHTML = "";

        // For each route, display summary information.
        for (let i = 0; i < route.legs.length; i++) {
            const routeSegment = i + 1;

            summaryPanel.innerHTML +=
                `<b>Route Segment: ${routeSegment}</b><br>`;
            summaryPanel.innerHTML += `${waypointTitles[i]} to ${waypointTitles[i + 1]}<br>`;
            summaryPanel.innerHTML += `Distance: ${route.legs[i].distance.text}<br>`;
            summaryPanel.innerHTML += `Duration: ${route.legs[i].duration.text}<br><br>`;
        }
    })
    .catch((e) => {
        console.error("Directions request failed due to: ", e);
        window.alert("Directions request failed due to: " + e.message);
    });
}