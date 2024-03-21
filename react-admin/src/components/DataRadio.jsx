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
                    return(
                        <div className='radio'>
                            <label className='name'for={name+'_'+element.radioname}>{element.radioname}</label>
                            <input className='value' id={name+'_'+element.radioname} type="radio" checked={(element.radiovalue == 'checked')? true : false} disabled />                            
                        </div>
                    )
                })}
            
            </td>
        </tr>
    )
  }