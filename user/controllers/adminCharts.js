$(document).ready(function () {
 spinner();   
 requestChart();
 productsList('DESC');
});
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1500).fadeOut('slow');
	$('.preloader-wrapper')
		.delay(1500)
		.fadeOut();
    });
}
const requestChart = () =>{
    $('#canvasRequest').html('');
    $.ajax(
        {
            url:callGET('Request','listRequestDate'),
            type:'GET',
            data:null,
            datatype:'JSON'
        }
    )
    .done(function(response){
        if(isJSONString(response)){
            const result = JSON.parse(response);
            if(result.status){
                var dates = [];
                var count = [];
                for(i in result.dataset){
                    dates.push(result.dataset[i].date_request);
                    count.push(result.dataset[i].countTotal);
                }
                $('#canvasRequest').html('<canvas id="canvasShowRequest"></canvas>');
                getRequest('canvasShowRequest',dates,count);
            }   
            else{

            }
        }else{

        }
    })
    .fail(function(jqXHR){
        catchError(jqXHR); 
    })
}
$('#ascOption').click(function(){
    productsList('ASC');
})
$('#descOption').click(function(){
    productsList('DESC');
})