import { useContext, useState } from 'react';
import { ApiContext } from '../ApiContext';
import { __ } from "../helpers";

export const DataText = ({
    name, content
  }) => {

    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    const { gsmtcForms } = api;

    return (
        <tr className='gsmtc-forms-data-row'>
            <td className='gsmtc-forms-data-type'>{__('Text',gsmtcForms)}</td>
            <td className='gsmtc-forms-data-name'>{name}</td>
            <td className='gsmtc-forms-data-content'>{content}</td>
        </tr>
    )
  }