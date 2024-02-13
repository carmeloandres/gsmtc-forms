/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save() {

	const blockProps = useBlockProps.save();

	return (
		<input type="email" {...blockProps} name='main-email'  required={true} />
		);
}
