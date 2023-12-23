/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { cols, name, placeholder, required, rows } = attributes
	const blockProps = useBlockProps.save();

	return (
		<textarea name={name} {...blockProps}   cols={cols} placeholder={placeholder} required={required} rows={rows}>
		</textarea>
	);
}
