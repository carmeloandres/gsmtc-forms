/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl, ToggleControl} from  "@wordpress/components";



export default function Edit({attributes, setAttributes}) {
	const { group, name, checked  } = attributes
	const blockProps = useBlockProps();
	
	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Input radio information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Radio group','gsmtc-forms')}
                            value={group}
                            onChange={(value) => setAttributes({ group: value })}
	            	    />
						<TextControl
                            label={__('Radio name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<ToggleControl
						    label={__('Value','gsmtc-forms')}
                    		checked={checked}
                    		onChange={(value) => setAttributes({ checked: value })}
                		/>
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<input type="radio" {...blockProps} name={group}  value={name} checked={checked}/>
		</>
	);
}
