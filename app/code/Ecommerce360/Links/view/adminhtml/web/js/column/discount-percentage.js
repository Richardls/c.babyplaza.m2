define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html'
        },

        getLabel: function (row) {
            // Obtiene el valor de `discount_percentage` y añade el símbolo %
            var discountPercentage = row['discount_percentage'] ? parseFloat(row['discount_percentage']).toFixed(2) : 0;
            return discountPercentage + '%';
        }
    });
});
