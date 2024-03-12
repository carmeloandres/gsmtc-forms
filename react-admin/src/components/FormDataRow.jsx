import { useContext, useState, useEffect } from 'react';
import { ApiContext } from '../ApiContext';
import { __ } from "../helpers";
//import './FormDataRow.scss';

export const FormDataRow = ({
    idSubmit, idForm, formName, date, email, onDelete
  }) => {

    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    // Desestructura la url de la restApi de wordpress
    // y el nonce de validación para las peticiones api.
    const { restUrl, nonce, gsmtcForms } = api;

    const [ buttonContent, setButtonContent] = useState('Open');
    const [ dataLoad, setDataload ] = useState(false);
  
    const [ data,setData ] = useState([]);

    const loadData = async() => {

      // create the header with the nonce token
      const headers = new Headers({
        'X-WP-Nonce': nonce 
      })    
  
      // create the FormData to store the Data of query
      let apiData = new FormData();
        apiData.append('action','get_data_submit');
        apiData.append('idSubmit',idSubmit);
  
      // send the query to the api endpoint
      const resp = await fetch(restUrl,{
          method: 'POST',
          headers: headers,
          body:apiData
      })
  
      // recive the resquest from api and obtain the json data
      if (resp.ok){
        let result = await resp.json();
        setData( result );
        setDataload( true );
    }									

    }
    const onClickButton = (event) =>{
      event.preventDefault();
        if (buttonContent == 'Open')
            setButtonContent('Close');
        else setButtonContent('Open');
        if ( ! dataLoad )
          loadData();
    }

    const onClickDeleteButton = (event) =>{
      event.preventDefault();
      let result = window.confirm(__('are you sure od deleting the data form submission',gsmtcForms));
      if (result == true)
        onDelete(idSubmit);
    }

    return (
      <div className='gsmtc-forms-admin-accordion'>
        <div className='gsmtc-forms-admin-accordion-submit'>
            <div className='gsmtc-forms-admin-cell'>{formName}</div>
            <div className='gsmtc-forms-admin-cell'>{date}</div>
            <div className='gsmtc-forms-admin-cell'>{email}</div>
            <div className='gsmtc-forms-admin-cell'>
              <form>
                <input type="hidden" name="idSubmit" value={idSubmit} />
                <input type="hidden" name="idForm" value={idForm} />
                <button type="submit" onClick={onClickButton}>{buttonContent}</button>
                <button type="submit" onClick={onClickDeleteButton}>Delete data</button>
              </form>
            </div>
        </div>
        { ((buttonContent == 'Close')? true : false) &&
        <div className='gsmtc-forms-admin-accordion-content'>
          { ( ! dataLoad ) &&
              <div>{__('Please wait loading content...',gsmtcForms)}</div> }
          { ( dataLoad ) &&
            <div>Mostrando la informacion de los datos del formulario</div>

          }
        </div>
        }
      </div>
    )
  }