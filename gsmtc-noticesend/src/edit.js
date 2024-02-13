/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useState } from "@wordpress/element"
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl } from  "@wordpress/components";

const [show, setShow] = useState('block');
const [checked, setChecked] = useState(true);

const toggleShow = () => {
	if (show == 'block'){
		setShow('none');
		setChecked(false);
	}
	else {
		setShow('block');
		setChecked(true);
	}
}

export default function Edit({attributes, setAttributes}) {
	const { name } = attributes
	const blockProps = useBlockProps();
	
	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('On Send Notice name','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<ToggleControl
						    label={__('Show/Hide (for test purposes)','gsmtc-forms')}
                    		checked={checked}
                    		onChange={ () => toggleShow() }
                		/>
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<div {...blockProps} name={name} style={{ display : show }}>
				<InnerBlocks />
			</div>
		</>
	);
}
