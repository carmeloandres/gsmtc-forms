import { useContext, useState, useEffect } from 'react';
import { ApiContext } from '../ApiContext'
//import './Pagination.scss';

export const FormDataRow = ({
    formName, date, email, onClick
  }) => {

    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    // Desestructura la url de la restApi de wordpress
    // y el nonce de validación para las peticiones api.
    const { restUrl,nonce } = api;

    const [ buttonContent, setButtonContent] = useState('+');
  
    useEffect(() =>{

    },[])

    const onClickButton = (event) =>{
        if (buttonContent == '+')
            setButtonContent('-');
        else setButtonContent('+');
      onClick(event);
    }
      
    return (
        <div className='gsmtc-forms-data-row'>
            <div>{formName}</div>
            <div>{date}</div>
            <div>{email}</div>
            <button onClick={onClickButton}>{buttonContent}</button>
        </div>
    )
  }