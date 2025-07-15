// Chart Area Demo
(function($) {
    "use strict";

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    if (ctx) {
        var myLineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(230, 0, 18, 0.2)",
                    borderColor: "rgba(230, 0, 18, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(230, 0, 18, 1)",
                    pointBorderColor: "rgba(255, 255, 255, 0.8)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(230, 0, 18, 1)",
                    pointHoverBorderColor: "rgba(255, 255, 255, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "date"
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7,
                            fontColor: "#ffffff"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            fontColor: "#ffffff",
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return "$" + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgba(255, 255, 255, 0.1)",
                            zeroLineColor: "rgba(255, 255, 255, 0.1)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    titleFontColor: "#ffffff",
                    bodyFontColor: "#ffffff",
                    titleFontSize: 14,
                    bodyFontSize: 14,
                    displayColors: false,
                    intersect: false,
                    mode: "index",
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + ": $" + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    }

    // Function to format numbers
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + "").replace(",", "").replace(" ", "");
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === "undefined") ? "," : thousands_sep,
            dec = (typeof dec_point === "undefined") ? "." : dec_point,
            s = "",
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return "" + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
        if ((sep.length > 0)) {
            var i = s[0].length;
            if (i % 3 !== 0) {
                i = 0;
            }
            for (; i < s[0].length; i += 3) {
                if (i !== 0) {
                    s[0] = s[0].substr(0, i) + sep + s[0].substr(i);
                }
            }
        }
        if ((s[1] || "").length < prec) {
            s[1] = s[1] || "";
            s[1] += new Array(prec - s[1].length + 1).join("0");
        }
        return s.join(dec);
    }

})(jQuery); 