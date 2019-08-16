$(document).ready(function () {
 spinner();   
 $('.carousel').carousel();
});
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1500).fadeOut('slow');
	$('.preloader-wrapper')
		.delay(1500)
		.fadeOut();
    });
}
$('#cardReports').click(function(){
})
