class Request{

    //Rutas de api local
    getApi = '../../api/Request.php?request=GET&action=';
    //ruta api para enviar información
    postApi = '../../api/Request.php?request=POST&action=';

    //Rutas de api local
    //getApi = 'https://playaes.000webhostapp.com/Api/Request.php?request=GET&action=';
    //ruta api para enviar información
    //postApi = 'https://playaes.000webhostapp.com/Api/Request.php?request=POST&action=';
    

    //rutas de paginación
    routes = {
        viewRequest:'requestpage.html'
    }

    //metodo para ir a pagina de solicitud
    viewRequest(){
        $(location).attr('href',this.routes.viewRequest);
    }
    //Obtener el id de la respuesta seleccionada
    getRequestId(id){
        localStorage.setItem('idRequest',id);
    }   

    get(endpoint){
        switch(endpoint){
           
        }
    }

    //Metodo post
    post(endpoint){
        
        switch(endpoint){
            //Metodo para verificar el estado de la solicitud        
            case 'verifyStatus':
                
                    var id = new User().Information.get().id;
                    var id_request = localStorage.getItem('idRequest');
                    var idstatus;        
            
                    const bodyRequest = { 
                        user_id : id,
                        request_id : id_request
                    }
            
                    $.post(this.postApi + endpoint, bodyRequest, function(data){
            
                        if(isJSONString(data)){
                            var result = JSON.parse(data);
                            if(result.status){
                                idstatus = result.dataset.idStatus;
                                if(idstatus == 1){
                                    $('#chip').text("Solicitud: Aceptada").addClass('green accent-4 white-text')
                                    $('#btnRP').removeClass('disabled')
                                    $('#titleProducts').addClass('green accent-4 white-text')
                                }
                                else if(idstatus == 2){
                                    $('#chip').text("Solicitud: Rechazada").addClass('red white-text');
                                    $('#btnRP').addClass('disabled')
                                    $('#titleProducts').addClass('red white-text')
                                }
                                else{
                                    $('#chip').text("Solicitud: Pendiente")
                                    $('#btnRP').addClass('disabled')
                                    $('#titleProducts').addClass('grey white-text')
                                }
                            }
                            else{
                                ToastError(result.exception);
                            }
                        }
                        else{
                            console.log(data);
                        }

                    })
            break;
            //Mostrar los productos que no existen en la tabla de los productos de la solicitud
            case 'productsInNotListRequest':

                    var id_request = localStorage.getItem('idRequest');
                    const list_id_request ={
                        id : id_request
                    }
                    $.post(this.postApi + endpoint, list_id_request ,function(response){
                        if (isJSONString(response)) {
                            const Select = 'product';
                            const value = null;
                            const result = JSON.parse(response);
                            if (result.status) {
                                let content = '';
                                if (!value) {
                                    content += '<option value="" disabled selected>Seleccione un producto</option>';
                                }
                                result.dataset.forEach(function(row){
                                    if (row.id != value) {
                                        content += `<option value="${row.id}">${row.nameProduct}</option>`;
                                    } else {
                                        content += `<option value="${row.id}" selected>${row.nameProduct}</option>`;
                                    }
                                });
                                $('#' + Select).html(content);
                            } else {
                                $('#' + Select).html('<option value="">No hay tipos de eventos</option>');
                            }
                            $('select').formSelect();
                        } else {
                            console.log(response);
                        }
                    })
                break;

            //Obtener toda la información de la solicitud seleccionada
            case 'getmyRequest':
                var id = localStorage.getItem('idRequest')

                const myRequest = {
                    id : id
                }
                
                $.post(this.postApi + endpoint, myRequest, function(response){
                    if(isJSONString(response)){
                        var result = JSON.parse(response)
                        if(result.status){
                            $('#titlebar').text(result.dataset.name_event);
                            $('#persons').text("Cantidad de personas: "+result.dataset.persons);
                            $('#typeEvent').text("Tipo de evento: "+result.dataset.type);
                            $('#descriptionEvent').text("Descripción: "+result.dataset.description_event);
                        }
                        else{
                            ToastError(result.exception);
                        }
                    }else{
                        console.log(response);
                    }
                })
            break;
            //Se le asigna la solicitud al evento
            case 'getEvent':
                var id = localStorage.getItem('idRequest');

                const eventRequest = {
                    id : id
                }

                $.post(this.postApi + endpoint, eventRequest, function(response){
                    if(isJSONString(response)){
                        const result = JSON.parse(response);
                        if(result.status){
                            localStorage.setItem('idEvent',result.dataset.eventId);
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

    put(endpoint){

    }
    delete(endpoint){

    }

}