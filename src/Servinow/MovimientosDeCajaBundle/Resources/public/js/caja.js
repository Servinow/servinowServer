/**
 * @author KoxAlen
 */
    if ( typeof (jQuery) == 'undefined' || typeof (Raphael) == 'undefined') {
        alert("jQuery and Raphael libs required");
        return;
    }
    Raphael.fn.pieChart = function(cx, cy, r, values, labels, stroke) {
        var paper = this,
        /* constant to transform from degrees to radians */
        rad = Math.PI / 180, chart = this.set();

        function sector(cx, cy, r, startAngle, endAngle, params) {/* Taken from Raphael website */
            var x1 = cx + r * Math.cos(-startAngle * rad), x2 = cx + r * Math.cos(-endAngle * rad), y1 = cy + r * Math.sin(-startAngle * rad), y2 = cy + r * Math.sin(-endAngle * rad);
            return paper.path(["M", cx, cy, "L", x1, y1, "A", r, r, 0, +(endAngle - startAngle > 180), 0, x2, y2, "z"]).attr(params);
        }

        var angle = 90, total = 0, hue = 0, draw = function(j) {
            var value = values[j], diffAngle = 360 * value / total, color = Raphael.hsb(hue, .66, .66), dropcolor = Raphael.hsb(hue, 1, 1), p, mark, txt;

            if (j == 0) {
                angle -= diffAngle / 2
            }
            p = sector(cx, cy, r, angle, angle + diffAngle, {
                fill : "90-" + dropcolor + "-" + color,
                stroke : stroke,
                "stroke-width" : 1
            });
            mark = paper.circle(20, 50 + (20 * j), 5).attr({
                fill : color,
                stroke : "none"
            });
            txt = paper.text(30, 50 + (20 * j), (value / total * 100).toFixed(2) + "% - " + labels[j]).attr({
                fill : color,
                stroke : "none",
                "font-size" : 18,
                "text-anchor" : "start"
            });
            p.mouseover(function() {
                p.stop().animate({
                    transform : "s1.05 1.05 " + cx + " " + cy
                }, 500, "elastic");
                mark.stop().animate({
                    r : 7.5
                }, 500, "elastic");
                txt.attr({
                    "font-weight" : "bolder"
                });
            }).mouseout(function() {
                p.stop().animate({
                    transform : ""
                }, 500, "elastic");
                mark.stop().animate({
                    r : 5
                }, 500);
                txt.attr({
                    "font-weight" : "normal"
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
        for ( i = 0; i < lengthValues; i++) {
            draw(i);
        }
        return chart;
    };
    Raphael.fn.histogram = function(width, height, labels, values) {
        var paper = this, len = values.length, max = Math.max.apply(Math, values), division = (width - 10) / len;

        for (var i = 0, value; i < len; i++) {
            value = Math.round((values[i] * (height - 10)) / max);
            if(value < 2) value = 2;
            
            var bar = paper.rect(5 + (division * i), height - value - 5, division - 2, value).attr({
                stroke : 'none',
                fill : 'hsl(.6, .5, .5)'
            });
            paper.setStart();
            bar.tooltip = paper.set();
            var tooltip = {
                x : 5 + (division * i) + 7,
                y : height - value - 35
            };
            bar.tooltip.push(paper.text(tooltip.x, tooltip.y, labels[i][0]).attr({
                font : '12px Helvetica, Arial',
                fill : "#fff",
                "text-anchor" : "start"
            }));
            bar.tooltip.push(paper.text(tooltip.x, tooltip.y + 16, labels[i][1]).attr({
                font : '10px Helvetica, Arial',
                fill : "hsl(.6, .8, .8)",
                "text-anchor" : "start"
            }));
            var bb = bar.tooltip.getBBox();
            bar.tooltip.push(paper.rect(bb.x - 6, bb.y - 3, bb.width + 12, bb.height + 6, 1).attr({
                fill : "#000",
                stroke : "#666",
                "stroke-width" : 2,
                "fill-opacity" : .7
            }));
            bb = bar.tooltip.getBBox();
            var dx = 0, dy = 0;
            if (bb.x2 > width - 2) {
                dx = -(bb.x2 - width + 2);
            }
            if (bb.y < 2) {
                dy = -1 * bb.y + 4;
            }
            bar.tooltip.tShow = "";
            if (dx != 0 || dy != 0) {
                bar.tooltip.tShow = "t" + dx + "," + dy;
            }
            bar.tooltip.attr({
                opacity : 0
            });
            bar.tooltip.tHide = "T" + (width + 10) + "," + (height + 10);
            bar.tooltip.transform(bar.tooltip.tHide);
            paper.setFinish();
            bar.mouseover(function() {
                /* Order matters */
                this.tooltip[2].toFront();
                this.tooltip[0].toFront();
                this.tooltip[1].toFront();
                /* Move it to the correct place */
                this.tooltip.transform(this.tooltip.tShow);
                /* and show it */
                this.tooltip.stop().animate({
                    opacity : 1
                }, 200);
            }).mouseout(function() {
                /* Hide it */
                this.tooltip.stop().attr({
                    opacity : 0
                });
                /* and move it outside*/
                this.tooltip.transform(this.tooltip.tHide);
            });
        }
    };
    jQuery.fn.extend({
        createHistogram : function(width, height) {
            var values = [], labels = [];
            $table = $(this);
            $table.hide();
            var divChart = $table.attr("id") + "Chart";
            $table.after($("<div id=\"" + divChart + "\"></div>"));
            $table.children("tbody").children("tr").each(function() {
                var cells = $(this).children();
                labels.push([$(cells[1]).text(), $(cells[0]).text()]);
                values.push(parseInt($(cells[1]).text(), 10));
            });
            Raphael(divChart, width, height).histogram(width, height, labels, values);
        },
        createPieChart : function(width, height, x, y, c, stroke) {
            var values = [], labels = [];
            $table = $(this);
            $table.hide();
            var divChart = $table.attr("id") + "Chart";
            $table.after($("<div id=" + divChart + "></div>"));
            $table.children("tbody").children("tr").each(function() {
                var cells = $(this).children();
                labels.push($(cells[0]).text());
                values.push(parseInt($(cells[1]).text(), 10));
            });
            Raphael(divChart, width, height).pieChart(x, y, c, values, labels, stroke);
        }
    });
