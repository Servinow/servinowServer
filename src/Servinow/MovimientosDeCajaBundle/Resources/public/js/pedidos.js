(function($) {
    Raphael.fn.histogram = function(width, height, labels, values) {
        var paper = this,
            len = values.length,
            max = Math.max.apply(Math, values),
            division = (width - 10) / len;
        for (var i = 0, value; i < len; i++) {
            value = Math.round((values[i] * (height - 10)) / max);
            var bar = paper.rect(5 + (division * i), height - value - 5, division - 2, value).attr({
                stroke: 'none',
                fill: 'hsl(.6, .5, .5)'
            });
            paper.setStart();
            bar.tooltip = paper.set();
            var tooltip = {
                x: 5 + (division * i) + 7,
                y: height - value - 35
            };
            bar.tooltip.push(paper.text(tooltip.x, tooltip.y, labels[i][0]).attr({
                font: '12px Helvetica, Arial',
                fill: "#fff",
                "text-anchor": "start"
            }));
            bar.tooltip.push(paper.text(tooltip.x, tooltip.y + 16, labels[i][1]).attr({
                font: '10px Helvetica, Arial',
                fill: "hsl(.6, .8, .8)",
                "text-anchor": "start"
            }));
            var bb = bar.tooltip.getBBox();
            bar.tooltip.push(paper.rect(bb.x - 6, bb.y - 3, bb.width + 12, bb.height + 6, 1).attr({
                fill: "#000",
                stroke: "#666",
                "stroke-width": 2,
                "fill-opacity": .7
            }));
            bb = bar.tooltip.getBBox();
            var dx = 0,
                dy = 0;
            if (bb.x2 > width - 2) {
                dx = -(bb.x2 - width + 2);
            }
            if (bb.y < 2) {
                dy = -1 * bb.y + 4;
            }
            bar.tooltip.tShow="";
            if (dx != 0 || dy != 0) {
                bar.tooltip.tShow = "t"+dx+","+dy;
            }
            bar.tooltip.attr({
                opacity: 0
            });
            bar.tooltip.tHide = "T" + (width + 10) + "," + (height + 10);
            bar.tooltip.transform(bar.tooltip.tHide);
            paper.setFinish();
            bar.mouseover(function() {
                this.tooltip[2].toFront();
                this.tooltip[0].toFront();
                this.tooltip[1].toFront();
                this.tooltip.transform(this.tooltip.tShow);
                this.tooltip.stop().animate({
                    opacity: 1
                }, 200);
            }).mouseout(function() {
                this.tooltip.stop().attr({
                    opacity: 0
                });
                this.tooltip.transform(this.tooltip.tHide);
            });
        }
    };

    jQuery.fn.extend({
        createHistogram: function(width, height) {
            var values = [],
                labels = [];
            $table = $(this);
            var divChart = $table.attr("id") + "Chart";
            $table.after($("<div id=\"" + divChart + "\"></div>"));
            $table.children("tbody").children("tr").each(function() {
                var cells = $(this).children();
                labels.push([$(cells[1]).text(), $(cells[0]).text()]);
                values.push(parseInt($(cells[1]).text(), 10));
            });
            Raphael(divChart, width, height).histogram(width, height, labels, values);
            $table.hide();
        }
    });
    $("#pedidos").createHistogram(600, 400);
})($);