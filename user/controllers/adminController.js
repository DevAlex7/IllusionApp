var profile = new User();
$(document).ready(function () {
 spinner();   
 $('.carousel').carousel();
 getProfile();
});
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1500).fadeOut('slow');
	$('.preloader-wrapper')
		.delay(1500)
		.fadeOut();
    });
}
const getProfile = () => {
    const name = profile.Information.get().name;
    $('#personalTitle').text('Hello, '+name);
    const username = profile.Information.get().username;
    $('#personalTitleUsername').text(username);
}
$('#cardRequest').click(function(){
    location.href='requests.html';
})
$('#cardEstadistics').click(function(){
    location.href='stadistics.html';
})

