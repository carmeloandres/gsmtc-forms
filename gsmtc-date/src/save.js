/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name, defaultValue, required, hidden } = attributes
	const blockProps = useBlockProps.save();

	return (
		<input type="date" {...blockProps} value={defaultValue} name={name}  required={required} hidden={hidden}/>
		);
}
