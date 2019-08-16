//variable para guardar los intentos
var tries = 0;
//variable para tiempo
var time = 0;
$(document).ready(function () {
    $('.tabs').tabs();
});

var data = {};
$('#SignIn').submit(function(){
    event.preventDefault();
    try {
        $.post( requestPOST('userEmployees','publicLogin'), $('#SignIn').serialize() )
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
                        role : result.userInformation.publicRole
                    };

                    if(data.role == 1 || data.role == 0){
                        localStorage.setItem('user',JSON.stringify(data));
                        redirectTo('user/layouts/admin/index.html')
                    }
                    else{
                        localStorage.setItem('user',JSON.stringify(data));
                        redirectTo('user/layouts/home.html')
                    }
                    
                }else{
                    //acumulador de intentos
                    tries ++;
                    //condicional
                    if(tries < 3){
                        //dira los mensajes de error
                        ToastError(result.exception);
                    }
                    else{
                        //se bloqueara
                        ToastSucces('Tu acceso ha sido bloqueado, espera 3 minutos');
                        setInterval(setTime,60000);
                        $('#LoginButton').addClass('disabled');

                    }
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
function setTime(){
    time++;
    if(time > 0){
        $('#LoginButton').removeClass('disabled');
        time = 0;
    }
}