class User{
    Information = {
        get(){
            var data = JSON.parse(localStorage.getItem('user'));
            return {
                id : data.id,
                name : data.name,
                lastname :data.lastname,
                email :data.email,
                username : data.username
            }
        }
    }    
    
}