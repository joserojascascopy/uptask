document.addEventListener('DOMContentLoaded', () => {
    sidebar();
});

function sidebar() {
    const menuMobileBtn = document.querySelector('.menu-mobile');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');

    menuMobileBtn.addEventListener('click', function () {
        sidebar.classList.add('mostrar');
        overlay.classList.add('activo');
    });

    overlay.addEventListener('click', function () {
        overlay.classList.remove('activo');
        sidebar.classList.remove('mostrar');
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            overlay.classList.remove('activo');
            sidebar.classList.remove('mostrar');
        }
    });
};