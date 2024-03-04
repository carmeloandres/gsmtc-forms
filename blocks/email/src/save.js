/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name, placeHolder, required, main } = attributes
	const blockProps = useBlockProps.save();

	return (
		<input type="email" {...blockProps} name={name} placeholder={placeHolder} required={required} data-main-email={main} pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"/>
		);
}
