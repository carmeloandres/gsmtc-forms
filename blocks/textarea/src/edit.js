/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, RangeControl, TextControl, ToggleControl} from  "@wordpress/components";



export default function Edit({attributes, setAttributes}) {
	const { cols, name, placeholder, required, rows} = attributes
	const blockProps = useBlockProps();
	
	return (
		<>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Input text information ','gsmtc-forms')} initialOpen={true}>
						<TextControl
                            label={__('Input name','gsmtc-forms')}
                            value={name}
                            onChange={(value) => setAttributes({ name: value })}
	            	    />
						<TextControl
                            label={__('Placeholder','gsmtc-forms')}
                            value={placeholder}
                            onChange={(value) => setAttributes({ placeholder: value })}
	            	    />
					     <RangeControl
							label={__('Rows number','gsmtc-forms')}
          					value={rows}
          					onChange={(newValue) => setAttributes({rows: newValue})}
          					min={1}
          					max={50}
        				/>
					     <RangeControl
							label={__('Cols number','gsmtc-forms')}
          					value={cols}
          					onChange={(newValue) => setAttributes({cols: newValue})}
          					min={1}
          					max={100}
        				/>
						<ToggleControl
						    label={__('Required','gsmtc-forms')}
                    		checked={required}
                    		onChange={(value) => setAttributes({ required: value })}
                		/>
					</PanelBody>
				</Panel>
			</InspectorControls> 
			<textarea {...blockProps} name={name} cols={cols} placeholder={placeholder} required={required} rows={rows}>
			</textarea>
		</>
	);
}
