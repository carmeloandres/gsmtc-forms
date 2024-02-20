/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl, ToggleControl} from  "@wordpress/components";

export default function Edit({attributes, setAttributes}) {
	const { name, defaultValue, required, validationMessage } = attributes
	const blockProps = useBlockProps();
	
	const validationPattern = "^[a-zA-Z0-9\s'\"]+$";

	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Input text information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Input name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<TextControl
                            label={__('Default value','gsmtc-forms')}
                            value={defaultValue}
                            onChange={(value) => setAttributes({ defaultValue: value })}
	            	    />
						<ToggleControl
						    label={__('Required','gsmtc-forms')}
                    		checked={required}
                    		onChange={(value) => setAttributes({ required: value })}
                		/>
						<TextControl
                            label={__('Validation message','gsmtc-forms')}
                            value={validationMessage}
                            onChange={(value) => setAttributes({ validationMessage: value })}
	            	    />
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<input type="text" {...blockProps} name={name}  required={required} value={defaultValue} pattern={"^[a-zA-Z0-9\s'\"\?!]+$"} title={validationMessage}/>
		</>
	);
}