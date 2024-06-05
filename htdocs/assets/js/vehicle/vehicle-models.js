// assets/js/vehicle/vehicle-models.js

document.addEventListener('DOMContentLoaded', function() {
    const vehicleSelect = document.querySelector('#roadtrip_vehicle');
    const fuelTypeSelect = document.querySelector('#roadtrip_fuel_type');
    const modelSelect = document.querySelector('#roadtrip_model');

    vehicleSelect.addEventListener('change', function() {
        const vehicleId = this.value;
        
        // Fetch the fuel types and models for the selected vehicle
        fetch(`/get-vehicle-data/${vehicleId}`)
            .then(response => response.json())
            .then(data => {
                // Update fuel type options
                fuelTypeSelect.innerHTML = '';
                data.fuel_types.forEach(fuelType => {
                    const option = document.createElement('option');
                    option.value = fuelType;
                    option.textContent = fuelType;
                    fuelTypeSelect.appendChild(option);
                });

                // Update model options
                modelSelect.innerHTML = '';
                data.models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            });
    });
});
