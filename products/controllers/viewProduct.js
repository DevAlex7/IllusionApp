const stock = new Product();
const profile = new User();
var idProduct;
$(document).ready(function () {
    $('.collapsible').collapsible();
    idProduct = localStorage.getItem('idProduct');
    stock.post('GetbyId',idProduct);
    verifyLikes();
    verifyDislikes();
    verifyAction();
    Callrequests();
});

function verifyLikes(){
    const information={
        product:idProduct
    }
    $.post(stock.postApi + 'verifylikes', information, function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                $('#labelNumberLikes').text(result.dataset.likes);
            }
            else{
                $('#labelNumberLikes').text(0);
            }
        }
        else{
            console.log(response);
        }
    })  
}
function verifyDislikes(){
    const information={
        product:idProduct
    }
    $.post(stock.postApi + 'verifyDislikes', information, function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                $('#labelNumberdisLikes').text(result.dataset.dislikes);
            }
            else{
                $('#labelNumberdisLikes').text(0);
            }
        }
        else{
            console.log(response);
        }
    })  
}
function verifyAction(){
    const bodyRequest ={
        idUser:profile.Information.get().id,
        idProduct:idProduct
    }

    $.post(stock.postVote + 'verifyAction', bodyRequest, function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                if(result.dataset.likeState == 1 ){
                    $('#iconlike').removeClass('white-text');
                    $('#iconlike').addClass('blue-text');

                    $('#icondislike').removeClass('blue-text');
                    $('#icondislike').addClass('white-text')
                }
                else if(result.dataset.likeState == 2)
                {
                    $('#icondislike').removeClass('white-text');
                    $('#icondislike').addClass('blue-text')

                    $('#iconlike').removeClass('blue-text');
                    $('#iconlike').addClass('white-text');
                }
                else{ 
                }
            }
            else{
                $('#icondislike').removeClass('blue-text');
                $('#icondislike').addClass('white-text');

                $('#iconlike').removeClass('blue-text');
                $('#iconlike').addClass('white-text');
                $('#labelNumberdisLikes').text(0);
            }
        }
        else{
            console.log(response);
        }
    })  
}

function setAction(id){

    if(id == 1 && $('#iconlike').hasClass('blue-text')){
        $('#iconlike').removeClass('blue-text');
        $('#iconlike').addClass('white-text');
        const send = {
            idProduct : idProduct,
            like : id,
            idUser : profile.Information.get().id    
        }
        $.post(stock.postVote + 'verify', send, function(response){
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status == 1){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 2){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 3){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();

                }
                else if(result.status == 4){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                    
                }
                else if(result.status == 5){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else{
                    ToastError(result.exception)
                }
            }
            else{
                console.log(response);
            }
        })
    }
    else if(id == 1 && $('#iconlike').hasClass('white-text')){
        $('#iconlike').removeClass('white-text');
        $('#iconlike').addClass('blue-text');
        const send = {
            idProduct : idProduct,
            like : id,
            idUser : profile.Information.get().id    
        }
        $.post(stock.postVote + 'verify', send, function(response){
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status == 1){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 2){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 3){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 4){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 5){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else{
                    ToastError(result.exception)
                }
            }
            else{
                console.log(response);
            }
        })
    }
    else if(id == 2 && $('#icondislike').hasClass('blue-text')){
        $('#icondislike').removeClass('blue-text');
        $('#icondislike').addClass('white-text');
        const send = {
            idProduct : idProduct,
            like : id,
            idUser : profile.Information.get().id    
        }
        $.post(stock.postVote + 'verify', send, function(response){
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status == 1){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 2){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 3){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 4){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 5){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else{
                    ToastError(result.exception)
                }
            }
            else{
                console.log(response);
            }
        })
    }
    else if(id == 2 && $('#icondislike').hasClass('white-text')){
        const send = {
            idProduct : idProduct,
            like : id,
            idUser : profile.Information.get().id    
        }
        $.post(stock.postVote + 'verify', send, function(response){
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status == 1){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 2){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 3){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 4){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else if(result.status == 5){
                    verifyLikes();
                    verifyDislikes();
                    verifyAction();
                }
                else{
                    ToastError(result.exception)
                }
            }
            else{
                console.log(response);
            }
        })
    }
}

function setRequests(rows){
    let content ='';
    if(rows.length > 0){
        rows.forEach(function(row){
            content+=`
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">${row.name_event}</span>
                        <span>${row.count} cantidades solicitadas</span>
                    </div>
                    <div class="card-action">
                        <p>¿Deseas eliminar este producto de esta solicitud?</p>
                        <a onClick="deleteItem(${row.idList})" class="btn red">Eliminar</a>
                    </div>
                </div>
            `;
        })
    }
    else{
        content=`<p>No hay solicitudes donde este producto</p>`;
    }
    $('#requestsRead').html(content);
}

function Callrequests(){
    const body = {
        product : idProduct,
        idUser : profile.Information.get().id
    }
    
    $.ajax({
        url:stock.postApi + 'getRequestsInproduct',
        type:'POST',
        data:body,
        datatype:'JSON'
    })  
    .done(function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(!result.status){
                let content = '<p>No hay solicitudes donde este producto</p>';
                $('#requestsRead').html(content);
            }
            setRequests(result.dataset);
            $('.collapsible').collapsible('close');
        }
        else{
            console.log(response);
        }
    })  
}

function deleteItem (id){
    const body = {
        idProduct : id
    }
    
    $.ajax({
        url:stock.deleteApi + 'deleteRequestItem',
        type:'POST',
        data : body,
        datatype:'JSON'
    })
    .done(function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                Callrequests();
            }
            else{
                ToastError(result.exception);
            }
        }
        else{
            console.log(response);
        }
    })
    
}

