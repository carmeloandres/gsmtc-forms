/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {
		const {content, forInput} = attributes;
		const blockProps = useBlockProps.save();

	return (
		<label for={forInput}  {...blockProps}>{content}</label> 
		);
}
