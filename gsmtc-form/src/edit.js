/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useEffect, useState } from "@wordpress/element"
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {Panel, PanelBody, TextControl} from  "@wordpress/components";



export default function Edit({attributes, setAttributes}) {
	const { id, name } = attributes
	const blockProps = useBlockProps();
	
	useEffect(() => {
		if (id == '0') {
			let segundos = Math.trunc(Date.now() / 1000);
			setAttributes({id: segundos.toString()})
		}
	},[])

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
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<form {...blockProps} id={id} name={name} >
				<InnerBlocks />
			</form>
		</>
	);
}
