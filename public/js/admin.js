
let selected = document.querySelectorAll('.selected');
let container = document.querySelectorAll('.container');
//Quand la page s'ouvre
const scrolled = window.scrollY;
	var height = 0;
	for (let i = 0; i < container.length; i++) {
		if (scrolled>=height && scrolled<=height+container[i].offsetHeight){
			selected[i].style.display = 'block'
		}else{
			selected[i].style.display = 'none'
		}
		height+=container[i].offsetHeight;
	}

//Quand ca scroll
window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
	var height = 0;
	for (let i = 0; i < container.length; i++) {
		if (scrolled>=height && scrolled<=height+container[i].offsetHeight){
			selected[i].style.display = 'block'
		}else{
			selected[i].style.display = 'none'
		}
		height+=container[i].offsetHeight;
	}
	
    
});

//GESTION OVERLAY POP UP

let adminoverlays = document.querySelectorAll('.adminoverlays');

function openAdminoverlays(element) {
	var increment = 0.1;
    var scale = 0;
	document.getElementById(element).style.scale = scale
    document.getElementById(element).style.display = "flex	";
    var instance = window.setInterval(function() {
        document.getElementById(element).style.scale = scale
        scale = scale + increment;
        if(scale > 1){
            window.clearInterval(instance);
        }
    },1)
    document.getElementById("overlay").classList.add("isVisible");
    document.body.classList.add("notScrollable");
}
function closeAdminoverlays() {
	adminoverlays.forEach(element => {
		element.style.display = "none";	
	});
    document.getElementById("overlay").classList.remove("isVisible");
    document.body.classList.remove("notScrollable");
}


//EVENT FERMETURE
document.addEventListener("click", (e) => {
    let clickedElem = e.target;
    let overlay = document.getElementById("overlay");
    if (clickedElem  == overlay) {
        closeAdminoverlays();
    }
});



$(document).ready(function(){

	//POP UP DELETE
	let del = $('a.remove-btn');

	$(del).each(function(){
		$(this).on('click', function(e){
			e.preventDefault(); 

			let link = $(this);
			let target = $(this).attr('href');

			Swal.fire({
				title: 'Confirmez vous la suppression?',
				text: 'Cette action est irréversible',
				icon: 'warning',
				confirmButtonColor: 'rgb(70, 142, 235)',
				iconColor:'rgb(70, 142, 235)',
				color:'#fff',
				cancelButtonColor: '#d33',
				background:'rgb(39, 39, 39)',
				showCancelButton: true,
				confirmButtonText: 'Supprimer',
				cancelButtonText: 'Annuler',
			}).then((result) => {
				if(result.value){

					fetch(target, {method: 'get'}).then(response => response.json()).then(message => {
                        console.log(message.success);
                        if (message.success.includes("suppr")){
                            Swal.fire({
								background:'rgb(39, 39, 39)',
								color:'#fff',
                                title: 'Suppression réussite !',
                                html: '<p>'+message.success+'</p>',
                                icon: 'success',
								showConfirmButton: false,
								timer: 2000,
								timerProgressBar: true,
                            });
                            setTimeout(() => { document.location.reload(true); }, 2000);
                        } else {
                            Swal.fire({
								background:'rgb(39, 39, 39)',
								color:'#fff',
								showConfirmButton: false,
								timer: 2000,
								timerProgressBar: true,
                                title: 'Echec de suppression !',
                                html: '<p>'+message.success+'</p>',
                                icon: 'error',
								confirmButtonColor: 'rgb(70, 142, 235)',
                            });
                        }
                        

					});
					$(link).closest('tr').fadeOut();
				}
			}).catch(err => {
				console.log(err);
				Swal.fire({

					title: 'Oups!',
					text: 'Un erreur est survenue.',
					icon: 'error',
					timer: 2000,
					timerProgressBar: true,
				});
			});
		});
	});

	//POP UP UPDATE / ADD
	let form = $('form.Add');

	$(form).on('submit', function(e){
		e.preventDefault();
        closeAdminoverlays();
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			data: $(this).serialize(),
			dataType: 'json',
			success: function(response){
				console.log(response);
				if(response.errors){
					let errorString = '';
					$.each(response.errors, function(key, value){
						errorString += '<p>'+value+'</p>';
					});
					Swal.fire({
						background:'rgb(39, 39, 39)',
						color:'#fff',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						title: 'Erreur d\'ajout !',
						html: errorString,
						icon: 'error',
					});
				}

				if(response.success){
					Swal.fire({
						background:'rgb(39, 39, 39)',
						color:'#fff',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						title: 'Ajout réussi !',
						text: response.success,
						icon: 'success',
					})
					setTimeout(() => { document.location.reload(true); }, 2000);
				}
			},
			error: function(err){
				console.log(err);
			}
		});
	});


	
});



