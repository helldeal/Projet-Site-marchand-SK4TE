var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");



function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Les mots de passe ne correspondent pas");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;



const border_sign = document.getElementById("border-sign-title");
const border_conn = document.getElementById("border-conn-title");
const sign = document.getElementById("button-sign");
const conn = document.getElementById("button-conn"); 
const title_conn = document.getElementById("log-conn");
const title_sign = document.getElementById("log-sign");
document.addEventListener("click", (e) => {
  let clickElem=e.target;
  if (clickElem==sign){
    title_sign.style.transform="translate(-50%,0%)"
    title_conn.style.transform="translate(-120%,0%)"
    border_sign.style.width="100%"
    border_conn.style.width="0px"
    border_sign.style.opacity="100"
    border_conn.style.opacity="0"
    border_sign.style.transitionDelay="0s,0s"
    border_conn.style.transitionDelay="0s,0.4s"
  };
  if(clickElem==conn){
    title_sign.style.transform="translate(100%,0%)"
    title_conn.style.transform="translate(50%,0%)"
    border_conn.style.width="100%"
    border_sign.style.width="0px"
    border_sign.style.opacity="0"
    border_conn.style.opacity="100"
    border_conn.style.transitionDelay="0s,0s"
    border_sign.style.transitionDelay="0s,0.4s"
  };
});

var pass_sign = document.querySelector('input.pass-sign');
pass_sign.oninvalid = function(e) {
	e.target.setCustomValidity("");
	if (!e.target.validity.valid) {
		if (e.target.value.length == 0) {
e.target.setCustomValidity("");
		} else {
e.target.setCustomValidity("Votre mot de passe doit contenir 8 caractères dont : 1 majuscule, 1 minuscule, 1 chiffre");
		}
	}
};

var id_sign = document.querySelector('input.id-sign');
id_sign.oninvalid = function(e) {
	e.target.setCustomValidity("");
	if (!e.target.validity.valid) {
		if (e.target.value.length == 0) {
e.target.setCustomValidity("");
		} else {
e.target.setCustomValidity("Votre identifiant doit contenir entre 3 et 15 caractères.");
		}
	}
};
