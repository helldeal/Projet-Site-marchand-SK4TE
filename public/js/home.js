/*================variables declartion===================*/

const srcbar = document.getElementById('srcbar');
const nav = document.querySelector('nav');
const under = document.getElementById('undercontainer');
let navlink = document.querySelectorAll('.nav-link');
let navitems = document.querySelectorAll('.nav-item');
const menubtn = document.querySelector('.menu-btn');
const navlinks = document.querySelector('.nav-links');
const srcbarBackgroundGeneral = document.getElementById("cover");
const titleGeneral = document.querySelector(".header-title");



/*===================underline when hover==============================
* Add span when hover
* The span is just an underline
*/

for (const navitem of navitems) {
    let span = document.createElement('span');
    navitem.appendChild(span);
    navitem.addEventListener('mouseover', () => {
        span.classList.add('hover');
    });

    navitem.addEventListener('mouseleave', () => {
        span.classList.remove('hover')
    });
};

/*====================Event when click on the search bar====================
* Get the position of the mouse to tell if the click is on the srcbar
* Then if it's clicked blur the page and other things...
* After the event if clicked outside remove the blur effect
*/
document.addEventListener("click", (e) => {
    let clickedElem = e.target;
    do {
        if (clickedElem == srcbar) {
            document.body.style.background = "url(<?=base_url().'public/js/wallpaperflareblur.jpg' ?>) center fixed";
            nav.classList.add('nav2');
            nav.classList.remove('nav');
            under.classList.add('under-container2');
            srcbarBackgroundGeneral.classList.add("backIsVisible");
            titleGeneral.classList.add('isVisible');
            for (const navlk of navlink) {
                navlk.classList.add('nav-link2');
            }
            return;
        }
        clickedElem = clickedElem.parentNode;
    } while (clickedElem);
    srcbarBackgroundGeneral.classList.remove("backIsVisible");
    titleGeneral.classList.remove('isVisible');
    document.body.style.background = "url(<?=base_url().'public/js/wallpaperflare.jpg' ?>) center fixed";
    document.body.style = "background-size: cover;"
    nav.classList.remove('nav2');
    nav.classList.add('nav');
    under.classList.remove('under-container2');
    for (const navlk of navlink) {
        navlk.classList.remove('nav-link2')
    }
});

/*===============================Preloader===================================
* Before every elements are loaded, a loading page apears
* then it disapears when all elements are loaded
*/

//const loader = document.getElementById("preloader");
window.addEventListener("load",function() {
    document.getElementById("preloader").style = "opacity: 0";
    setTimeout(function() {
        document.getElementById("preloader").style.transform = "translateX(100%)";
        if(window.innerWidth <= 800) {
            titleGeneral.classList.add('isVisible');
        }
    }, 500);
});

/*===============================Event when scroll===================================
* When scroll until 860 add class "nav3" into nav
* It darkens the nav
*/
window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    if(scrolled>=200.0) {
        nav.classList.add('nav3');
    } else {
        nav.classList.remove('nav3');
    }
});
/*===============================Responsive (screen <= 800px)===================================*/
menubtn.addEventListener("click", () => {
    navlinks.classList.toggle("mobile-menu");
});
/*===============================Responsive (screen <= 800px)===================================*/
window.addEventListener('resize', () => {
    if(window.innerWidth <= 800) {
        titleGeneral.classList.add('isVisible');
    } else {
        titleGeneral.classList.remove('isVisible');
    };
}, true);