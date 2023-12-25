/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name, defaultValue, required, validationPattern, validationMessage } = attributes
	const blockProps = useBlockProps.save();

	return (
		<input type="text" {...blockProps} value={defaultValue} name={name}  required={required} pattern={validationPattern} title={validationMessage}/>
		);
}
