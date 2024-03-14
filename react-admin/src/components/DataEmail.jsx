import { useContext, useEffect, useState } from 'react';
import { ApiContext } from '../ApiContext';
import { __ } from "../helpers";

export const DataEmail = ({
    type, name, content
  }) => {

    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    const { gsmtcForms } = api;

    const [typeNotation, setTypeNotation] = useState('');

    useEffect (() => {
        if (type === 'email')
            setTypeNotation(__('Email',gsmtcForms));
        else
            setTypeNotation(__('Main email',gsmtcForms));
    },[])

    return (
        <tr className='gsmtc-forms-data-row'>
            <td className='gsmtc-forms-data-type'>{typeNotation}</td>
            <td className='gsmtc-forms-data-name'>{name}</td>
            <td className='gsmtc-forms-data-content'>{content}</td>
        </tr>
    )
  }