/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl } from  "@wordpress/components";



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
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<div {...blockProps} name={name}>
				<InnerBlocks />
			</div>
		</>
	);
}
