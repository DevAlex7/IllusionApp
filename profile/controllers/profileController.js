const person = new Profile();
$(document).ready(function () {
    spinner();
    person.viewInformation();
    person.editInformation();
    //person.get('AllList')
});
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1500).fadeOut('slow');
	$('.preloader-wrapper')
		.delay(1500)
		.fadeOut();
    });
}
$('#closeSesion').click(function(e){
    localStorage.removeItem('user');
    person.route.login();
})
$('#editInformation').click(function (e) { 
    person.route.editProfile();
});

$('#backEdit').click(function(e){
    person.route.profile();
})

$('#backProfile').click(function(e){
    person.route.home();
})  

$('#editProfileForm').submit(function(e){
    
    event.preventDefault();
    
    const data = {
        id : parseInt($('#id').val()),
        name : $('#name').val(),
        lastname : $('#lastname').val(),
        email : $('#email').val(),
        username : $('#username').val()
    }

    person.put('updateProfile', data);
    $('#editProfile').addClass('disabled');
})