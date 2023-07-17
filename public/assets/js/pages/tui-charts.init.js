// Donut pie chart

var donutpieChartWidth = $("#lahir-charts").width();
var container = document.getElementById('lahir-charts');
var data = {
    categories: ['Browser'],
    series: [
        {
            name: 'Chrome',
            data: 46.02
        },
        {
            name: 'IE',
            data: 20.47
        },
        {
            name: 'Firefox',
            data: 17.71
        },
        {
            name: 'Safari',
            data: 5.45
        },
        {
            name: 'Etc',
            data: 10.35
        }
    ]
};
var options = {
    chart: {
        width: donutpieChartWidth,
        height: 380,
        // title: 'Periode',
        format: function(value, chartType, areaType, valuetype, legendName) {
            if (areaType === 'makingSeriesLabel') { // formatting at series area
                value = value;
            }

            return value;
        }
    },
    series: {
        radiusRange: ['40%', '100%'],
        showLabel: true
    },
    // tooltip: {
    //     suffix: '%'
    // },
    legend: {
        align: 'top'
    },
    exportMenu: {
        visible: false
    },
};
var theme = {
    chart: {
        background: {
            color: '#fff',
            opacity: 0
        },
    },
    title: {
        color: '#8791af',
    },

    plot: {
        lineColor: 'rgba(166, 176, 207, 0.1)'
    },
    legend: {
        label: {
            color: '#8791af'
        }
    },
    series: {
        series: {
            colors: [
                '#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c'
            ]
        },
        label: {
            color: '#fff',
            fontFamily: 'sans-serif'
        }
    }
};

// For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';

var donutChart = tui.chart.pieChart(container, data, options);

$( window ).resize(function() {
    donutpieChartWidth = $("#lahir-charts").width();
    donutChart.resize({
        width: donutpieChartWidth,
        height: 350
    });
});

// Pie charts

// var pieChartWidth = $("#pie-charts").width();
// var container = document.getElementById('pie-charts');
// var data = {
//     categories: ['Browser'],
//     series: [
//         {
//             name: 'Chrome',
//             data: 46.02
//         },
//         {
//             name: 'IE',
//             data: 20.47
//         },
//         {
//             name: 'Firefox',
//             data: 17.71
//         },
//         {
//             name: 'Safari',
//             data: 5.45
//         },
//         {
//             name: 'Etc',
//             data: 10.35
//         }
//     ]
// };
// var options = {
//     chart: {
//         width: pieChartWidth,
//         height: 380,
//         title: 'Usage share of web browsers'
//     },
//     tooltip: {
//         suffix: '%'
//     }
// };
// var theme = {
//     chart: {
//         background: {
//             color: '#fff',
//             opacity: 0
//         },
//     },
//     title: {
//         color: '#8791af',
//     },

//     plot: {
//         lineColor: 'rgba(166, 176, 207, 0.1)'
//     },
//     legend: {
//         label: {
//             color: '#8791af'
//         }
//     },
//     series: {
//         colors: [
//             '#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c'
//         ]
//     }
// };

// // For apply theme

// tui.chart.registerTheme('myTheme', theme);
// options.theme = 'myTheme';

// var pieChart = tui.chart.pieChart(container, data, options);

// $( window ).resize(function() {
//     pieChartWidth = $("#pie-charts").width();
//     pieChart.resize({
//         width: pieChartWidth,
//         height: 350
//     });
// });