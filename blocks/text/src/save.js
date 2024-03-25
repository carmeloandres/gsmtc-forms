/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name, placeHolder, required } = attributes
	const blockProps = useBlockProps.save();

	return (
		<input type="text" {...blockProps} placeholder={placeHolder} name={name}  required={required} />
		);
}