(function(d) {
    d(".hit-rate").circleProgress({
        value: 0.62,
        size: 140,
        startAngle: -Math.PI / 2,
        thickness: 6,
        lineCap: "round",
        emptyFill: "#f0eff4",
        fill: {
            gradient: ["#e76c90", "#e76c90"]
        }
    }).on("circle-animation-progress", function(f, e) {
        d(this).find(".percent").html(Math.round(62 * e) + "<i>%</i>")
    });
    d(".happy-customers").circleProgress({
        value: 0.85,
        size: 140,
        startAngle: -Math.PI / 2,
        thickness: 6,
        lineCap: "round",
        emptyFill: "rgba(255, 255, 255, 0.15)",
        fill: {
            gradient: ["#fff", "#fff"]
        }
    }).on("circle-animation-progress", function(f, e) {
        d(this).find(".percent").html(Math.round(85 * e) + "<i>%</i>")
    });
    var c = function() {
        return (Math.random() > 0.5 ? 1 : 1) * Math.round(Math.random() * 100)
    };
    Chart.helpers.drawRoundedTopRectangle = function(h, g, j, i, f, e) {
        h.beginPath();
        h.moveTo(g + e, j);
        h.lineTo(g + i - e, j);
        h.quadraticCurveTo(g + i, j, g + i, j + e);
        h.lineTo(g + i, j + f);
        h.lineTo(g, j + f);
        h.lineTo(g, j + e);
        h.quadraticCurveTo(g, j, g + e, j);
        h.closePath()
    };
    Chart.elements.RoundedTopRectangle = Chart.elements.Rectangle.extend({
        draw: function() {
            var u = this._chart.ctx;
            var w = this._view;
            var j, x, r, n, g, f, t;
            var y = w.borderWidth;
            if (!w.horizontal) {
                j = w.x - w.width / 2;
                x = w.x + w.width / 2;
                r = w.y;
                n = w.base;
                g = 1;
                f = n > r ? 1 : -1;
                t = w.borderSkipped || "bottom"
            } else {
                j = w.base;
                x = w.x;
                r = w.y - w.height / 2;
                n = w.y + w.height / 2;
                g = x > j ? 1 : -1;
                f = 1;
                t = w.borderSkipped || "left"
            }
            if (y) {
                var v = Math.min(Math.abs(j - x), Math.abs(r - n));
                y = y > v ? v : y;
                var m = y / 2;
                var e = j + (t !== "left" ? m * g : 0);
                var i = x + (t !== "right" ? -m * g : 0);
                var s = r + (t !== "top" ? m * f : 0);
                var k = n + (t !== "bottom" ? -m * f : 0);
                if (e !== i) {
                    r = s;
                    n = k
                }
                if (s !== k) {
                    j = e;
                    x = i
                }
            }
            var q = Math.abs(j - x);
            var o = this._chart.config.options.barRoundness || 0.2;
            var h = q * o * 0.2;
            var p = r;
            r = p + h;
            var l = r - p;
            u.beginPath();
            u.fillStyle = w.backgroundColor;
            u.strokeStyle = w.borderColor;
            u.lineWidth = y;
            Chart.helpers.drawRoundedTopRectangle(u, j, (r - l + 1), q, n - p, l);
            u.fill();
            if (y) {
                u.stroke()
            }
            r = p
        },
    });
    Chart.defaults.roundedBar = Chart.helpers.clone(Chart.defaults.bar);
    Chart.controllers.roundedBar = Chart.controllers.bar.extend({
        dataElementType: Chart.elements.RoundedTopRectangle
    });
    
    var a = document.getElementById("orders").getContext("2d");
    var b = new Chart(a, {
        type: "roundedBar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Registered",
                data: [30, 24, 22, 17, 22, 24, 9, 14, 20, 13, 17, 13],
                borderColor: "#fff",
                backgroundColor: "#5d5386",
                hoverBackgroundColor: "#483d77"
            }, /*{
                label: "Estimated",
                data: [10, 14, 12, 20, 20, 8, 10, 20, 7, 11, 8, 10],
                borderColor: "#fff",
                backgroundColor: "#e4e8f0",
                hoverBackgroundColor: "#dde1e9"
            }*/]
        },
        options: {
            responsive: true,
            barRoundness: 1,
            tooltips: {
                backgroundColor: "rgba(47, 49, 66, 0.8)",
                titleFontSize: 13,
                titleFontColor: "#fff",
                caretSize: 0,
                cornerRadius: 4,
                xPadding: 5,
                displayColors: false,
                yPadding: 5,
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#2e3451",
                    usePointStyle: true,
                    padding: 50,
                    fontSize: 13
                }
            },
            scales: {
                xAxes: [{
                    barThickness: 30,
                    stacked: true,
                    gridLines: {
                        drawBorder: false,
                        display: false
                    },
                    ticks: {
                        display: true
                    }
                }],
                yAxes: [{
                    stacked: true,
                    gridLines: {
                        drawBorder: false,
                        display: false
                    },
                    ticks: {
                        display: false
                    }
                }]
            }
        }
    });

    var a = document.getElementById("area-chart-01").getContext("2d");
    var b = new Chart(a, {
        type: "line",
        data: {
            labels: ["Sep", "Oct", "Nov", "Dec", "Jan"],
            datasets: [{
                label: "Sales",
                borderColor: "#08a6c3",
                pointBackgroundColor: "#08a6c3",
                pointHoverBorderColor: "#08a6c3",
                pointHoverBackgroundColor: "#08a6c3",
                pointBorderColor: "#fff",
                pointBorderWidth: 3,
                pointRadius: 6,
                fill: true,
                backgroundColor: "#08a6c3",
                borderWidth: 3,
                data: [10, 60, 20, 40, 45]
            }]
        },
        options: {
            legend: {
                display: true,
                position: "top",
                labels: {
                    fontColor: "#2e3451",
                    usePointStyle: true,
                    fontSize: 13
                }
            },
            tooltips: {
                backgroundColor: "rgba(47, 49, 66, 0.8)",
                titleFontSize: 13,
                titleFontColor: "#fff",
                caretSize: 0,
                cornerRadius: 4,
                xPadding: 10,
                displayColors: false,
                yPadding: 10
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: true,
                        beginAtZero: true
                    },
                    gridLines: {
                        drawBorder: true,
                        display: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: true,
                        display: true
                    },
                    ticks: {
                        display: true
                    }
                }]
            }
        }
    });

     var a = document.getElementById("area-chart-02").getContext("2d");
    var b = new Chart(a, {
        type: "line",
        data: {
            labels: ["Sep", "Oct", "Nov", "Dec", "Jan"],
            datasets: [{
                label: "Students",
                borderColor: "#e76c90",
                pointBackgroundColor: "#e76c90",
                pointHoverBorderColor: "#e76c90",
                pointHoverBackgroundColor: "#e76c90",
                pointBorderColor: "#fff",
                pointBorderWidth: 3,
                pointRadius: 6,
                fill: true,
                backgroundColor: "rgba(231, 108, 144, 0.6)",
                borderWidth: 3,
                data: [20, 50, 10, 35, 30]
            }, /*{
                label: "Visitors",
                borderColor: "#5d5386",
                pointBackgroundColor: "#5d5386",
                pointHoverBorderColor: "#5d5386",
                pointHoverBackgroundColor: "#5d5386",
                pointBorderColor: "#fff",
                pointBorderWidth: 3,
                pointRadius: 6,
                fill: true,
                backgroundColor: "rgba(93, 83, 134, 0.6)",
                borderWidth: 3,
                data: [10, 60, 20, 40, 45]
            }*/]
        },
        options: {
            legend: {
                display: true,
                position: "top",
                labels: {
                    fontColor: "#2e3451",
                    usePointStyle: true,
                    fontSize: 13
                }
            },
            tooltips: {
                backgroundColor: "rgba(47, 49, 66, 0.8)",
                titleFontSize: 13,
                titleFontColor: "#fff",
                caretSize: 0,
                cornerRadius: 4,
                xPadding: 10,
                displayColors: false,
                yPadding: 10
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: true,
                        beginAtZero: true
                    },
                    gridLines: {
                        drawBorder: true,
                        display: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: true,
                        display: true
                    },
                    ticks: {
                        display: true
                    }
                }]
            }
        }
    });

    d(".circle-orders").circleProgress({
        value: 0.43,
        size: 120,
        startAngle: -Math.PI / 2,
        thickness: 6,
        lineCap: "round",
        emptyFill: "#e4e8f0",
        fill: {
            gradient: ["#0087a4", "#08a6c3"]
        }
    }).on("circle-animation-progress", function(f, e) {
        d(this).find(".percent-orders").html(Math.round(43 * e) + "<i>%</i>")
    });
   
})(jQuery);