/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import {useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

	const { name, placeHolder, required } = attributes
	const blockProps = useBlockProps.save();

//	<input type="text" {...blockProps} value={defaultValue} name={name}  required={required} pattern={"^[a-zA-Z0-9&#47;s'&#47;\"&#47;?!]+$"} title={validationMessage}/>
//^[^><]{0,249}$

// <input type="text" {...blockProps} value={defaultValue} name={name}  required={required} pattern={"^[a-zA-Z0-9&#92;s]+$"} title={validationMessage}/>

	return (
		<input type="text" {...blockProps} placeholder={placeHolder} name={name}  required={required} pattern={"^[^><]{0,249}$"} />
		);
}