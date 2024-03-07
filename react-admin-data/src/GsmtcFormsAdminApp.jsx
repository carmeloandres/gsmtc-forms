import { useState } from 'react'
import { ApiContext } from "./ApiContext";


//import './App.css'

export const GsmtcFormsAdminApp = () => {

  // 
  const [ api, setApi ] = useState(gsmtcFormsApi);

  const [count, setCount] = useState(0)

  return (
    <>
  <ApiContext.Provider value={ { api, setApi }} >
      <h1>Gsmtc forms Admin</h1>
      <div>
        <button onClick={() => setCount((count) => count + 1)}>
          count is {count}
        </button>
        <p>
          Edit <code>src/App.jsx</code> and save to test HMR
        </p>
      </div>    
      </ApiContext.Provider>
    </>
  )
}
