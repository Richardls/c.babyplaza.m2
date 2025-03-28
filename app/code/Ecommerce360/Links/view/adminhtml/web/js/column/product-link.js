define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html'
        },

        getLabel: function (row) {
            var link = row['link_url'];
            if (link) {
                return '<a href="' + link + '" target="_blank" rel="noopener noreferrer">' + link + '</a>';
            }
            return '';
        }
    });
});
