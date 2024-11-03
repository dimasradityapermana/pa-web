document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('switch-theme');
    button.addEventListener('click', () => {
        document.body.classList.toggle('dark-theme');
    });
});

const hamburger = document.querySelector(".hamburger")
const rightheader = document.querySelector(".right-header")

hamburger.addEventListener("click", () => {
    rightheader.classList.toggle("show");
})
