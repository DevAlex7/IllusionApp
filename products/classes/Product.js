class Product extends User {

    constructor(){
        super();
    }
    
    

    //Rutas de api externas
    /*getApi = 'https://playaes.000webhostapp.com/Api/products.php?request=GET&action=';
    
    pictureApi = 'https://playaes.000webhostapp.com/Imports/pics/products/';
    
    postApi = 'https://playaes.000webhostapp.com/Api/products.php?request=POST&action=';
    
    deleteApi = 'https://playaes.000webhostapp.com/Api/products.php?request=DELETE&action=';
    
    postVote = 'https://playaes.000webhostapp.com/Api/votes_products.php?request=POST&action=';

    */

    getApi = '../../api/products.php?request=GET&action=';
    
    //pictureApi = 'https://playaes.000webhostapp.com/Imports/pics/products/';
    
    postApi = '../../api/products.php?request=POST&action=';
    
    deleteApi = '../../api/products.php?request=DELETE&action=';
    
    postVote = '../../api/votes_products.php?request=POST&action=';
    
    route = {
        products : '../layouts/index.html',
        home : '../../user/layouts/home.html',
        productView : 'viewProduct.html',

        viewProduct(){
            $(location).attr('href',this.productView);
        }
    }
    
    requestsInProduct(endpoint,idProduct,idUser){
    }
    
    get(endpoint){
        switch(endpoint){
            case 'AllList':
                const readProducts = (rows) => {               
                    let content ='';
                    const image = this.pictureApi;
                    if(rows.length>0){
                        rows.forEach(function(row){
                            content += `
                            <div class="col s12">
                                <div class="card" onClick="viewProduct(${row.id})">
                                    <div class="card-image">
                                        <img src="${ image + row.image_product}">
                                        <span class="card-title">Card Title</span>
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title">${ row.nameProduct }</span>
                                        <div class="chip blue white-text"> ${ "$"+row.price } </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        })  
                    }
                    $('#readProducts').html(content);
                }
                $.get(this.postApi + endpoint,function(response) {
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
    post(endpoint, data){
        if(data == '' || data == undefined){
            alert("entra sin data");
            switch(endpoint){
                
            }
        }else{
            const image = this.pictureApi;
            switch(endpoint){
                case 'GetbyId':
                    const body = {
                        product : data
                    }
                    $.post(this.postApi + endpoint, body, function(response){
                        if(isJSONString(response)){
                            const result = JSON.parse(response);
                            if(result.status){                                
                                $('#ImageProduct').attr('src',image + result.dataset.image_product);
                                $('#NameP').text(result.dataset.nameProduct);
                            }
                            else{
                            }
                        }else{
                            console.log(response);
                        }
                    })
                break;
            }
        }
    }
    put(endpoint){

    }
    delete(endpoint){

    }

}