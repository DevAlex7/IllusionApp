var properties;
function isInt(value) {
    if (isNaN(value)) {
      return false;
    }
    var x = parseFloat(value);
    return (x | 0) === x;
  }
function CheckDecimal(val) { 
    if( parseFloat(val) <= 0 ){
      return true;
    }
    else{
      var validChars = '0123456789.';
      for(var i = 0; i < val.length; i++) {
        if(validChars.indexOf(val.charAt(i)) == -1)
        return false;
      }
      return true;
    }
  } 

function callGET(API,Action){
  //const APIGet = 'https://playaes.000webhostapp.com/Api/'+API+'.php?request=GET&action='+Action;
  const APIGet = '../../../api/'+ API +'.php?request=GET&action='+Action;
  return APIGet;
}

function callPOST(API,Action){

  //const APIGet = 'https://playaes.000webhostapp.com/Api/'+API+'.php?request=POST&action='+Action;
  const APIGet = '../../api/'+API+'.php?request=POST&action='+Action;
  return APIGet;
}

function getProperties(response){
    properties = {
        status : response.status,
        dataset : response.dataset,
        exception : response.exception
    }
    return {
      status : properties.status,
      data : properties.dataset,
      errordata : properties.exception
    }
  
}
function getType(){
  
}
function isJSONString(string)
{
    try {
        if (string != "[]") {
            JSON.parse(string);
            return true;
        } else {
            return false;
        }
    } catch(error) {
        return false;
    }
}

//Login
function requestPOST(API, Action){

    //const APIPost = 'https://playaes.000webhostapp.com/Api/'+ API + '.php?request=POST&action='+Action;
    const APIPost = 'api/'+ API + '.php?request=POST&action='+Action;
  
    return APIPost;
}
function requestGET(API,Action){
    //const APIGet = 'https://playaes.000webhostapp.com/Api/'+ API + '.php?request=GET&action='+Action;
    const APIGet = 'api/'+ API + '.php?request=GET&action='+Action;
    return APIGet;
}

function ToastSucces(message){
  var messageSucces = M.toast({html:message});
  return messageSucces;
}
function ToastError(message){
  var messageError = M.toast({html:message});
  return messageError;
}

function getRandom(length) {

  return Math.floor(Math.pow(10, length-1) + Math.random() * 9 * Math.pow(10, length-1));
  
}

function redirectTo(site){
  $(location).attr('href',site);
}

function ClearForm(Form){
  $('#'+Form)[0].reset();
}

function LogOff(){
  location.href =  requestPOST('userEmployees','Logoff');
}

function catchError(jqueryError){
  var failMessage =  console.log('Error: ' + jqueryError.status + ' ' + jqueryError.statusText);
  return failMessage;
}