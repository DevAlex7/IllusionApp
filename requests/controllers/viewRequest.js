const request = new Request();
$(document).ready(function () {
    spinner();
    verify();
    request.post('getmyRequest')
    request.post('getEvent')
    request.post('productsInNotListRequest');
    viewListProduct();
}); 
function verify(){
    request.post('verifyStatus');
}

const setProductsList = (rows) => {
    console.log(rows);
    let content ='';
    if(rows.length>0){
        rows.forEach(function(row){
            content += `
                <a class="collection-item blue-text"> <span class="new badge green accent-4 white-text" id="badge" data-badge-caption=""> ${row.count} </span> ${row.nameProduct }</a>
            `;   
        })
    }
    $('.collection').html(content);
}

const viewListProduct = () => {
    
    const body = {
        id_request:localStorage.getItem('idRequest')
    }

    $.post(request.postApi + 'getProductRequest', body, function(response) {
        if(isJSONString(response)){
            const result= JSON.parse(response);
            if(!result.status){
                ToastError(response.exception);
            }
            setProductsList(result.dataset);
        }
        else{
            console.log(response);
        }
    })
}

function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1500).fadeOut('slow');
	$('.preloader-wrapper')
		.delay(1500)
		.fadeOut();
    });
}

$('#form-add-productList').submit( e => {
    event.preventDefault(); 
    
    const bodyRequest = {
        id_product : $('#product').val(),
        count : $('#countProduct').val(),
        id_request : localStorage.getItem('idRequest')
    }
    
    $.post(request.postApi + 'addProductListRequest', bodyRequest, function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                ToastSucces("Se ha añadido correctamente");
                request.post('productsInNotListRequest');
                $('#countProduct').val('');
                viewListProduct();

            }
            else{
                ToastError(result.exception);
            }
        }
        else{
            console.log(response);
        }
    })
})

