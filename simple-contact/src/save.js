/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
/*import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
/*import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
 import {RichText} from "@wordpress/block-editor";
 //import {Panel, PanelBody, TextControl} from  "@wordpress/components";
 
 export default function Save(props) {
	 const {className,attributes} = props;
	 const {title, nameLabel, emailLabel, mensajeLabel, checkboxLabel, urlLink, urlLabel} = attributes;
 
	 return (
		 <div className={className}>
			 <div className="gsmtc-contact-contenedor-titulo">
				 <RichText.Content
					 tagName="h2"
					 className="gsmtc-contact-titulo"
					 value={title}
				 />
			 </div>
			 <div className="gsmtc-contact-contenedor-formulario">
				 <form className = "gsmtc-contact-form" action="" name="gsmtc-contact-form"  method="post" enctype="multipart/form-data" onsubmit="gsmtcContactFormSubmit">
					 <div className = "gsmtc-contact-nombre">
						 <input type="text" id="gsmtc-contact-name" name="name" placeholder={nameLabel} required/>
					 </div>
					 <div className = "gsmtc-contact-email">
						 <input type="email" id="gsmtc-contact-email"  name="email" placeholder={emailLabel} required/>
					 </div>
					 <div className = "gsmtc-contact-mensaje">
						 <textarea id="gsmtc-contact-message" name="message" placeholder={mensajeLabel} required>
						 </textarea> 
					 </div>
					 <div className="gsmtc-contact-checbox">
						 <input type="checkbox" name="accept" required/>
						 {checkboxLabel} 
						 <a href={urlLink} target="_blank" rel="noreferrer noopener nofollow"> {urlLabel}</a>						
					 </div>
					 <div className = "gsmtc-contact-boton">
						 <input id="gsmtc-contact-boton" type="submit" name="submit" value="enviar" />
					 </div>
					 <div className ="gsmtc-contact-aviso">
 
					 </div>
					 <div className = "gsmtc-contact-titulo-acordeon">
 
					 </div>
				 </form>
			 </div>
		 </div>
	 );
 }
 
