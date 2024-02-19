import { __ } from '@wordpress/i18n';
import { useEffect, useState } from "@wordpress/element"
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Button, Panel, PanelBody, TextControl, RadioControl} from  '@wordpress/components';

export default function Edit({attributes, setAttributes}) {

	const { id, name, response, message } = attributes
	const blockProps = useBlockProps();
	
	// Habilira o deshabilita el boton para generar un nuevo id del formulario
	// y por lo tanto un nuevo formulario
	const [disabledButton, setDisabledButton] = useState(false);

	//Habilita la edición de mensaje en caso de que la acción de respuesta sea "Hide"
	const [disableText, setDisableText] = useState(false);

	// Esta función se ejecuta para establecer la habilitación del boton de crear nuevo formulario
	const onUpdateButton = () => {
		setDisabledButton(false);
	} 

	useEffect(() => {
		// Establece el id en función del tiempo, en caso de no estar establecido
		if (id == '0') {
			let segundos = Math.trunc(Date.now() / 1000);
			setAttributes({id: segundos.toString()})
			setDisabledButton(true);
		}

		// Añade un "event listener" al boton de actualizar post, para detectar cuando se realiza
		// un guardado del post, y por tanto del formulario
		let inputs = Array.from(document.getElementsByClassName('editor-post-publish-button'));
		if (inputs.length > 0){
				let button = inputs[0]
				button.addEventListener('click',onUpdateButton);
			}

	},[])
	
	// Establece el estadode la edición de mensaje de respuesta, segun el valor de respuesta
	useEffect(() => {
		if (response == 'hide')
			setDisableText(false)
		else setDisableText(true)
	},[response])

	// Esta función genera un nuevo id para el formulario
	const handleClick = () => {
		let segundos = Math.trunc(Date.now() / 1000);
		setAttributes({id: segundos.toString()});
		setDisabledButton(true);
	}


	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Form information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Form name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<Button 
							disabled={disabledButton}
							onClick={handleClick}
							style={{
								// Estilos en línea (puedes ajustar según tus necesidades)
								backgroundColor: '#0073aa',
								color: '#fff',
								borderRadius: '4px',
								padding: '8px 16px',
								fontSize: '14px',
							  }}	
							>
              				{__('Set as new Form','gsmtc-forms')}
            			</Button>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody title={__('Form submit response ','gsmtc-forms')} initialOpen={true}>
						<RadioControl 
							label={__('Select response action after success submit','gsmtc-forms')} 
							help={__('Chose what actión to perform with form after a success submit','gsmtf-forms')} 
							selected={ response }
							options={ [
								{label: 'Nothing', value: 'nothing'},
								{label: 'Clean', value: 'clean'},
								{label: 'Hide', value: 'hide'},
							] }
							onChange={ (newValue)  => setAttributes( { response: newValue } )}
						/>
						<TextControl
                            label={__('Form message after success submit in "Hide response"','gsmtc-forms')}
                            value={message}
							disabled={disableText} // Deshabilita el TextControl
                            onChange={(value) => setAttributes({ message: value })}
	            	    />
					</PanelBody>
				</Panel>

			</InspectorControls> 
			<div>
			</div>
			<form {...blockProps} id={id} name={name} >
				<InnerBlocks />
			</form>
		</>
	);
}
