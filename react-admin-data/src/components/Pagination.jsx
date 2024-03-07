import { useState, useEffect } from 'react';
//import './Pagination.scss';

export const Pagination = ({
    first, current, last,onClick
  }) => {
  
   // obtengo la url de la carpeta de imagenes del plugin
    const [ firstDisabled, setFirstDisabled ] = useState(true);
    const [ lastDisabled, setLastDisabled ] = useState(true);

  
    useEffect(() =>{
        if (current <= first)
            setFirstDisabled(true);
        else setFirstDisabled(false);

        if (current >= last)
            setLastDisabled(true);
        else setLastDisabled(false);

    },[current])

  
  
  
    const onLinkClick = (event) =>{
      toggleStyles();
      onClick(event);
    }
    
    return (
      <>
        <div className='gsmtc-admin-pagination'>
            <button>First</button>
            <button>Previous</button>
            <span>{current}</span>
            <button>Next</button>
            <button>Last</button>

          <a className="navbar-brand text-info" href=""><img src={imagesUrl+'logojardinactivo.png'}/></a>
          <button className="navbar-button" onClick={toggleStyles}>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.879 103.609" enable-background="new 0 0 122.879 103.609" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M10.368,0h102.144c5.703,0,10.367,4.665,10.367,10.367v0 c0,5.702-4.664,10.368-10.367,10.368H10.368C4.666,20.735,0,16.07,0,10.368v0C0,4.665,4.666,0,10.368,0L10.368,0z M10.368,82.875 h102.144c5.703,0,10.367,4.665,10.367,10.367l0,0c0,5.702-4.664,10.367-10.367,10.367H10.368C4.666,103.609,0,98.944,0,93.242l0,0 C0,87.54,4.666,82.875,10.368,82.875L10.368,82.875z M10.368,41.438h102.144c5.703,0,10.367,4.665,10.367,10.367l0,0 c0,5.702-4.664,10.368-10.367,10.368H10.368C4.666,62.173,0,57.507,0,51.805l0,0C0,46.103,4.666,41.438,10.368,41.438 L10.368,41.438z"/></g></svg>          
          </button>
          <div className="navbar-nav" style={navbarEstilos}>
              {
              
              lista.map(element => {
                  contador++; 
                  return(
                    <a key ={contador * 10} className="navbar-link" onClick={onLinkClick} disabled={ selector[contador]} >{element}</a>
                  )
                })
              }
          </div>
        </div>

      </>
  
  
    )
  }