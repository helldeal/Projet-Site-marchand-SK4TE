const selector = document.getElementById("sizeSelector");
var id = document.getElementById("numprod").textContent.split(": ")[1];
var color=window.location.href.split('color=')[1].split('&size')[0];


selector.addEventListener("change", function() {
    var size=selector.value;
    var newUrl=baseUrl+"index.php/Product/display/"+id+"?color="+color+'&size='+size; 
    document.location.href=newUrl;
    document.getElementById("sizeSelector").value=size;
});

function replacePic() {
    document.getElementById("add-pic").submit();
}

function getFile(){
    document.getElementById("fileOpen").click();
}
