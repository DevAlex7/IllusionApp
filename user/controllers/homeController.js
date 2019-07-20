$(document).ready(function () {
    spinner();
    welcomeInformation();
    
});
function welcomeInformation(){
    var name = new User().Information.get().name;
    var lastname = new User().Information.get().lastname
    var username = new User().Information.get().username
    
    $('#fullname').text(name+" "+lastname);
    $('#email').text(username);
}   
function redirectRequest(){
    location.href ='../../requests/layouts/index.html';
}
function redirectProducts(){
    location.href ='../../products/layouts/index.html';
}
function redirectProfile(){
    location.href ='../../profile/layouts/profile.html';
}
function redirectSecurity(){
    location.href ='../../profile/layouts/reset-password.html';
}
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1000).fadeOut('slow');
    $('.preloader-wrapper')
        .delay(1000)
        .fadeOut();
    });
}
