/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {  InnerBlocks, useBlockProps } from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name } = attributes
	const blockProps = useBlockProps.save();

	return (
		<div {...blockProps} name={name}>
			<InnerBlocks.Content />	
	</div>
);
}
