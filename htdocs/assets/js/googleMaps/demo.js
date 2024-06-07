let map;
let center;

async function initMap() {
    const mapElement = document.getElementById("demoMap");
    if (!mapElement) {
        console.error("Map element not found");
        return;
    }

    const { Map } = await google.maps.importLibrary("maps");

    center = { lat: 37.4161493, lng: -122.0812166 };
    map = new Map(mapElement, {
        center: center,
        zoom: 11,
        mapId: "DEMO_MAP_ID",
    });
    findPlaces();
}

async function findPlaces() {
    const { Place } = await google.maps.importLibrary("places");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const request = {
        textQuery: "Coffee",
        fields: ["displayName", "location", "businessStatus"],
        includedType: "restaurant",
        locationBias: { lat: 49.8003, lng: 6.3294 },
        language: "en-US",
        maxResultCount: 8,
        minRating: 3.2,
        region: "us",
        useStrictTypeFiltering: false,
    };
    //@ts-ignore
    const { places } = await Place.searchByText(request);

    if (places.length) {
        console.log(places);

        const { LatLngBounds } = await google.maps.importLibrary("core");
        const bounds = new LatLngBounds();

        // Loop through and get all the results.
        places.forEach((place) => {
            const markerView = new AdvancedMarkerElement({
                map,
                position: place.location,
                title: place.displayName,
            });

            bounds.extend(place.location);
            console.log(place);
        });
        map.fitBounds(bounds);
    } else {
        console.log("No results");
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("demoMap")) {
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

console.log('googleMaps/demo.js loaded! 🎉');
