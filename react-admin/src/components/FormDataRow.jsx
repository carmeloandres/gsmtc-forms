import { useContext, useState, useEffect } from 'react';
import { ApiContext } from '../ApiContext';
import { __ } from "../helpers";
//import './FormDataRow.scss';

export const FormDataRow = ({
    idSubmit, idForm, formName, date, email, onClick
  }) => {

    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    // Desestructura la url de la restApi de wordpress
    // y el nonce de validación para las peticiones api.
    const { restUrl, nonce, gsmtcForms } = api;

    const [ buttonContent, setButtonContent] = useState('+');
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
        setRows( result );
    }									

    }
    const onClickButton = (event) =>{
      event.preventDefault();
        if (buttonContent == '+')
            setButtonContent('-');
        else setButtonContent('+');
     // onClick(event);
    }
      
    return (
      <div className='gsmtc-forms-admin-accordion'>
        <div className='gsmtc-forms-admin-accordion-submit'>
            <div>{formName}</div>
            <div>{date}</div>
            <div>{email}</div>
            <div>
              <form>
                <input type="hidden" name="idSubmit" value={idSubmit} />
                <input type="hidden" name="idForm" value={idForm} />
                <button type="submit" onClick={onClickButton}>{buttonContent}</button>
              </form>
            </div>
        </div>
        { ((buttonContent == '-')? true : false) &&
        <div className='gsmtc-forms-admin-accordion-content'>
          <div>{__('Please wait loading content...',gsmtcForms)}</div>
        </div>
        }
      </div>
    )
  }