/**
 * Importamos RicheText para poder incluir opciones a nuestro bloque
 */
 import {InspectorControls, RichText} from "@wordpress/block-editor";
 import {Panel, PanelBody, TextControl, TextareaControl} from  "@wordpress/components";
 
 export default function Edit(props) {
     const {className,attributes,setAttributes} = props;
     const {title, nameLabel, emailLabel, mensajeLabel, checkboxLabel, urlLink, urlLabel, acordeonLabel, acordeonContent} = attributes;
 
     return (
         <>
         <InspectorControls>
             <Panel>
                 <PanelBody title="Etiquetas" initialOpen={false}>
                     <TextControl 
                         label = "Etiqueta del nombre"
                         value = {nameLabel}
                         onChange={(newLabel) => setAttributes({nameLabel : newLabel}) }
                     />
                     <TextControl 
                         label = "Etiqueta del email"
                         value = {emailLabel}
                         onChange={(newLabel) => setAttributes({emailLabel : newLabel}) }
                     />
                     <TextControl 
                         label = "Etiqueta del mensaje"
                         value = {mensajeLabel}
                         onChange={(newLabel) => setAttributes({mensajeLabel : newLabel}) }
                     />
                     <TextControl 
                         label = "Texto de la casilla de verificación"
                         value = {checkboxLabel}
                         onChange={(newLabel) => setAttributes({checkboxLabel : newLabel}) }
                     />
                     <TextControl
                         label = "URL de la politica de privacidad" 
                         value ={urlLink}
                         onChange = {(newUrl) => setAttributes({urlLink : newUrl})}
                     />
                     <TextControl
                         label = "Etiqueta del enlace de privacidad" 
                         value ={urlLabel}
                         onChange = {(newlabel) => setAttributes({urlLabel : newlabel})}
                     />
                     <TextControl
                         label = "Etiqueta del boton de acordeon" 
                         value ={acordeonLabel}
                         onChange = {(newlabel) => setAttributes({acordeonLabel : newlabel})}
                     />
                     <TextareaControl
                         label = "Contenido del acordeon" 
                         value ={acordeonContent}
                         onChange = {(newContent) => setAttributes({acordeonContent : newContent})}
                     />					
                 </PanelBody>
             </Panel>
         </InspectorControls>
         <div className={className}>
             <div className="gsmtc-contact-contenedor-titulo">
                 <RichText
                     tagName="h2"
                     placeholder="Escribir un titulo"
                     className="gsmtc-contact-titulo"
                     value={title}
                     onChange={(newTitle) => setAttributes({title: newTitle})}
                 />
             </div>
             <div className="gsmtc-contact-contenedor-formulario">
                 <form className = "gsmtc-contact-form" action="" name="gsmtc-contact-form"  method="post" enctype="multipart/form-data">
                     <div className = "gsmtc-contact-nombre">
                         <input type="text" name="gsmtc-contact-name" placeholder={nameLabel}/>
                     </div>
                     <div className = "gsmtc-contact-email">
                         <input type="email" name="gsmtc-contact-email" placeholder={emailLabel}/>
                     </div>
                     <div className = "gsmtc-contact-mensaje">
                         <textarea placeholder={mensajeLabel} name="gsmtc-contact-message">
                         </textarea> 
                     </div>
                     <div className="gsmtc-contact-checbox">
                         <input type="checkbox" name="gsmtc-contact-checkbox"/>
                         {checkboxLabel} 
                         <a href={urlLink} target="_blank" rel="noreferrer noopener nofollow"> {urlLabel}</a>						
                     </div>
                     <div className = "gsmtc-contact-boton">
                         <input name="gsmtc-contact-boton" type="submit" value="enviar" />
                     </div>
                     <div className ="gsmtc-contact-aviso">
 
                     </div>
                     <div className = "gsmtc-contact-titulo-acordeon">
                         {acordeonLabel}
                     </div>
                     <div className = "gsmtc-contact-contenido-acordeon">
                         {acordeonContent}
                     </div>
                 </form>
             </div>
         </div>
         </>
     );
 }
 