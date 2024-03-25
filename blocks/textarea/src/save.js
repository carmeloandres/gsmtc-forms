/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name, placeholder, required, cols, rows } = attributes
	const blockProps = useBlockProps.save();

	return (
		<textarea {...blockProps} name={name}  placeholder={placeholder} required={required} cols={cols} rows={rows} />
	);
}
