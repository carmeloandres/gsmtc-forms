const gsmtcContactFormSubmit = (event) => {
    event.preventDefault();

    console.log('form submited, event.target : ', event.target);
    let inputs = Array.from(event.target.querySelectorAll("input"));
    let textareas = Array.from(event.target.querySelectorAll("textarea"));
    let dataForm = new FormData();
//    dataForm.append('action',datosAjax.action);
//    dataForm.append('nonce',datosAjax.nonce);
//    dataForm.append('rest_nonce',datosAjax.rest_nonce);
//    dataForm.append('request','contact');

    inputs.forEach(input => {
        if (input.name == 'name')
            dataForm.append('name',input.value);
        else if(input.name == 'email') 
                    dataForm.append('email',input.value);
                else if (input.name == 'accept')
                        dataForm.append('accept','true');

        console.log ('input name :',input.name);
        console.log ('nombre valor : ',input.value);
    });

    textareas.forEach(textarea => {
        if (textarea.name == 'message')
            dataForm.append('message',textarea.value);

        console.log ('textarea name :',textarea.name);
        console.log ('textarea valor : ',textarea.value);
    });  

//    const headers = new Headers({
//        'Content-Type': 'application/json',
//        'X-WP-Nonce': datosAjax.rest_nonce
//    });

    const headers = new Headers({
        'X-WP-Nonce': datosAjax.rest_nonce
    });


    fetch(datosAjax.rest_url,{
        method: 'POST',
        headers: headers,
        body: dataForm
    })
    .then (resp => resp.json())
    .then (resp => {
        console.log(resp);
    })
    .catch(error => 
        {console.log('Error in request', error);}
    );
}

window.onload = function (){
        console.log('Datos ajax : ',datosAjax);

        let formulario = Array.from(document.getElementsByClassName('gsmtc-contact-form'));
            
        formulario.forEach( form => {form.addEventListener('submit',gsmtcContactFormSubmit)})

        console.log('formularios detectados',formulario.length);
    }
