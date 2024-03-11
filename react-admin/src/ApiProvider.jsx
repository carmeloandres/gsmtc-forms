/*
*   Este Provider lo utilizaré para gestionar el acceo a los
*   datos almacenados en la ApiContext.
*/

// importamos el contexto ApiContext, que es donde se almacenan los datos de la Api
import { useState } from "react"
import { ApiContext } from "./ApiContext"

export const ApiProvider = ({ childen }) => {

    const apiVacia = {          
        "restUrl":"<?php echo rest_url( '/gsmtc-forms/sdmin' ); ?>",
        "nonce":"<?php echo wp_create_nonce('wp_rest') ?>",
        "homeUrl":"<?php echo home_url() ?>",
    }

    const [api, setApi] = useState(apiVacia);

    return(
        <ApiContext.Provider value={ { api, setApi } } >
            { childen }
        </ApiContext.Provider>
    )
}