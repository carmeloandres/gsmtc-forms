const gsmtcFormsFormSubmit = async (event) => {
    event.preventDefault();

    console.log('form submited, event.target : ', event.target);
    let inputs = Array.from(event.target.querySelectorAll("input"));
    
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
        apiData.append('action','actualizar_formulario');
    
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
    
            console.log('result :',result);
            }

}


window.onload = function (){
 //   console.log('Datos ajax : ',datosAjax);

    let formulario = Array.from(document.getElementsByClassName('wp-block-gsmtc-forms-gsmtc-form'));
        
    formulario.forEach( form => {form.addEventListener('submit',gsmtcFormsFormSubmit)})

    console.log('formularios detectados',formulario.length);

    console.log ('GsmtcFormsAPI : ',GsmtcFormsAPI);
    console.log ('GsmtcFormsAPI.homeUrl : ',GsmtcFormsAPI.homeUrl);


}

