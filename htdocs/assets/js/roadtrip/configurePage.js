document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('[data-day]');
    const waypoints = document.querySelectorAll('.waypoint');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const day = button.getAttribute('data-day');
            console.log(`Button for Day ${day} clicked`);

            // Highlight the selected button
            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Show/hide waypoints based on the selected day
            waypoints.forEach(waypoint => {
                if (waypoint.getAttribute('data-day') === day) {
                    waypoint.style.display = 'block';
                } else {
                    waypoint.style.display = 'none';
                }
                console.log(`Waypoint for Day ${waypoint.getAttribute('data-day')} set to ${waypoint.style.display}`);
            });
        });
    });
});