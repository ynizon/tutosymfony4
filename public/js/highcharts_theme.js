/**
 * @license Highcharts JS v6.0.7 (2018-02-16)
 *
 * (c) 2009-2017 Highsoft AS
 *
 * License: www.highcharts.com/license
 */
'use strict';
(function(factory) {
    if (typeof module === 'object' && module.exports) {
        module.exports = factory;
    } else {
        factory(Highcharts);
    }
}(function(Highcharts) {
    (function(Highcharts) {
        /**
         * (c) 2010-2017 Highsoft AS
         *
         * License: www.highcharts.com/license
         * 
         * Accessible high-contrast theme for Highcharts. Considers colorblindness and 
         * monochrome rendering.
         * @author Øystein Moseng
         */

        Highcharts.theme = {
            colors: ['#004165', '#978859', '#000000', '#93B1CC','#404545','#B9C9D0','#747F81','#636466','#dcddde','#822433','#A17700','#E2CDB8','#9DBCB0'],

            colorAxis: {
                maxColor: '#60042E',
                minColor: '#FDD089'
            },

            plotOptions: {
                map: {
                    nullColor: '#fefefc'
                }
            },

            navigator: {
                series: {
                    color: '#FF7F79',
                    lineColor: '#A0446E'
                }
            }
        };

        // Apply the theme
        Highcharts.setOptions(Highcharts.theme);

    }(Highcharts));
}));
