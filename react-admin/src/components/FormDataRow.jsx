import { useContext, useState, useEffect, useRef } from 'react';
import { ApiContext } from '../ApiContext';
import { DataEmail, DataRadio, DataText } from './';
import { __ } from "../helpers";

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

    // creamos una referencia a la tabla utilizando el hook useRef
		const tableRef = useRef();

    // This function is to adjust all the width cell to maxwidth
    useEffect(()=> {
      if (tableRef.current !== undefined){
        let rowsLength = tableRef.current.rows.length;
        if (rowsLength >= 1){
          let cellsLength = tableRef.current.rows[0].cells.length;
          for (let cells = 0 ; cells < cellsLength ; cells++){
            let maxWidth = 0;            
            for (let rows = 0 ; rows < rowsLength; rows++){
              let cell = tableRef.current.rows[rows].cells[cells];
              let cellWidth = cell.clientWidth; 
              if (cellWidth > maxWidth) {
                  maxWidth = cellWidth;
              }              
            }
            for (let rows = 0; rows < rowsLength ; rows++)
              tableRef.current.rows[rows].cells[cells].style.width = maxWidth + 'px';
          }
        } else console.log ('No rows in table');
      }
      else console.log('Data changes, but tableRef == undefined');
    },[data]);

    const loadData = async() => {

      console.log('Data load executed');

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
        console.log('Data load : ', result);
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
      let result = window.confirm(__('are you sure to deleting the data form submission',gsmtcForms));
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
            <table
              ref={tableRef}
            >        
              <tr className='gsmtc-forms-data-row'>
                <th className='gsmtc-forms-data-type'>{__('Type',gsmtcForms)}</th>
                <th className='gsmtc-forms-data-name'>{__('Name',gsmtcForms)}</th>
                <th className='gsmtc-forms-data-content'>{__('Content',gsmtcForms)}</th>
              </tr>
              {data.map( row => {
                  switch(row.typedata){
                    case 'text':
                      return(
                              <DataText
                                name={row.namedata} 
                                content={row.contentdata}
                              />
                      );
                    case 'email':
                    case 'email_main':
                      return(
                             <DataEmail 
                              type={row.typedata}
                              name={row.namedata}
                              content={row.contentdata}
                             /> 
                      );
                    case 'radio':
                      return(
                        <DataRadio
                          name={row.namedata} 
                          content={row.contentdata}
                        />
                      );

                  }
                
              })
            

              }
          </table>

          }
        </div>
        }
      </div>
    )
  }