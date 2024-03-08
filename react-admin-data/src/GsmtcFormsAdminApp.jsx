import { useEffect, useState } from 'react'
import { ApiContext } from "./ApiContext";
import { Pagination } from './components';
import { FormDataRow } from './components';

//import './App.css'

export const GsmtcFormsAdminApp = () => {

  // 
  const [ api, setApi ] = useState(gsmtcFormsApi);
  const { restUrl,nonce } = api;

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
        setRows( result);
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
  return (
    <>
  <ApiContext.Provider value={ { api, setApi }} >
      <h1>Gsmtc forms Admin</h1>
      <div>
        <p>
          Edit <code>src/App.jsx</code> and save to test HMR
        </p>
          


      {rows.map(row => {
        return(
          <FormDataRow 
          formName={row.formname}
          date={row.date}
          email={row.email}
          />
          )
        })}    
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
