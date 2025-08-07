document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-link');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('.fas.fa-chevron-down');
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        });
    });
});