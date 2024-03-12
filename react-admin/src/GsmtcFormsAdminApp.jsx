import { useEffect, useState } from 'react'
import { ApiContext } from "./ApiContext";
import { Pagination, FormDataRow, FormDataHeader } from './components';
import { __ } from "./helpers";

//import './App.css'

export const GsmtcFormsAdminApp = () => {

  // 
  const [ api, setApi ] = useState(gsmtcFormsApi);
  const { restUrl, nonce, gsmtcForms } = api;


  // Estado para almacenar la clase y el contenido de las alertas
  const [alert,setAlert] = useState({class:'display-none',type:'',content:''});

  const [ page , setPage ] = useState(1);
  const [ lastPage, setLastPage ] = useState(gsmtcFormsApi.lastPage);

  const [ rows, setRows ] = useState([]);

  useEffect(()=>{
    getPage(page);    
  },[page])

  const getPage = async (newPage) => {

    // create the header with the nonce token
    const headers = new Headers({
      'X-WP-Nonce': nonce 
    })    
  
    // create the FormData to store the Data of query
    let apiData = new FormData();
      apiData.append('action','get_data_page');
      apiData.append('page',newPage);
  
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

  const onClickPagination = (event) => {
    switch(event.target.innerHTML){
      case 'First':
        setPage(1);
        break;
      case 'Next':
        setPage(page + 1);
        break;
      case 'Previous':
        setPage(page - 1);
        break;
      case 'Last':
        setPage(lastPage);
    }
  }

  const onDeleteSubmissionData = async( id ) => {
      setAlert({class:'display-flex',type:'warning',content:__('Deleting de submission data form',gsmtcForms)})
        // create the header with the nonce token
        const headers = new Headers({
          'X-WP-Nonce': nonce 
        })    
      
        // create the FormData to store the Data of query
        let apiData = new FormData();
          apiData.append('action','delete_submission');
          apiData.append('id',id);
      
        // send the query to the api endpoint
        const resp = await fetch(restUrl,{
              method: 'POST',
              headers: headers,
              body:apiData
        })
      
        // recive the resquest from api and obtain the json data
        if (resp.ok){
          let result = await resp.json();
          if ( result !== false){
            setAlert({class:'display-flex',type:'success',content:__('The data has been deleted successfull',gsmtcForms)})
            getPage( page );
            setTimeout(() => {setAlert({class:'display-none',type:'',content:''})},5000);
          } else setAlert({class:'display-flex',type:'error',content:__('The data has not been deleted',gsmtcForms)})

        }		
  }
  return (
    <>
  <ApiContext.Provider value={ { api, setApi }} >
      <div className='gsmtc-forms-admin-content'>
      <h1 className='gsmtc-forms-admin-title'>Gsmtc forms Admin</h1>
      <FormDataHeader />


      {rows.map(row => {
        return(
          <FormDataRow 
            idSubmit={row.id}
            idForm={row.idform}
            formName={row.formname}
            date={row.date}
            email={row.email}
            onDelete={onDeleteSubmissionData}
          />
          )
        })}    
          <div className={alert.class}>
            <div className={alert.type}>{alert.content}</div>
          </div>
        <div class="gsmtc-forms-paginacion">
        <Pagination 
          current={page}
          last={lastPage}
          onClick={onClickPagination} 
          />
        </div>
      </div>
      </ApiContext.Provider>
    </>
  )
}
