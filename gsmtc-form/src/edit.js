/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useEffect, useState } from "@wordpress/element"
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Button, Notice, Panel, PanelBody, TextControl} from  '@wordpress/components';



export default function Edit({attributes, setAttributes}) {

	const { id, name } = attributes
	const blockProps = useBlockProps();
	
	const [disabledButton, setDisabledButton] = useState(false);



	useEffect(() => {
		if (id == '0') {
			let segundos = Math.trunc(Date.now() / 1000);
			setAttributes({id: segundos.toString()})
			setDisabledButton(true);
		}
	},[])

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
			</InspectorControls> 
			<div>
			</div>
			<form {...blockProps} id={id} name={name} >
				<InnerBlocks />
			</form>
		</>
	);
}
