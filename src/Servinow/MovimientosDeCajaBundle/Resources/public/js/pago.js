(function($) {
    Raphael.fn.pieChart = function(cx, cy, r, values, labels, stroke) {
        var paper = this,
            /*Constante para convertir en radianes*/
            rad = Math.PI / 180,
            chart = this.set();

        function sector(cx, cy, r, startAngle, endAngle, params) { /*Cojido de la documentacion*/
            var x1 = cx + r * Math.cos(-startAngle * rad),
                x2 = cx + r * Math.cos(-endAngle * rad),
                y1 = cy + r * Math.sin(-startAngle * rad),
                y2 = cy + r * Math.sin(-endAngle * rad);
            return paper.path(["M", cx, cy, "L", x1, y1, "A", r, r, 0, +(endAngle - startAngle > 180), 0, x2, y2, "z"]).attr(params);
        }
        var angle = 90,
            total = 0,
            hue = 0,
            draw = function(j) {
                var value = values[j],
                    diffAngle = 360 * value / total,
                    color = Raphael.hsb(hue, .66, .66),
                    dropcolor = Raphael.hsb(hue, 1, 1),
                    p, mark, txt;
                if (j == 0) {
                    angle -= diffAngle / 2
                }
                p = sector(cx, cy, r, angle, angle + diffAngle, {
                    fill: "90-" + dropcolor + "-" + color,
                    stroke: stroke,
                    "stroke-width": 1
                }), mark = paper.circle(20, 50 + (20 * j), 5).attr({
                    fill: color,
                    stroke: "none"
                }), txt = paper.text(30, 50 + (20 * j), (value / total * 100).toFixed(2) + "% - " + labels[j]).attr({
                    fill: color,
                    stroke: "none",
                    "font-size": 18,
                    "text-anchor": "start"
                });
                p.mouseover(function() {
                    p.stop().animate({
                        transform: "s1.05 1.05 " + cx + " " + cy
                    }, 500, "elastic");
                    mark.stop().animate({
                        r: 7.5
                    }, 500, "elastic");
                    txt.attr({
                        "font-weight": "bolder"
                    });
                }).mouseout(function() {
                    p.stop().animate({
                        transform: ""
                    }, 500, "elastic");
                    mark.stop().animate({
                        r: 5
                    }, 500);
                    txt.attr({
                        "font-weight": "normal"
                    });
                });
                angle += diffAngle;
                chart.push(p);
                chart.push(mark);
                chart.push(txt);
                hue += .1;
            };
        for (var i = 0, lengthValues = values.length; i < lengthValues; i++) {
            total += values[i];
        }
        for (i = 0; i < lengthValues; i++) {
            draw(i);
        }
        return chart;
    };
    $.extend({
        createPieChart: function(table, width, height, x, y, c, stroke) {
            var values = [],
                labels = [];
            $table = $(table);
            var divChart = $table.attr("id") + "Chart";
            $table.after($("<div id=" + divChart + "></div>"));
            $table.children("tbody").children("tr").each(function() {
                var children = $(this).children();
                labels.push($(children[0]).text());
                values.push(parseInt($(children[1]).text(), 10));
            });
            Raphael(divChart, width, height).pieChart(x, y, c, values, labels, stroke);
        }
    });
    $.createPieChart($("#tablePago"), 650, 340, 480, 170, 150, '#fff');
})($);

$('#datepicker_fecha_inicio').change(function() {
    $('#datepicker_fecha_inicio').attr('value') = 2012;
});

$('#datepicker_fecha_fin').change(function() {
});