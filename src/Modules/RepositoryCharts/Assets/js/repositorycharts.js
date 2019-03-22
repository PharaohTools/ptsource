
function chartcommitsbydate() {
    $('#chart-commits-by-date').highcharts({
        chart: {
            type: 'areaspline',
            zoomType: 'x'
        },
        title: {
            text: ''
        },
        plotOptions: {
            series: {
                lineWidth: 1,
                marker: {
                    enabled: false
                }
            }
        },
        xAxis: {
            categories: chart_data.date.x,
            tickInterval: parseInt(chart_data.date.x.length / 20),
            labels: {
                rotation: -45,
                y: 35
            }
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        series: [
            {
                name: 'Commits',
                data: chart_data.date.y
            }
        ]
    });
}
chartcommitsbydate() ;

function gpsCommitsByDayChart() {
    $("#chart-commits-by-day").highcharts({
        chart: {
            type: "pie"
        },
        title: {
            text: ""
        },
        yAxis: {
            title: {
                text: ""
            }
        },
        series: [
            {
                name: "Commits",
                data: chart_data.day
            }
        ]
    });
}
gpsCommitsByDayChart() ;

function gpsCommitsByHourChart() {
    $("#chart-commits-by-hour").highcharts({
        chart: {
            type: "bar"
        },
        title: {
            text: ""
        },
        xAxis: {
            categories: chart_data.hour.x
        },
        yAxis: {
            title: {
                text: ""
            }
        },
        series: [
            {
                name: "Commits",
                data: chart_data.hour.y
            }
        ]
    });
}
gpsCommitsByHourChart() ;

function gpsContributor($timeout) {
    return {
        restrict: 'E',
        replace: true,
        templateUrl: 'contributor.html',
        scope: {
            contributor: '='
        },

        link: function(scope, iElement) {
            $timeout(function() {
                $(iElement).find('.chart').highcharts({
                    chart: {
                        type: "areaspline",
                        zoomType: "x"
                    },
                    title: {
                        text: ""
                    },
                    plotOptions: {
                        series: {
                            lineWidth: 1,
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    xAxis: {
                        categories: scope.contributor.data.x,
                        tickInterval: parseInt(scope.contributor.data.x.length / 10),
                        labels: {
                            rotation: -45,
                            y: 35
                        }
                    },
                    yAxis: {
                        title: {
                            text: ""
                        }
                    },
                    series: [
                        {
                            name: "Commits",
                            data: scope.contributor.data.y
                        }
                    ]
                });
            }, 50);
        }
    };
}