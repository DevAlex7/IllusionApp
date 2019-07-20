$(document).ready(function () {
    $('.tabs').tabs();
});

var data = {};

$('#SignIn').submit(function(){
    event.preventDefault();
    try {
        $.post( requestPOST('userEmployees','publicLogin'), $('#SignIn').serialize())
        .done(function(response){
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status){
                    data = {
                        id: result.userInformation.idPublicUser,
                        name: result.userInformation.publicNameUser,
                        lastname: result.userInformation.publicLastnameUser,
                        email: result.userInformation.publicEmail,
                        username: result.userInformation.publicUsernameActive,
                    },
                    localStorage.setItem('user',JSON.stringify(data));
                    redirectTo('user/layouts/home.html')
                }else{
                    ToastError(result.exception);
                }
            }
            else{
                console.log(response);
            }   
        })
        .fail(function(xhr, textStatus, errorThrown){
            alert(xhr.responseText);
        })
    } catch (error) {
        alert(error);
    }
})

$('#Registrer').submit(function(){
    event.preventDefault();
    try {
        $.post( requestPOST('userEmployees','CreatePublicUser'), $('#Registrer').serialize())
        .done(function(response){
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status){
                    ToastSucces("Se ha registrado correctamente");
                    ClearForm('Registrer');
                //redirectTo('user/layouts/home.html')
                }else{
                    ToastError(result.exception);
                }
            }
            else{
                console.log(response);
            }   
        })
        .fail(function(xhr, textStatus, errorThrown){
            alert(xhr.responseText);
        })
    } catch (error) {
        alert(error);
    }
})
