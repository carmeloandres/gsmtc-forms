/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

import {InnerBlocks, useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {

		const {id, name, response, message } = attributes;
		const blockProps = useBlockProps.save();


	return (
			<>
				<form {...blockProps} id={ id } name={ name } data-response={ response } data-message={ message }>
					<InnerBlocks.Content />
				</form>
			</>
);
}
