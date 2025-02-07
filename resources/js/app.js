import "bootstrap/dist/js/bootstrap.min.js";
import "jquery.quicksearch/dist/jquery.quicksearch.min.js";

// Hide alert after 5 seconds
window.setTimeout(function() {
    let alert = document.querySelector('.fade-out');
    if (alert) {
        alert.animate([
            { opacity: 1 },
            { opacity: 0 }
        ], {
            duration: 1000
        });

        window.setTimeout(function() {
            alert.style.display = 'none';
        }, 1000);
    }
}, 5000);

document.addEventListener('DOMContentLoaded', function() {
    const DeviceSortBy = document.getElementById('DeviceSort');

    if (!DeviceSortBy) return;

    DeviceSortBy.addEventListener('change', function() {
        localStorage.setItem('sort', this.value);
    });

    let sort = localStorage.getItem('sort');
    if (sort) {
        DeviceSortBy.value = sort;
        DeviceSortBy.dispatchEvent(new Event('change'));
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const darkMode = document.querySelector('.dark-mode');
    const lightMode = document.querySelector('.light-mode');
    const body = document.querySelector('body');
    const switchMode = document.querySelector('.themeButton');

    if (switchMode) {
        switchMode.addEventListener('click', () => {
            if (body.dataset.bsTheme === 'dark') {
                body.dataset.bsTheme = '';
                localStorage.setItem('theme', 'light');
                darkMode.classList.remove('d-none');
                lightMode.classList.add('d-none');
            } else {
                body.dataset.bsTheme = 'dark';
                localStorage.setItem('theme', 'dark');
                lightMode.classList.remove('d-none');
                darkMode.classList.add('d-none');
            }

        });
    }

    if (localStorage.getItem('theme') === 'dark') {
        body.dataset.bsTheme = 'dark';
        if (darkMode) darkMode.classList.add('d-none');
    } else {
        body.dataset.bsTheme = '';
        if (lightMode) lightMode.classList.add('d-none');
        darkMode.classList.remove('d-none');
    }
});