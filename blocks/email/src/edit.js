/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl, ToggleControl} from  "@wordpress/components";



export default function Edit({attributes, setAttributes}) {
	const { name, placeHolder, required, main } = attributes
	const blockProps = useBlockProps();
	
	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Input email information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Input name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<TextControl
                            label={__('Place holder value','gsmtc-forms')}
                            value={placeHolder}
                            onChange={(value) => setAttributes({ placeHolder: value })}
	            	    />
						<ToggleControl
						    label={__('Identification main email','gsmtc-forms')}
                    		checked={main}
                    		onChange={(value) => {
								setAttributes({ main: value })
								if (value == true)
									setAttributes({ required:value})
								console.log(value,typeof(value));
						}}
                		/>
						<ToggleControl
						    label={__('Required','gsmtc-forms')}
                    		checked={required}
                    		onChange={(value) => setAttributes({ required: value })}
                		/>
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<input type="email" {...blockProps} name={name}  placeholder={placeHolder} required={required} />
		</>
	);
}
