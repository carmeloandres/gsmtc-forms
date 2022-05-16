/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
 import { registerBlockType } from '@wordpress/blocks';

 /**
  * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
  * All files containing `style` keyword are bundled together. The code used
  * gets applied both to the front of your site and to the editor.
  *
  * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
  */
 import './style.scss';
 
 /**
  * Internal dependencies
  */
 import Edit from './edit';
 import Save from './save';
 
// function Edit() {
//	 return (
//		 <p {...useBlockProps()}>
//			 {__('Gsmtc Forms – hello from the editor!', 'gsmtc-forms')}
//		 </p>
//	 );
// }

//function save() {
//	return (
//		<p {...useBlockProps()}>
//			{__('Gsmtc Forms – hello from the editor!', 'gsmtc-forms')}
//		</p>
//	);
//};

 /**
  * Every block starts by registering a new block type definition.
  *
  * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
  */
 registerBlockType('gsmtc-forms/simple-contact', {
     title: "Simple contact",
     category: "gsmtc",
     icon: "editor-table",
     attributes:{
		title:{
			source: "html",
			selector: "h1",
			default: "Contacto"
		},
		nameLabel:{
			type : "string",
			default : "Name",
		},
		emailLabel:{
			type : "string",
			default : "Email",
		},
		mensajeLabel:{
			type : "string",
			default : "Mensaje",
		},
		checkboxLabel:{
			type:"string",
			default:"He leido y acepto la ",
		},
		urlLink:{
			type: "string",
			default : "pega la URL del enlace",
		},
		urlLabel:{
			type: "string",
			default: "politica de privacidad",
		},
		acordeonLabel:{
			type: "string",
			default: "politica de privacidad",
		},
		acordeonContent:{
			type: "string",
			default: "politica de privacidad",
		}
	},
     /**
      * @see ./edit.js
      */
     edit: Edit,
     //edit: <p>Hola Mundo</p>,
     /**
      * @see ./save.js
      */
     save: Save,
     //save: <p>Hola Mundo</p>,
 });
 