/* =============================Javascrip du catalog================================ */
// permet de déroulé les filtres
const category = document.getElementById("collapse-categories");
const category_arrow = document.querySelector(".categories-arrow");

const colors = document.getElementById("collapse-colors");
const colors_arrow = document.querySelector(".colors-arrow");

const brands = document.getElementById("collapse-brands");
const brands_arrow = document.querySelector(".brands-arrow");

const tailles = document.getElementById("collapse-tailles");
const tailles_arrow = document.querySelector(".tailles-arrow");

const prices = document.getElementById("collapse-prices");
const prices_arrow = document.querySelector(".prices-arrow");

const promotion = document.getElementById("collapse-promotion");
const promotion_arrow = document.querySelector(".promotion-arrow");


function collapse_category() {
    if (category.style.display === "flex") {
        category.style.display = "none";
        category_arrow.style = "transform: rotate(-45deg)";
    } else {
        category.style.display = "flex";
        category_arrow.style = "transform: rotate(45deg)";
    }

};

function collapse_colors() {
    if (colors.style.display === "flex") {
        colors.style.display = "none";
        colors_arrow.style = "transform: rotate(-45deg)";
    } else {
        colors.style.display = "flex";
        colors_arrow.style = "transform: rotate(45deg)";
    }
};

function collapse_brands() {
    if (brands.style.display === "flex") {
        brands.style.display = "none";
        brands_arrow.style = "transform: rotate(-45deg)";
    } else {
        brands.style.display = "flex";
        brands_arrow.style = "transform: rotate(45deg)";
    }
};

function collapse_tailles() {
    if (tailles.style.display === "grid") {
        tailles.style.display = "none";
        tailles_arrow.style = "transform: rotate(-45deg)";
    } else {
        tailles.style.display = "grid";
        tailles_arrow.style = "transform: rotate(45deg)";
    }
};

function collapse_prices() {
    if (prices.style.display === "grid") {
        prices.style.display = "none";
        prices_arrow.style = "transform: rotate(-45deg)";
    } else {
        prices.style.display = "grid";
        prices_arrow.style = "transform: rotate(45deg)";
    }
};

function collapse_promotion() {
    if (promotion.style.display === "grid") {
        promotion.style.display = "none";
        promotion_arrow.style = "transform: rotate(-45deg)";
    } else {
        promotion.style.display = "grid";
        promotion_arrow.style = "transform: rotate(45deg)";
    }
};

const filterMenu = document.querySelector(".filter-menu");
const showarrow = document.getElementById("filter-arrow");
const hidearrow = document.getElementById("filter-arrow-hide");

function showfilter() {
    filterMenu.style = "display: block";
    hidearrow.style = "display: block";
};

function hidefilter() {
    filterMenu.style = "display: none";
    hidearrow.style = "display: none";
};

var urlParams = new URLSearchParams(window.location.href);

var newUrlSearch=newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter='+filter;
var cat=urlParams.get("cat");
var selectedCategories=Array();
var color=urlParams.get("col");
var selectedColors=Array();
var brand=urlParams.get("brd");
var selectedBrands=Array();
var size=urlParams.get("size");
var selectedSizes=Array();
var price=urlParams.get("prc");
var query=urlParams.get("query");
var filter=urlParams.get("filter");



//---------------SIZES--------------//
var checkboxElems = document.querySelectorAll("input[type='checkbox']");
for (var i = 0; i < checkboxElems.length; i++) {
    checkboxElems[i].addEventListener("click", checkSizes);
}
function checkSizes(e) {
    if (size != null){
        selectedSizes=size.split("y");
        if (selectedSizes.includes(e.target.value.split(",")[0])) {
            selectedSizes.splice(selectedSizes.indexOf(e.target.value.split(",")[0]), 1);
        } else {
            selectedSizes.push(e.target.value.split(",")[0]);
        }
        size=selectedSizes.join("y");
        console.log(size);
    } else {
        size=e.target.value.split(",")[0];
    }
    query=e.target.value.split(",")[1];
    newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter=3';
    document.location.href=newUrlSearch;
}


//---------------PRICE--------------//
var radioElems = document.querySelectorAll("input[type='radio']");
for (var i = 0; i < radioElems.length; i++) {
    radioElems[i].addEventListener("click", checkPrice);
}
function checkPrice(e) {
    query=urlParams.get("query");
    price=e.target.value.split(",")[0];
    query=e.target.value.split(",")[1];
    newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter=3';
    document.location.href=newUrlSearch;
}


//---------------BRANDS--------------//
function checkBrands(id, query) {
    if (brand != null){
        selectedBrands=brand.split("x");
        if (selectedBrands.includes(id)) {
            selectedBrands.splice(selectedBrands.indexOf(id), 1);
        } else {
            selectedBrands.push(id);
        }
        brand=selectedBrands.join("x");
        console.log(brand);
        
    } else {
        brand=id;
    }
    newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter=3';
    console.log(newUrlSearch);
    document.location.href=newUrlSearch;
}


//---------------COLORS--------------//
function checkColors(id, query) {
    id=id.replace('#', '');
    if (color != null){
        selectedColors=color.split("x");
        if (selectedColors.includes(id)) {
            selectedColors.splice(selectedColors.indexOf(id), 1);
        } else {
            selectedColors.push(id);
        }
        color=selectedColors.join("x");
        console.log(color);
        
    } else {
        color=id;
    }
    newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter=3';
    console.log(newUrlSearch);
    document.location.href=newUrlSearch;
}
selectedCategories=cat.split("x");



//---------------CATEGORIES--------------//
function checkCategories(id, quer) {
    query=quer;
    if (cat != null){
        selectedCategories=cat.split("x");
        if (selectedCategories.includes(id)) {
            selectedCategories.splice(selectedCategories.indexOf(id), 1);
        } else {
            selectedCategories.push(id);
        }
        cat=selectedCategories.join("x");
        console.log(cat);
    } else {
        cat=id;
    }
    newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter=3';
    document.location.href=newUrlSearch;
    urlParams = new URLSearchParams(window.location.href);
    console.log(urlParams.get("filter"));
}

let selectFilters=document.getElementsByClassName("sort-by")[0];
function checkFilter(e, query){
    newUrlSearch=baseUrl+"index.php/Search?query="+query+'&cat='+cat+'&col='+color+'&brd='+brand+'&size='+size+'&prc='+price+'&filter='+e;
    document.location.href=newUrlSearch;
    e.setAttribute('selected', true);
}



const selectElement = document.querySelector('.sort-by');
selectElement.value=filter;


function moreProduct() {
    productnumber=productnumber+ 9;
    const items = document.querySelectorAll("li.prod");
    for (let i = 0; i < items.length; i++) {
        //console.log(i,productnumber)
        if (i < productnumber) {
            items[i].classList.remove("hiddenprod");
        } else {

        }
    }
    if(productnumber>items.length){
        document.querySelector(".change-page").classList.add("hiddenprod");
    }
};