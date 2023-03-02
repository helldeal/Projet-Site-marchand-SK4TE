/* =============================Javascript du produit=================================== */
// Quand on click sur une image, l'image clické devient l'image focus 
const focusImg = document.getElementById("focus-image");
var smallImages = document.getElementsByClassName('small-img');

window.addEventListener("load",function() {
    focusImg.style.backgroundImage = smallImages[0].style.backgroundImage;
});

for (let i = 0; i < smallImages.length; i++) {
    smallImages[i].onclick = function () {
        console.log(i);
        let x = smallImages[i]
        focusImg.style.backgroundImage = x.style.backgroundImage;

    }
};

// permet de déroulé les descriptions 
const description = document.getElementById("description");
const description_arrow = document.getElementById("description-arrow");

const brand = document.getElementById("collapse-brand");
const brand_arrow = document.getElementById("collapse-brand-arrow");

const shipping = document.getElementById("shipping");
const shipping_arrow = document.getElementById("shipping-arrow");


function collapse_description() {
    if (description.style.display === "flex") {
        description.style.display = "none";
        description_arrow.style = "transform: rotate(-45deg)";
    } else {
        description.style.display = "flex";
        description_arrow.style = "transform: rotate(45deg)";
    }

};

function collapse_shipping() {
    if (shipping.style.display === "flex") {
        shipping.style.display = "none";
        shipping_arrow.style = "transform: rotate(-45deg)";
    } else {
        shipping.style.display = "flex";
        shipping_arrow.style = "transform: rotate(45deg)";
    }
}

function collapse_brand() {
    if (brand.style.display === "flex") {
        brand.style.display = "none";
        brand_arrow.style = "transform: rotate(-45deg)";
    } else {
        brand.style.display = "flex";
        brand_arrow.style = "transform: rotate(45deg)";
    }
}