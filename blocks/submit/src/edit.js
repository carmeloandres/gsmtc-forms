
import { __ } from '@wordpress/i18n';
import { useState } from "@wordpress/element"
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, RadioControl, TextControl } from  "@wordpress/components";

import './gsmtc-forms-submit.css';

export default function Edit({attributes, setAttributes}) {
	const { text , miClase} = attributes
//	const [miClase,setMiclase] = useState('is-content-justification-center');
	const blockProps = useBlockProps({
		className:'gsmtc-forms-submit-content justify-content-center',
	});

	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Submit text button ','gsmtc-forms')} initialOpen={true}>
					<TextControl
                            label={__('Button text','gsmtc-forms')}
                            value={text}
                            onChange={(value) => setAttributes({ text: value })}
	            	    />
					</PanelBody>
					<RadioControl 
						label={__('Justidication content')} 
						help={__('How content is judtified')} 
						selected={ miClase }
						options={ [
							{label: 'Izquierda', value: 'is-content-justification-left'},
							{label: 'Centro', value: 'is-content-justification-center'},
							{label: 'Derecha', value: 'is-content-justification-right'},
							{label: 'Ancho completo', value: 'is-content-justification-strech'},
						] }
						onChange={ (newValue)  => setAttributes( { miClase: newValue } )}
					/>
				</Panel>
			</InspectorControls>
			<div {...blockProps} >
				<input  className='wp-element-button' type="submit" value={text} />
			</div>
		</>
	);
}
