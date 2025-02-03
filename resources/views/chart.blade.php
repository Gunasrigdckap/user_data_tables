<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart page</title>
    <link rel="stylesheet" href="{{ asset('css/header/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer/footer.css') }}">
    {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}
    {{-- <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses', 'Profit'],
                ['2014', 1000, 400, 200],
                ['2015', 1170, 460, 250],
                ['2016', 660, 1120, 300],
                ['2017', 1030, 540, 350]
            ]);

            var options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                },
                bars: 'horizontal' // Required for Material Bar Charts.
            };

            var chart = new google.charts.Bar(document.getElementById('barchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script> --}}
</head>

<body>
    <header class="row">
        @include('includes.header')
    </header>

    <h2 style="text-align: center">Students Marks Chart</h2>

    <div id="barchart_material" style="width: 900px; height: 500px;"></div>

    <footer>
        @include('includes.footer')
    </footer>
</body>
</html>
