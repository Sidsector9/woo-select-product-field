/**
 * External dependencies
 */
import { useWooBlockProps } from '@woocommerce/block-templates';
import { createElement } from '@wordpress/element';
import { SelectControl } from '@wordpress/components';
import { MultiSelectControl } from '@codeamp/block-components';
import {
	__experimentalUseProductEntityProp as useProductEntityProp,
} from '@woocommerce/product-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 */
export function Edit( { attributes, context: { postType } } ) {
	const {
		title,
		property,
		options,
		help,
		multiple,
	} = attributes;

	const blockProps = useWooBlockProps( attributes );
	const [ value, setValue ] = useProductEntityProp( property, { postType } );
	const CustomSelectControl = multiple ? MultiSelectControl : SelectControl;

	return (
		<div { ...blockProps }>
			<CustomSelectControl
				label={ title }
				options={ options }
				value={ value || ( multiple ? [] : '' ) }
				onChange={ setValue }
				help={ help }
			/>
		</div>
	);
}
