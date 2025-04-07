define(['jquery', 'chartjs'], function($, Chart) {
    return {
        init: function() {
            var sku = window.productSku || '';
            if (!sku) {
                console.log('SKU no encontrado para historial de precios.');
                return;
            }
            var defaultMonths = 3;
            this.loadChartData(sku, defaultMonths);
            
            // Eventos para los botones de filtro
            $('.price-history-filters button').on('click', function(){
                var months = $(this).data('range');
                if (window.priceHistoryChart) {
                    window.priceHistoryChart.destroy();
                }
                require('Ecommerce360_PriceHistory/js/pricehistory').loadChartData(sku, months);
            });
        },
        loadChartData: function(sku, months) {
            var self = this;
            $.ajax({
                url: '/pricehistory/ajax/get',
                type: 'GET',
                dataType: 'json',
                data: {
                    sku: sku,
                    months: months
                },
                success: function(response) {
                    self.renderChart(response);
                },
                error: function(err) {
                    console.log('Error al cargar datos del historial de precios:', err);
                }
            });
        },
        renderChart: function(data) {
            var labels = [];
            var prices = [];
            var tooltips = [];
            
            data.forEach(function(entry) {
                labels.push(entry.history_date);
                prices.push(entry.min_price);
                tooltips.push('Precio: ' + entry.min_price + ' - ' + entry.store_name);
            });
            
            var ctx = document.getElementById('priceHistoryChart').getContext('2d');
            window.priceHistoryChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Precio Mínimo',
                        data: prices,
                        fill: false,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, chartData) {
                                var index = tooltipItem.index;
                                return tooltips[index];
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            type: 'time',
                            time: {
                                unit: 'day'
                            }
                        }]
                    }
                }
            });
        }
    };
});
