// // public/js/vehicle-models.js

// public/js/vehicle-models.js

// document.addEventListener('DOMContentLoaded', () => {
//     const vehicleTypeSelect = document.querySelector('.vehicle-type-select');
//     if (vehicleTypeSelect) {
//         vehicleTypeSelect.addEventListener('change', function() {
//             const vehicleType = this.value;
//             fetch('/get-vehicle-models', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                 },
//                 body: JSON.stringify({ vehicle_type: vehicleType }),
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     const modelSelect = document.querySelector('#roadtrip_vehicle_model');
//                     modelSelect.innerHTML = '';
//                     for (const [key, value] of Object.entries(data)) {
//                         const option = document.createElement('option');
//                         option.value = value;
//                         option.textContent = key;
//                         modelSelect.appendChild(option);
//                     }
//                 });
//         });
//     }
// });

