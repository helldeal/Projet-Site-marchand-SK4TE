var content_form_pseudo=document.getElementById('content-form-pseudo');
var content_form_password =document.getElementById('content-form-pass');
var button_pass=document.getElementById('modifpass');
var arrow_modifpass = document.getElementById('arrow_modifpass');

function display_modifpass(){
  if(content_form_password.style.display==="flex"){
    content_form_password.style.display="none";
    arrow_modifpass.style.transform="rotate(-45deg)";
  }else{
    content_form_password.style.display="flex";
    arrow_modifpass.style.transform="rotate(-135deg)";
  }
}