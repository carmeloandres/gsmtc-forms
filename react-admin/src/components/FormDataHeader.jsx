import { useContext, useState, useEffect } from 'react';
import { ApiContext } from '../ApiContext';
import { __ } from "../helpers";
//import './FormDataRow.scss';

export const FormDataHeader = () => {
    // Referencia las credenciales de la api
    const { api } = useContext( ApiContext );

    // Desestructura la url de la restApi de wordpress
    // y el nonce de validación para las peticiones api.
    const { gsmtcForms } = api;


      
    return (
      <div className='gsmtc-forms-admin-accordion'>
        <div className='gsmtc-forms-admin-accordion-submit'>
            <div className='gsmtc-forms-admin-cell'>{__('Form name',gsmtcForms)}</div>
            <div className='gsmtc-forms-admin-cell'>{__('Date of submission form',gsmtcForms)}</div>
            <div className='gsmtc-forms-admin-cell'>{__('Main email of subnission',gsmtcForms)}</div>
            <div className='gsmtc-forms-admin-cell'>{__('Actions',gsmtcForms)}</div>
        </div>
      </div>
    )
  }