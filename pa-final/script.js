document.addEventListener('DOMContentLoaded', () => {
    const buttonDesktop = document.getElementById('switch-theme-desktop');
    const buttonMobile = document.getElementById('switch-theme-mobile');
    
    const toggleTheme = () => {
        document.body.classList.toggle('dark-theme');
        var section1 = document.querySelector('.section-1');
        if (document.body.classList.contains('dark-theme')) {
            section1.style.backgroundImage = 'url(assets/welcome-dark.png)';
        } else {
            section1.style.backgroundImage = 'url(assets/welcome.png)';
        }
    };

    buttonDesktop.addEventListener('click', toggleTheme);
    buttonMobile.addEventListener('click', toggleTheme);
});

var slideIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("image-source");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
        x[i].style.transition = "opacity 5s";
        x[i].style.opacity = 0;
    }
    slideIndex++;
    if (slideIndex > x.length) {slideIndex = 1} 
    x[slideIndex-1].style.display = "block"; 
    x[slideIndex-1].style.opacity = 1; 
    setTimeout(carousel, 3000); 
}

