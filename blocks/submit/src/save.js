
import { useBlockProps } from '@wordpress/block-editor';

import './gsmtc-forms-submit.css';

export default function save({attributes}) {
	const { miClase, text } = attributes
	const blockProps = useBlockProps.save({
		className : 'gsmtc-forms-submit-container justify-content-center'
	});
	
	return (
		<>
		<div {...blockProps}>
			<input className='wp-element-button' type="submit" value={text} />
		</div>
		</>	
		);
}
