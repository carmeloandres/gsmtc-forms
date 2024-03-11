/*
*   Este contexto lo utilizaré para almacenar las credenciales
*   de acceso a la api para poderle realizar peticiones
*/

// importamos la función para la creación del contexto de react
import { createContext  } from "react";

// Creamos nuestro propio contexto usando la función de react createContext()
export const ApiContext = createContext();	