/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

import {InnerBlocks, useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

		const {id, name, response, sendmessage, failmessage, successmessage } = attributes;
		const blockProps = useBlockProps.save();


	return (
			<>
				<form {...blockProps} id={ id } name={ name } data-response={ response } data-send-message={ sendmessage } data-fail-message={ failmessage } data-success-message={ successmessage }>
					<InnerBlocks.Content />
				</form>
			</>
);
}
