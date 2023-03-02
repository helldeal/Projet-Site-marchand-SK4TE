/*===============================Javascript de la page home===================================
* 
*/
// Quand on scroll montre le logo et la srcbar
const title = document.querySelector(".header-title");
const srcbarBackground = document.getElementById("cover");
window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    if (scrolled >= 400.0) {
        srcbarBackground.classList.add("backIsVisible");
        title.classList.add('isVisible');
    } else {
        srcbarBackground.classList.remove('backIsVisible');
        if (window.innerWidth >= 800) {
            title.classList.remove('isVisible');
        }
    }
});

// Change la position du logo skate quand on scroll

const logo = document.querySelector(".logoskate");

window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    if (window.innerWidth >= 1250) {
        x = -15 + (scrolled / 8)
    } else if (window.innerWidth >= 900) {
        x = -20 + (scrolled / 8)
    } else {
        x = -30 + (scrolled / 8)
    }
    if (x < 120) {
        logo.style = `top: ${x}%`;
    }
    if (scrolled >= 700.0) {
        nav.classList.add('nav3');
    } else {
        nav.classList.remove('nav3');
    }
});
// change la couleur du background a partir d'un moment du scroll
const showcase = document.getElementById("showcase");
window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;

    y = window.innerWidth
    if (window.innerWidth > 2500) {
        y = y * 1.3

    } else if (window.innerWidth > 2000) {
        y = y * 1

    } else if (window.innerWidth > 1800) {
        y = y * 0.7

    } else if (window.innerWidth > 1400) {
        y = y * 1

    } else if (window.innerWidth > 1050) {
        y = y * 1.1

    } else if (window.innerWidth > 900) {
        y = y * 1.8
    } else if (window.innerWidth > 700) {
        y = y * 2.3
    } else if (window.innerWidth > 500) {
        y = y * 2.8
    } else {
        y = y * 3.4
    }

    if (scrolled >= 2700.0 + y) {
        x = 255 - (scrolled - (2700 + y))
        if (x <= 25) {
            x = 25
        }
        if (x < 247) {
            showcase.style = `background-color: rgb(${x},${x},${x})`;
        }
    } else {
        showcase.style = `background-color: rgb(255,255,255)`;
    }
});

// quand on scroll fait apparaître productdisplay en arrivant par la gauche

const productdisplay1 = document.getElementById("productdisplay1");
window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    if (scrolled >= 550.0) {
        productdisplay1.classList.add("isVisible");
    } else {
        productdisplay1.classList.remove("isVisible");
    }
    if (window.innerWidth >= 950) {
        if (scrolled >= 350.0) {
            x = (scrolled - 500.0) / 30;
            if (window.innerWidth <= 1150) {
                if (x >= -20) {
                    x = -20;
                }
            }
            if (window.innerWidth <= 1200) {
                if (x >= -15) {
                    x = -15;
                }
            } else {
                if (x >= -0) {
                    x = -00;
                }
            }
            productdisplay1.style = `left: ${x}%;`;
        } else {
            productdisplay1.style = "left: -100%"
        }
    }
});

// quand on click sur les flèches permet de changer l'image du slider

var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
    showDivs(slideIndex += n);
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("slide");
    if (n > x.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = x.length };
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[slideIndex - 1].style.display = "block";
}


// event quand on arrive au niveau du container, celui-ci est affiché
const grid = document.querySelector(".grid-container");

window.addEventListener('scroll', () => {
    var observer = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting === true)
            grid.style = "filter :opacity(100);";
        else
            grid.style = "filter :opacity(0);";
    }, { threshold: [0] });

    observer.observe(document.querySelector(".grid-container"));
});

const carousel = document.querySelector(".carousel-container");

window.addEventListener('scroll', () => {
    var observer = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting === true)
            carousel.style = "filter :opacity(100);";
        else
            carousel.style = "filter :opacity(0);";
    }, { threshold: [0] });

    observer.observe(document.querySelector(".carousel-container"));
});


