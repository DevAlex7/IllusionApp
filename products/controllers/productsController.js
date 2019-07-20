const products = new Product();
$(document).ready(function () {
 spinner();
 products.get('AllList');

});
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1000).fadeOut('slow');
    
    $('.preloader-wrapper')
        .delay(1000)
        .fadeOut();
    });
}