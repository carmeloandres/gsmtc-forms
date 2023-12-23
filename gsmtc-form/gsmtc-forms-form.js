const gsmtcFormsFormSubmit = (event) => {
    event.preventDefault();

    console.log('form submited, event.target : ', event.target);
    let inputs = Array.from(event.target.querySelectorAll("input"));


    inputs.forEach(input => {
        if (input.value != null){
            console.log('input type : ',input.type, ' ;  input name : ',input.name, ' ; input value : ',input.value)
            console.log(input);
        }
    })
    
}


window.onload = function (){
 //   console.log('Datos ajax : ',datosAjax);

    let formulario = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-gsmtc-form'));
        
    formulario.forEach( form => {form.addEventListener('submit',gsmtcFormsFormSubmit)})

    console.log('formularios detectados',formulario.length);


}

