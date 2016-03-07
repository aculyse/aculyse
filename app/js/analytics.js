$(function () {

    var a = $("#grades").data("grades");
    var b = $("#grades").data("level");
    var c;
    switch (b) {
        case 1:
            c = [["1", a[1]], ["2", a[2]], ["3", a[3]], ["4", a[4]], ["5", a[5]], ["6", a[6]], ["7", a[7]], ["8", a[8]], ["9", a[9]]];
            break;
        case 3:
            c = [["A", a.A], ["B", a.B], ["C", a.C], ["D", a.D], ["E", a.E], ["U", a.U]];
            break;
        case 4:
            c = [["A", a.A], ["B", a.B], ["C", a.C], ["D", a.D], ["E", a.E], ["O", a.O], ["F", a.F]];
            break;
        default:
            c = [["A", a.A], ["B", a.B], ["C", a.C], ["D", a.D], ["E", a.E], ["U", a.U]];
            break
    }
    console.log(c);
    $("#graph-box").highcharts({
        chart: {
            type: "pie",
            options2d: {
                enabled: true,
                alpha: 45,
                beta: 0,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true
            }
        },
        title: {text: ""},
        tooltip: {pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"},
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: "pointer",
                depth: 35,
                dataLabels: {enabled: true, format: "{point.name}"},
                showInLegend: true
            }
        },
        exporting: {enabled: false},
        series: [{type: "pie", name: "Students", data: c}]
    });
    $("#bar-graph-box").highcharts({
        chart: {type: "column"},
        title: {text: ""},
        subtitle: {text: ""},
        xAxis: {
            type: "category",
            labels: {style: {fontSize: "12px", fontFamily: "inherit", fontWeight: "bold"}},
            title: {text: "Grade"}
        },
        yAxis: {min: 0, title: {text: "Number of Students"}},
        legend: {enabled: false},
        tooltip: {pointFormat: "Students: <b>{point.y:.1f}</b>"},
        exporting: {enabled: false},
        series: [{
            name: "Number of students",
            data: c,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: "#FFFFFF",
                align: "right",
                x: 4,
                y: 10,
                style: {fontSize: "11px", fontFamily: "inherit", "font-weight": "bold !important"}
            }
        }]
    })
});
