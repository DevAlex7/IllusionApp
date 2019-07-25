const app = new User();
const person = new Profile();
var code;
$(document).ready(function () {
    initContent();
});
function initContent(){
    let content ='';
    content=`
    <div class="input-field">
        <div class="center">
            <a class="btn" onClick="sendEmail()" id="btnSendemail">Enviar</a>   
        </div>
    </div>
    `
    $('#contentReset').html(content);
}
function backHome(){
    person.route.home();
}
function sendEmail(){
    let content ='';
    code = getRandom(5);
    alert(app.Information.get().email);
    
    var template_params = {
        to_name: app.Information.get().name,
        from_name: app.Information.get().email,
        message_html: 'Hemos visto que quieres recuperar tu contraseña',
        random_code: code
    };
     
    emailjs.send('gmail','template_91l8hkRn' , template_params)
    .then(function(response) {
        ToastSucces("Correo enviado");
    }, function(error) {
        console.log('FAILED...', error);
    });
    
   content = `
   <div class="input-field">
       <div class="center">
           <input type="number" id="codeInput" placeholder="Ingrese el codigo enviado">
           <a class="btn" onClick="verify()" id="verifyCode">Verificar</a>   
       </div>
   </div>
   `;
   $('#contentReset').html(content);
}
function verify(){
    let content ='';
    var input =$('#codeInput').val();
    if(input == code){
        //es valido        
        content += `
        <div class="input-field">
            <div class="center">
                <input type="hidden" id="idUser" name="idUser" placeholder="Ingrese su nueva contraseña" value="${app.Information.get().id}">
                <input type="password" id="newpassword" placeholder="Ingrese su nueva contraseña">
                <input type="password" id="newpassword2" placeholder="Repita su nueva contraseña">
                <a class="btn" onClick="updatePassword()" id="verifyCode">Cambiar</a>   
            </div>
        </div>`;
        $('#contentReset').html(content);
    }
    else{
        alert("Codigo invalido");
    }
}
function updatePassword(){
    const data = {
        id: $('#idUser').val(),
        pass1 : $('#newpassword').val(),
        pass2 : $('#newpassword2').val(),
    };
    person.put('resetPassword', data);
}
