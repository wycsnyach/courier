//Flot Bar Chart
$(function() {
    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.8
                    }, {
                        opacity: 0.8
                    }]
                }
            }
        },
        xaxis: {
            ticks: [[0,'0-30 days'],[1,'31-60 days'],[2,'61-90 days'],[3,'91-120 days'],[4,'121-150'],[5,'151-180']]
        },
        colors: ["#1ab394"],
        grid: {
            color: "#999999",
            hoverable: true,
            clickable: true,
            tickColor: "#D4D4D4",
            borderWidth:0
        },
        legend: {
            show: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar",
        data: [
            [0, 34],
            [1, 25],
            [2, 19],
            [3, 34],
            [4, 24],
            [5, 14]

        ]
    };
    $.plot($("#flot-bar-chart"), [barData], barOptions);

    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.8
                    }, {
                        opacity: 0.8
                    }]
                }
            }
        },
        xaxis: {
            ticks: [[0,'Registration/Filing'],[1,'Hearing- Main Suit'],[2,'Mention'],[3,'Judgment'],[4,'Hearing- Application'],[5,'Assessment of Costs/Taxation']]
        },
        colors: ["#1ab394"],
        grid: {
            color: "#999999",
            hoverable: true,
            clickable: true,
            tickColor: "#D4D4D4",
            borderWidth:0
        },
        legend: {
            show: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar",
        data: [
            [0, 34],
            [1, 25],
            [2, 19],
            [3, 34],
            [4, 24],
            [5, 14]

        ]
    };
    $.plot($("#flot-bar-chart1"), [barData], barOptions);
    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.8
                    }, {
                        opacity: 0.8
                    }]
                }
            }
        },
        xaxis: {
            ticks: [[0,'Governor'],[1,'Senate'],[2,'Womens Rep'],[3,'MP'],[4,'MCA'],[5,'Speaker Of County Assembly']]
        },
        colors: ["#1ab394"],
        grid: {
            color: "#999999",
            hoverable: true,
            clickable: true,
            tickColor: "#D4D4D4",
            borderWidth:0
        },
        legend: {
            show: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar",
        data: [
            [0, 34],
            [1, 25],
            [2, 19],
            [3, 34],
            [4, 24],
            [5, 14]

        ]
    }
    $.plot($("#flot-bar-chart2"), [barData], barOptions);

     var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.8
                    }, {
                        opacity: 0.8
                    }]
                }
            }
        },
        xaxis: {
            ticks: [[0,'Governor'],[1,'Senate'],[2,'Womens Rep'],[3,'MP'],[4,'MCA'],[5,'Speaker Of County Assembly']]
        },
        colors: ["#1ab394"],
        grid: {
            color: "#999999",
            hoverable: true,
            clickable: true,
            tickColor: "#D4D4D4",
            borderWidth:0
        },
        legend: {
            show: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar",
        data: [
            [0, 34],
            [1, 25],
            [2, 19],
            [3, 34],
            [4, 24],
            [5, 14]

        ]
    }
    $.plot($("#flot-bar-chart3"), [barData], barOptions);



});




