
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

        switch(input.type){
            case 'email':
            case 'text':
            case 'textarea':
                    input.value = '';
                break;
        }
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

// función para realizar las acciones en la respuesta al submit de fail
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
    let attribute;

    let apiData = new FormData();
        apiData.append('action','submitted_form');
        apiData.append('formId',event.target.id);
        apiData.append('formName',event.target.name);
        apiData.append('originUrl',window.location);
        apiData.append('userAgent',navigator.userAgent);
    
    elements.forEach(element => {

        switch (element.type) {
            case "checkbox":
                if (element.checked)
                    field = [element.type,  (element.name != '')? element.name : element.type, 'checked']
                else
                    field = [element.type,  (element.name != '')? element.name : element.type, '']
                break;
            case "email":
                attribute = element.getAttribute('data-main-email');
                field = [element.type,  (element.name != '')? element.name : element.type, element.value, (attribute == "true") ? 'main' : '']
              break;
            case "radio":
                if ((element.checked))
                    field = [element.type, (element.name != '')? element.name : element.type, element.value + '_checked']
                else
                    field = [element.type, (element.name != '')? element.name : element.type, element.value + '_']
                break;
            default:
                field = [element.type, (element.name != '')? element.name : element.type, element.value]
                break;
          }
          
          if (element.type != "submit"){
              data = JSON.stringify(field);
              apiData.append('Element'+contador,data);
              contador++;
          }

    })


    const resp = await fetch(GsmtcFormsAPI.restUrl,{
        method:'POST',
        headers: headers,
        body:apiData
    })

    if (resp.ok){
        let result = await resp.json();
        let response = event.target.getAttribute('data-response');
        if (response == 'nothing')
            onResponseNothing(event.target, message);
        if (response == 'clean')
            onResponseClean(event.target, message); 
        if (response == 'hide')
            onResponseHide(event.target, message);   
        console.log('result :',result);
    } else onResponseFail(event.target, message);
    

}

// constructor to handle the validation of text and textarea
function GsmtcHandler (value, pattern){
    let patron = pattern;
    this.value = value;
    this.onInput = (event) =>{
        if (patron.test(event.target.value))
            this.value = event.target.value;
        else event.target.value = this.value;
        //console.log('event.data : ', event.data);
    };
}

// This pattern disalow the use of the next caracters: ' > <  " [ ] ^' and limit the length to 249 caracters max
let textPattern = /^(?!.*[<>"\[\]\^])(.{0,249})$/;

// This pattern disalow the use of the next caracters: ' > <  " [ ] ^' and limit the length to 999 caracters max
let textareaPattern = /^(?!.*[<>"\[\]\^])(.{0,999})$/;

// Array to store the text and the textarea handlers
let handlers = [];


window.onload = function (){
    
    // Adding the submit handler to all gsmtc-forms
    let formulario = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-form'));
    
    formulario.forEach( form => {form.addEventListener('submit',gsmtcFormsFormSubmit)});

//        console.log('formularios detectados',formulario.length);

//        console.log ('GsmtcFormsAPI : ',GsmtcFormsAPI);

    // Adding validation handlers to the input text
    let gsmtcInputTexts = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-text'));

    gsmtcInputTexts.forEach( gsmtcInputText => {

        let handler = new GsmtcHandler(gsmtcInputText.value, textPattern);

        gsmtcInputText.addEventListener('input',handler.onInput);
        handlers.push(handler);

//        gsmtcInputText.setAttribute("title",GsmtcForms.inputTextTitle);
    });

    // Adding validation handlers and translation titles to the input email
    let gsmtcInputEmails = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-email'));
 
    gsmtcInputEmails.forEach( gsmtcInputEmail => {
        
        let handler = new GsmtcHandler(gsmtcInputEmail.value, textPattern);
    
         gsmtcInputEmail.addEventListener('input',handler.onInput);
         handlers.push(handler);

        gsmtcInputEmail.setAttribute("title",GsmtcForms.inputEmailTitle);
    });

    // Adding translation titles to the input text
    let gsmtcInputTextareas = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-textarea'));

    gsmtcInputTextareas.forEach( gsmtcInputTextarea => {

        let handler = new GsmtcHandler(gsmtcInputTextarea.value, textareaPattern);

        gsmtcInputTextarea.addEventListener('input',handler.onInput);
        handlers.push(handler);
//        console.log('textareaHandlers,',textareaHandlers);

//        gsmtcInputTextarea.setAttribute("title",GsmtcForms.inputTextareaTitle);      
    });
    

    // oculto las notificaciones
    let notices = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-gsmtc-noticesend'));

    notices.forEach( (notice) => {
        notice.style.display = 'none';
    })

}

