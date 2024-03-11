/*
    Función __

    params: 
        string => cadena a buscar en el objeto de traducciones
        object => objeto de traducciones 

    return
        string => cadena traducida o sin traducir

    Cometido: Esta función recibe una cadena a traducir, que debe estar como argumento dentro del objeto
              de traducciones, devolvera la traducción o en cado de ho encontrarse, la misma cadena.
*/

export const __ = (string, object) => {

    if (object[string] != undefined)
        return object[string]
    else return string


}