/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl, ToggleControl} from  "@wordpress/components";



export default function Edit({attributes, setAttributes}) {
	const { name, defaultValue, required } = attributes
	const blockProps = useBlockProps();
	
	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Input text information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Checkbox name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<ToggleControl
						    label={__('Default value','gsmtc-forms')}
                    		checked={defaultValue}
                    		onChange={(value) => setAttributes({ defaultValue: value })}
                		/>
						<ToggleControl
						    label={__('Required','gsmtc-forms')}
                    		checked={required}
                    		onChange={(value) => setAttributes({ required: value })}
                		/>
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<input type="checkbox" {...blockProps} name={name}  required={required} checked={defaultValue}/>
		</>
	);
}
