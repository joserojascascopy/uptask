document.addEventListener('DOMContentLoaded', () => {
    sidebar();
})

function sidebar() {
    const menuMobile = document.querySelector('.menu-mobile');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');

    menuMobile.addEventListener('click', function () {
        sidebar.classList.add('mostrar');
        overlay.classList.add('activo');
    })

    overlay.addEventListener('click', function () {
        overlay.classList.remove('activo');
        sidebar.classList.remove('mostrar');
    })
}