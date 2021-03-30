define([
    'jquery',
    'uiComponent',
    'CanvasJSChart'
], function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            animationEnabled: true,
            theme: "light2",
        },

        /**
         * Init
         */
        initialize: function (data, element) {
            this._super();

            $(element).CanvasJSChart({
                animationEnabled: this.animationEnabled,
                theme: "light2",
                title: {
                    text: "Price History",
                },
                axisX: {
                    valueFormatString: "DD MMM YYYY",
                },
                axisY: {
                    title: "USD",
                    titleFontSize: 24
                },
                data: [{
                    type: "spline",
                    yValueFormatString: "$#,###.##",
                    dataPoints: data.dataPoints
                }]
            });
        }
    });
});
