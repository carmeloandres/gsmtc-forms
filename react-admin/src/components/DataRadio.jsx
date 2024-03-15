import { useContext, useState } from 'react';
import { ApiContext } from '../ApiContext';
import { __ } from "../helpers";

export const DataRadio = ({
    name, content
  }) => {

    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    const { gsmtcForms } = api;

    return (
        <tr className='gsmtc-forms-data-row'>
            <td className='gsmtc-forms-data-type'>{__('Radio',gsmtcForms)}</td>
            <td className='gsmtc-forms-data-name'>{name}</td>
            <td className='gsmtc-forms-data-content'>
                {content.map(element => {
                    console.log('Element :',element);
                    return(
                        <div className='radio'>
                            <div className='name'>{element.radioname}</div>
                            <div className='value'>{element.radiovalue}</div>                                               
                        </div>
                    )
                })}
            
            </td>
        </tr>
    )
  }