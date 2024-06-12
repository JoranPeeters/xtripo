document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-dismiss="alert"]').forEach(function (button) {
        button.addEventListener('click', function () {
            let alert = button.parentElement;
            alert.style.opacity = '0';
            setTimeout(function () {
                alert.style.display = 'none';
            }, 500);
        });
    });
});