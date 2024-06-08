src="https://cdn.jsdelivr.net/npm/flatpickr"

document.addEventListener("DOMContentLoaded", function() {
    flatpickr(".date-picker", {
        dateFormat: "d/m/Y", // Customize the date format as needed
        locale: {
            firstDayOfWeek: 1 // Start the week on Monday
        },
        altInput: true,
        altFormat: "F j, Y",
    });
});