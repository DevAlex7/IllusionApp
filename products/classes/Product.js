class Product {
    //Rutas de api
    getApi = 'https://playaes.000webhostapp.com/Api/products.php?request=GET&action=';
    postApi = 'https://playaes.000webhostapp.com/Api/products.php?request=POST&action=';

    get(endpoint){
        switch(endpoint){
            case 'AllList':
                const readProducts = (rows) =>{
                    let content ='';
                    if(rows.length>0){
                        rows.forEach(function(row){
                            if(row.count < 5){
                                content += `
                                <div class="col s12">
                                    <div class="card">
                                        <div class="card-content">
                                            <p>${row.nameProduct}</p>
                                            <p class="red-text"> No Disponible </p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            }else
                            {
                                content += `
                                <div class="col s12">
                                    <div class="card">
                                        <div class="card-content">
                                            <p>${row.nameProduct}</p>
                                            <p class="green-text accent-4"> Disponible </p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            }
                            
                        })  
                    }
                    $('#readProducts').html(content);
                }
                
                $.get(this.getApi + endpoint, function(response) {
                    if(isJSONString(response)){
                        const result = JSON.parse(response);
                        if(!result.status){
                            ToastError(result.exception);
                        }
                        readProducts(result.dataset);
                    }
                    else{
                        console.log(response);
                    }
                })
            break;
        }
    }
    post(endpoint){
        switch(endpoint){

        }
    }
    put(endpoint){

    }
    delete(endpoint){

    }
    
}