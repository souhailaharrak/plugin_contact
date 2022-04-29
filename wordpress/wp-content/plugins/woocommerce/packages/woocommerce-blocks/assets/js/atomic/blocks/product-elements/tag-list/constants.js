/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { tag, Icon } from '@woocommerce/icons';

export const BLOCK_TITLE = __(
	'Product Tag List',
	'woocommerce'
);
export const BLOCK_ICON = (
	<Icon
		srcElement={ tag }
		className="wc-block-editor-components-block-icon"
	/>
);
export const BLOCK_DESCRIPTION = __(
	'Display a list of tags belonging to a product.',
	'woocommerce'
);
