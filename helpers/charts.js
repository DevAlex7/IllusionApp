function getRequest(canvasId, dates, count){

    var coloR3 =[];
    
    var ctx = $('#'+canvasId);
    
    if(dates.length>0){
        

        for(i in dates){
           coloR3.push('#'+(Math.random()*0xFFFFFF<<0).toString(16));
        }


        new Chart(ctx, {
            type: 'horizontalBar',
            data: {
            labels: dates,
            datasets: [
                {
                label: '',
                backgroundColor: coloR3,
                data: count
                }
            ]
            },
            options: {
            legend: {
                labels: {
                        generateLabels: function(chart) {
                            labels = Chart.defaults.global.defaultFontColor = 'black';
                        return labels
                        }
                },
                display: false,
            },
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        stepSize: 1 // Edit the value according to what you need
                    }
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
        });
    }
    else{
        ctx.destroy();
    }
}
function getProducts(canvasId, Products, count){
    var coloR3 =[];
    
    var ctx = $('#'+canvasId);
    
    if(Products.length>0){
        

        for(i in Products){
           coloR3.push('#'+(Math.random()*0xFFFFFF<<0).toString(16));
        }


        new Chart(ctx, {
            type: 'horizontalBar',
            data: {
            labels: Products,
            datasets: [
                {
                label: '',
                backgroundColor: coloR3,
                data: count
                }
            ]
            },
            options: {
            legend: {
                labels: {
                        generateLabels: function(chart) {
                            labels = Chart.defaults.global.defaultFontColor = 'black';
                        return labels
                        }
                },
                display: false,
            },
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        stepSize: 1 // Edit the value according to what you need
                    }
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
        });
    }
    else{
        ctx.destroy();
    }
}
const showProducts = (rows) => {    
    let content = '';
    if(rows.length > 0){
        rows.map(function(product){
            content += `
                <ul class="collection">
                    <li class="collection-item">   <a class="collection-item black-text"> 
                    <span class="new badge green accent-4" data-badge-caption="">${product.count}</span> ${product.nameProduct} </a> </li>
                </ul>
            `;
        })
    }
    $('#canvasProducts').html(content);
}
function productsList(option){
    const default_option = option;
    $('#canvasProducts').html('');
    $.ajax(
        {
            url:adminPOST('products','AllList'),
            type:'POST',
            data:{
                default_option
            },
            datatype:'JSON'
        }
    )
    .done(function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                showProducts(result.dataset);
            }   
        }else{
            console.log(response);
        }
    })
    .fail(function(jqXHR){
        catchError(jqXHR); 
    })
}
