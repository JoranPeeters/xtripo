let map;

async function initMap() {
    const mapElement = document.getElementById("roadtripMap");
    if (!mapElement) {
        console.error("roadtripMap element not found");
        return;
    }

    const { Map, Polyline } = await google.maps.importLibrary("maps", "drawing");
    const { LatLng } = await google.maps.importLibrary("core");

    const encodedPolyline = mapElement.dataset.encodedPolyline;
    const path = google.maps.geometry.encoding.decodePath(encodedPolyline);

    if (!path.length) {
        console.error("No waypoints found");
        return;
    }

    // Get the coordinates of the first waypoint
    const firstWaypoint = path[0];
    const center = {
        lat: firstWaypoint.lat(),
        lng: firstWaypoint.lng()
    };

    map = new Map(mapElement, {
        center: center,
        zoom: 11,
        mapId: "DEMO_MAP_ID",
    });

    const polyline = new Polyline({
        path: path,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2,
    });

    polyline.setMap(map);
}

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
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBmi4b0dEceKxa_3uBRgJWW0tU4kbFvluI&libraries=geometry,drawing&callback=initMap`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

console.log('roadtripConfigurator.js loaded! 🎉');
