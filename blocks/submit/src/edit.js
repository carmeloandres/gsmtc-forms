
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl } from  "@wordpress/components";

export default function Edit({attributes, setAttributes}) {
	const { text } = attributes
	const blockProps = useBlockProps();
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
				</Panel>
			</InspectorControls>
			<input  {...blockProps} type="submit" value={text} />
		</>
	);
}
