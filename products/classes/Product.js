class Product extends User {

    constructor(){
        super();
    }
    
    //Rutas de api
    getApi = 'https://playaes.000webhostapp.com/Api/products.php?request=GET&action=';
    pictureApi = 'https://playaes.000webhostapp.com/Imports/pics/products/';
    postApi = 'https://playaes.000webhostapp.com/Api/products.php?request=POST&action=';
    
    route = {
        products : '../layouts/index.html',
        home : '../../user/layouts/home.html',
        productView : 'viewProduct.html',

        viewProduct(){
            $(location).attr('href',this.productView);
        }
    }
    

    get(endpoint){
        switch(endpoint){
            case 'AllList':
                const readProducts = (rows,votes) => {               
                    let content ='';
                    const image = this.pictureApi;
                    if(rows.length>0){
                        rows.forEach(function(row){
                            content += `
                            <div class="col s12">
                                <div class="card horizontal z-depth-2" style="border-radius:2rem" onClick="viewProduct(${row.id})">
                                <div class="card-image">
                                    <img src="${ image + row.image_product }">
                                </div>
                                <div class="card-stacked">
                                    <div class="card-content">
                                        <span class="card-title">${row.nameProduct}</span>
                                        <p> <div class="chip green accent-4 white-text">${ "$"+row.price}</div> </p>
                                    </div>
                                    <div class="card-action">
                                    
                                    </div>
                                </div>
                                </div>
                            </div>
                            `;
                        })  
                    }
                    $('#readProducts').html(content);
                }
                
                const userId = {
                    id : this.Information.get().id
                }

                $.post(this.postApi + endpoint, userId ,function(response) {
                    if(isJSONString(response)){
                        const result = JSON.parse(response);
                        if(!result.status){
                            ToastError(result.exception);
                        }
                        readProducts(result.dataset, result.votes);
                        
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