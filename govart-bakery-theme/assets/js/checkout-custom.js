const { __ } = wp.i18n;
const { addFilter } = wp.hooks;

console.log('JS personnalisé chargé 🎉');

const customCheckoutField = ( fields ) => {
	fields.push({
		name: 'date_retrait',
		label: __('Date de retrait', 'govart'),
		component: 'TextInput', // ou un composant datepicker custom si tu veux
		placeholder: __('YYYY-MM-DD', 'govart'),
		required: true,
	});
	return fields;
};

addFilter(
	'woocommerce.blocks.checkout.shippingFields',
	'govart-bakery-theme/custom-date-retrait',
	customCheckoutField
);

