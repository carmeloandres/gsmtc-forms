import { useState, useEffect } from 'react';
//import './Pagination.scss';

export const Pagination = ({
    current, last, onClick
  }) => {
  
    const [ first, setFirst] = useState(1);
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

    const onClickButton = (event) =>{
      onClick(event);
    }
      
    return (
        <div className='gsmtc-admin-pagination'>
            <button onClick={onClickButton} disabled={ firstDisabled }>First</button>
            <button onClick={onClickButton} disabled={ firstDisabled }>Previous</button>
            <span> Page {current}</span>
            <button onClick={onClickButton} disabled={ lastDisabled }>Next</button>
            <button onClick={onClickButton} disabled={ lastDisabled }>Last</button>
        </div>
    )
  }