/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import {RichText,useBlockProps} from "@wordpress/block-editor";


export default function save({attributes}) {
		const {content, forInput} = attributes;
		const blockProps = useBlockProps.save();

	return (
			<RichText.Content
			 	{ ...blockProps }
				tagName='label'
				for={forInput}
				value={content}
			/>
		);
}
