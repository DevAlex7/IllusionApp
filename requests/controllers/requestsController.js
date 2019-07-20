$(document).ready(function () {
    spinner(); 
    callmyRequests();
});
const request = new Request();
function spinner(){
    setTimeout(function(){ 
    $('.preloader-background').delay(1500).fadeOut('slow');
	$('.preloader-wrapper')
		.delay(1500)
		.fadeOut();
    });
}
function setRequests(rows){
    let content='';
    if(rows.length>0){
        rows.forEach(function(row){
            var fecha = moment(row.date_event);
            if(row.statusId == 1){
                content+=`
                <div class="col s12">
                    <ul class="collection z-depth-1" onClick="showEvent(${row.id})">
                        <li class="collection-item">
                            <span class="title">${row.name_event}</span>
                            <p class="title">Fecha de evento: ${ fecha.lang('es').format('dddd D MMMM , YYYY') }</p>
                            <li class="collection-item"><div>Estado: ${row.status}<a class="secondary-content"><i class="material-icons green-text accent-4"> check </i></a></div></li>
                        </li>
                    </ul>
                </div>
                `;
            }
            else if(row.statusId == 2){
                content+=`
                <div class="col s12">
                    <ul class="collection z-depth-1" onClick="showEvent(${row.id})">
                        <li class="collection-item">
                            <span class="title">${row.name_event}</span>
                            <p class="title">Fecha de evento: ${ fecha.lang('es').format('dddd D MMMM , YYYY') }</p>
                            <li class="collection-item"><div>Estado: ${row.status}<a class="secondary-content"><i class="material-icons red-text"> cancel </i></a></div></li>
                        </li>
                    </ul>
                </div>
                `;
            }
            else if(row.statusId == 3){
                content+=`
                <div class="col s12">
                    <ul class="collection z-depth-1" onClick="showEvent(${row.id})">
                        <li class="collection-item">
                            <span class="title">${row.name_event}</span>
                            <p class="title">Fecha de evento: ${ fecha.lang('es').format('dddd D MMMM , YYYY') }</p>
                            <li class="collection-item"><div>Estado: ${row.status}<a class="secondary-content"><i class="material-icons grey-text"> more_horiz </i></a></div></li>
                        </li>
                    </ul>
                </div>
                `;
            }
            else{

            }
        })
    }
    $('#requestsResult').html(content);
}
function callmyRequests(){
    var id = new User().Information.get().id;
    $.ajax(
        {
            url:callPOST('Request','myRequests'),
            type:'POST',
            data:{
                id
            },
            datatype:'JSON'
        }
    )
    .done(function(response)
        {
            if(isJSONString(response)){
                const result = JSON.parse(response);
                if(result.status != 1){
                    ToastError("No hay información");
                }
                setRequests(result.dataset);    
            }
            else{
                console.log(response);
            }
        }
    )
    .fail(function(jqXHR){
    })
}
const showEvent = (id) => {
    request.getRequestId(id);
    request.viewRequest();
}
