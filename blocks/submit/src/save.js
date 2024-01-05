
import { useBlockProps } from '@wordpress/block-editor';

export default function save({attributes}) {
	const { text } = attributes
	const blockProps = useBlockProps.save();
	
	return (
		<>
			<input {...blockProps} type="submit" value={text} />
		</>	
		);
}
