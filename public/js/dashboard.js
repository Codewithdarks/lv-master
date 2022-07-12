$(document).ready(function () {
    var mode = $('#ChartRefresh').val();
    var URL = urlPrefix+'/'+mode;
    $.ajax({
        type: "GET",
        url: URL,
        success: function (data) {
            RenderChartDetail(data.orders.reverse(), data.intervals.reverse());
            $('#NetSalesVal').empty();
            $('#NetSalesVal').append('$'+data.net_sales);
            $('#OrdersCount').empty();
            $('#OrdersCount').append(data.count);
            $('#AverageCalc').empty();
            $('#AverageCalc').append('$'+data.average);
        }, error: function (xhr, status, error) {
            console.log(xhr);
        }
    });
});

function RenderChartDetail(orders, intervals) {
    var options = {
        series: [
            {
                name: "Orders",
                data: orders
            }
        ],
        chart: {
            height: 350,
            type: 'line',
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
            },
            toolbar: {
                show: false
            }
        },
        colors: ['#77B6EA', '#545454'],
        dataLabels: {
            enabled: true,
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Trends of Order During this period',
            align: 'left'
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: intervals,
            title: {
                text: 'Period of Time'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Orders'
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };
    var chart = new ApexCharts(document.querySelector("#chartBox"), options);
    chart.render();
}

$(document).on('change', '#ChartRefresh', function () {
    var mode = $(this).val();
    var URL = urlPrefix+'/'+mode;
    $.ajax({
        type: "GET",
        url: URL,
        success: function (data) {
            $('#chartBox').empty();
            RenderChartDetail(data.orders.reverse(), data.intervals.reverse());
            $('#NetSalesVal').empty();
            $('#NetSalesVal').append('$'+data.net_sales);
            $('#OrdersCount').empty();
            $('#OrdersCount').append(data.count);
            $('#AverageCalc').empty();
            $('#AverageCalc').append('$'+data.average);
        }, error: function (xhr, status, error) {
            console.log(xhr);
        }
    });
});
