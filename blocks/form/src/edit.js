import { __ } from '@wordpress/i18n';
import { useEffect, useState } from "@wordpress/element"
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Button, Panel, PanelBody, TextControl, RadioControl} from  '@wordpress/components';

export default function Edit({attributes, setAttributes}) {

	const { id, name, response, sendmessage, failmessage, successmessage } = attributes
	const blockProps = useBlockProps();
	
	// Habilira o deshabilita el boton para generar un nuevo id del formulario
	// y por lo tanto un nuevo formulario
	const [disabledButton, setDisabledButton] = useState(false);

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
                            label={__('Message when sending information','gsmtc-forms')}
                            value={sendmessage}
                            onChange={(value) => setAttributes({ sendmessage: value })}
	            	    />
						<TextControl
                            label={__('Message when the sending of information fails','gsmtc-forms')}
                            value={failmessage}
                            onChange={(value) => setAttributes({ failmessage: value })}
	            	    />
						<TextControl
                            label={__('Message when the sending of information is successful','gsmtc-forms')}
                            value={successmessage}
                            onChange={(value) => setAttributes({ successmessage: value })}
	            	    />
					</PanelBody>
				</Panel>

			</InspectorControls> 
			<div>
			</div>
			<form {...blockProps} id={id} name={name} >
				<input type="submit" value="To prevent submit at press enter" hidden={true} disabled={true} />

				<InnerBlocks />
	
			</form>
		</>
	);
}
