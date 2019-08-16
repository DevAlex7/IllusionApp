class Profile extends User {
    
    constructor(){
        super();
        //emailjs.init("user_AsWDa2hloMuYb0pdQrffY");
    }
    
    //apiPut ='https://playaes.000webhostapp.com/Api/userEmployees.php?request=PUT&action=';
    apiPut ='../api/userEmployees.php?request=PUT&action=';
    
    route = {
        
        loginView:'../../index.html',
        homeView:'../../user/layouts/home.html',
        editView :'edit-profile.html',
        profileView : 'profile.html',
        resetView:'reset-password.html',

        login(){
            $(location).attr('href',this.loginView);
        },
        
        home(){
            $(location).attr('href',this.homeView);
        },

        editProfile(){
            $(location).attr('href',this.editView);
        },

        profile(){
            $(location).attr('href',this.profileView);
        },

        resetPassword(){
            $(location).attr('href',this.resetView);
        }
    }
    viewInformation(){
        
        var User = {
            name : this.Information.get().name,
            lastname : this.Information.get().lastname,
            email : this.Information.get().email,
            username : this.Information.get().username
        }
        $('#name').html(`<i class="material-icons left">account_circle</i>`+User.name);
        $('#lastname').html(`<i class="material-icons left">account_circle</i>`+User.lastname);
        $('#email').html(`<i class="material-icons left">mail</i>`+User.email);
        $('#username').html(`<i class="material-icons left">verified_user</i>`+User.username);
        
    }

    editInformation(){
        
        var User = {
            id : this.Information.get().id,
            name : this.Information.get().name,
            lastname : this.Information.get().lastname,
            email : this.Information.get().email,
            username : this.Information.get().username
        }

        $('#id').val(User.id);
        $('#name').val(User.name);
        $('#lastname').val(User.lastname);
        $('#email').val(User.email);
        $('#username').val(User.username);

    }
    
    get(endpoint){
        switch (endpoint) {
            case 'AllList':
                fetch(this.apiGet + endpoint)
                .then(response => response.json())
                .then(data => {
                  console.log(data) // Prints result from `response.json()` in getRequest
                })
                .catch(error => console.error(error)) 
                break;        
            default:
                break;
        }
    }   
    post(){

    }
    async put(endpoint, data){
        if(data == '' || data == null){
            alert("entro aqui");
        }
        else{
            switch(endpoint){
                
                case 'updateProfile':
                   $.post(this.apiPut + endpoint, data , function(response){
                       if(isJSONString(response)){
                            const result = JSON.parse(response);
                            if(result.status){
                                
                                localStorage.removeItem('user');
                                person.route.login();                  
                            }
                            else{
                                ToastError(result.exception);
                            }
                       }else{
                            console.log(response);
                       }
                   })
                break;
                case 'resetPassword':
                    $.post(this.apiPut + endpoint, data, function(response){
                        if(isJSONString(response)){
                            const result = JSON.parse(response);
                            if(result.status){
                                $(location).attr('href','../../index.html');
                            }
                            else{
                                ToastError(result.exception);
                            }
                        }
                        else{
                            console.log(response);
                        }
                    })
                break;
            }
        }
    }
    delete(){

    }
}