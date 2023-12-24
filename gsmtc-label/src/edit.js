/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import {Panel, PanelBody, TextControl } from  "@wordpress/components";



export default function Edit({attributes, setAttributes}) {
	const { content, forInput } = attributes
	const blockProps = useBlockProps();
	
	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Input text information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('For Input name','gsmtc-forms')}
                            value={forInput}
                            onChange={(value) => setAttributes({ forInput: value })}
	            	    />
						<TextControl
                            label={__('Label text','gsmtc-forms')}
                            value={content}
                            onChange={(value) => setAttributes({ content: value })}
	            	    />
					</PanelBody>
				</Panel>
			</InspectorControls>
			<RichText
			 	{ ...blockProps }
				tagName='label'
				for={forInput}
				placeholder={__('Label','gsmtc-forms')}
				value={content}
				onChange={(newLabel) => setAttributes({content:newLabel})}
			/>
		</>
	);
}
