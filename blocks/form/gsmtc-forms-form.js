// Variable a modo de bandera para ser utilizado por los manejadores de evento
// onChange de los input text de los formularios de gsmtc.
// si la bandera esta a true se permite la modificación del input text, en caso contrario no.
var gsmtcTextFlag = true;
var attribute ="^[a-zA-Z0-9&#47;s'\"\?!]+$";

// función para realizar las acciones en la respuesta al submit de nothing
const onResponseNothing = (form, message) => {
    let successMessage = form.getAttribute('data-success-message');
    if ((successMessage != null) && (successMessage != '')){
        message.textContent = successMessage;
        message.classList.remove("gsmtc-form-send-message");
        message.classList.remove("gsmtc-form-fail-message");
        message.classList.add("gsmtc-form-success-message");
    }

    setTimeout(() => {message.remove()},6000);	

}

// función para realizar las acciones en la respuesta al submit de clean
const onResponseClean = (form, message) => {
    let successMessage = form.getAttribute('data-success-message');
    if ((successMessage != null) && (successMessage != '')){
        message.textContent = successMessage;
        message.classList.remove("gsmtc-form-send-message");
        message.classList.remove("gsmtc-form-fail-message");
        message.classList.add("gsmtc-form-success-message");
    }

    let inputs = Array.from(form.querySelectorAll("input"));
    
    inputs.forEach(input => {
        if ( input.type == 'text')
            input.value = '';
    })

    setTimeout(() => {message.remove()},6000);	

}
// función para realizar las acciones en la respuesta al submit de hide
const onResponseHide = (form, message) => {
    
    let successMessage = form.getAttribute('data-success-message');
    if ((successMessage != null) && (successMessage != '')){
        message.textContent = successMessage;
        message.classList.remove("gsmtc-form-send-message");
        message.classList.remove("gsmtc-form-fail-message");
        message.classList.add("gsmtc-form-success-message");
    }

    let parentElement = form.parentNode;
    parentElement.replaceChild(message,form);

    setTimeout(() => {message.remove()},6000);	
    
}

// función para realizar las acciones en la respuesta al submit de nothing
const onResponseFail = (form, message) => {
    let failMessage = form.getAttribute('data-fail-message');
    if ((failMessage != null) && (failMessage != '')){
        message.textContent = failMessage;
        message.classList.remove("gsmtc-form-send-message");
        message.classList.remove("gsmtc-form-success-message");
        message.classList.add("gsmtc-form-fail-message");
    }

    setTimeout(() => {message.remove()},6000);	

}


const gsmtcFormsFormSubmit = async (event) => {
    event.preventDefault();

    let message = document.createElement("div");
    let sendingMessage = event.target.getAttribute('data-send-message');
    if ((sendingMessage != null) && (sendingMessage != '')){
        message.textContent = sendingMessage;
        message.classList.add("gsmtc-form-send-message");
        event.target.appendChild(message);
    }

    // muestro las notificaciones
    let notices = Array.from(event.target.getElementsByClassName('wp-block-gsmtc-forms-gsmtc-noticesend'));

        notices.forEach( (notice) => {
            notice.style.display = 'block';
        })
    

    console.log('form submited, event.target : ', event.target);
    let inputs = Array.from(event.target.querySelectorAll("input"));
    
    // Validar elementos
    inputs.forEach(input => {
        if (input.value != null){
            console.log('input type : ',input.type, ' ;  input name : ',input.name, ' ; input value : ',input.value)
            console.log(input);
        }
    })
    
    
    
    let elements = Array.from(event.target.elements);
    let contador = 0;
    
    const headers = new Headers({
        'X-WP-Nonce': GsmtcFormsAPI.nonce 
    });

    let field;
    let data;

    let apiData = new FormData();
        apiData.append('action','submitted_form');
        apiData.append('formId',event.target.id);
        apiData.append('formName',event.target.name);
        apiData.append('originUrl',window.location);
        apiData.append('userAgent',navigator.userAgent);
    
    elements.forEach(element => {
        if ((element.type == 'radio') && (element.checked))
            field = [element.type, element.name, element.value, 'checked']
        else
            field = [element.type, element.name, element.value]

        data = JSON.stringify(field);
        apiData.append('Element'+contador,data);
        console.log ('Elemento ',contador,' : ',element);
        if ((element.type == 'radio') && (element.checked))
        console.log ('Elemento type :',element.type,'Elemento name : ',element.name,' Elemento value : ',element.value, 'Checked');
    else
    console.log ('Elemento type :',element.type,'Elemento name : ',element.name,' Elemento value : ',element.value);

contador++;
})


const resp = await fetch(GsmtcFormsAPI.restUrl,{
    method:'POST',
    headers: headers,
    body:apiData
})

if (resp.ok){
    let result = await resp.json();
    let response = event.target.getAttribute('data-response');
    console.log('Response submit :',response);
    if (response == 'nothing')
        onResponseNothing(event.target, message);
    if (response == 'clean')
        onResponseClean(event.target, message); 
    if (response == 'hide')
        onResponseHide(event.target, message);   
    console.log('result :',result);
} else {
    onResponseFail(event.target, message);
} 


}


const onChangeGsmtcFormText = (event) => {
    console.log("se ejecuta el manejador");
    console.log("Class list : ",event.target.classList);
    console.log("gsmtcTextFlag : ",gsmtcTextFlag)
    if (event.target.classList.contains("wp-block-gsmtc-forms-text") && (gsmtcTextFlag)){
        gsmtcTextFlag = false;

        console.log(event.target)
        // Patrón de validación
        let patron = /^[a-zA-Z0-9\s'"\?!]+$/;
        
    
        // Verifica si el valor coincide con el patrón
        let esValido = patron.test(event.target.value);
    
        if (esValido){
            alert("el dato es valido");
        } else alert("El dato NO es valido");

        gsmtcTextFlag = true;
    }
}
window.onload = function (){
    //   console.log('Datos ajax : ',datosAjax);
    
    let formulario = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-form'));
    
    formulario.forEach( form => {form.addEventListener('submit',gsmtcFormsFormSubmit)});

    console.log('formularios detectados',formulario.length);

    console.log ('GsmtcFormsAPI : ',GsmtcFormsAPI);
    console.log ('GsmtcFormsAPI.homeUrl : ',GsmtcFormsAPI.homeUrl);

    // Adding input text onChange handle
    let contadorInputsTexts = 0;
    let gsmtcInputTexts = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-text'));

    gsmtcInputTexts.forEach( gsmtcInputText => {
 //       gsmtcInputText.setAttribute("pattern",GsmtcFormsAPI.inputTextPattern);

//        gsmtcInputText.setAttribute("pattern",attribute);
       gsmtcInputText.setAttribute("title",GsmtcForms.inputTextTitle);
});

//    gsmtcInputTexts.forEach( gsmtcInputText => {gsmtcInputText.addEventListener('change',onChangeGsmtcFormText); contadorInputsTexts++});

    console.log ('Contador de input texts : ',contadorInputsTexts);
    // oculto las notificaciones
    let notices = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-gsmtc-noticesend'));

        notices.forEach( (notice) => {
            notice.style.display = 'none';
        })


}

