/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { group, name, checked } = attributes
	const blockProps = useBlockProps.save();

	return (
		<input type="radio" {...blockProps} name={group} value={name} checked={checked} />
		);
}
