@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-content">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-content">
                        <canvas id="current-balance"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{asset('plugins/charts/Chart.bundle.js')}}"></script>
    <script>

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo html_entity_decode(json_encode($month_labels), ENT_QUOTES, 'UTF-8'); ?>,
                datasets: [
                    {
                        label: 'Actual monthly income for the current year '+(new Date()).getFullYear(),
                        data: <?php echo html_entity_decode(json_encode($monthly_income), ENT_QUOTES, 'UTF-8'); ?>,
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                    },
                    {
                        label: 'Actual monthly payments for the current year '+(new Date()).getFullYear(),
                        data: <?php echo html_entity_decode(json_encode($monthly_expense), ENT_QUOTES, 'UTF-8'); ?>,
                        backgroundColor: 'rgba(220, 220, 220, 0.5)',
                        pointBorderColor: "#fff",
                    }

                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var doughnutData = {
            labels: ["Balance","Expected Income for Current Month","Expected Expense for Current Month" ],
            datasets: [{
                data: [{{$balance}},{{$expected_income}},{{$expected_expense}}],
                backgroundColor: ["#a3e1d4","#dedede","#b5b8cf"]
            }]
        } ;


        var doughnutOptions = {
            responsive: true
        };


        var ctx4 = document.getElementById("current-balance").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

    </script>
@endsection