@extends('layouts.main')
@section('title','Edit Income')
@section('content')
    <section class="content-header">
        <h1>
            Income
            <small>edit income</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="{{route('income.index')}}">Income</a></li>
            <li class="active"><a href="#">Edit {{$income->source->name}} Income</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('income.update', $income)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="box">
                        <div class="box-header">
                            <div class="pull-left">
                                <a href="{{route('income.index')}}" class="btn btn-info">
                                    <i class="fa fa-arrow-circle-left"></i>
                                    Back to income
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{$errors->has('source') ? 'has-error' : ''}}">
                                <label for="source">Source:</label>
                                <select name="source_id" id="source" class="form-control">
                                    <option value="">Please choose the income source</option>
                                    @foreach($sources as $source)
                                        <option {{$income->source->id == $source->id ? 'selected' : ''}} value="{{$source->id}}">{{$source->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('source'))
                                    <span class="help-block">{{$errors->first('source')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('notes') ? 'has-error' : ''}}">
                                <label for="notes">Notes:</label>
                                <textarea placeholder="(Optional)" name="notes" id="" rows="6" class="form-control">{{$income->notes}}</textarea>
                                @if($errors->has('notes'))
                                    <span class="help-block">{{$errors->first('notes')}}</span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('income') ? 'has-error' : ''}}">
                                <label for="income">Income:</label>
                                <input name="actual_income" class="form-control" id="income" value="{{$income->actual_income}}">
                                <input type="hidden" name="expected_income" class="form-control" id="expected-income" value="{{$income->actual_income}}">
                                @if($errors->has('income'))
                                    <span class="help-block">{{$errors->first('income')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('average') ? 'has-error' : ''}}">
                                <label for="income_date">Income Date:</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control" name="income_date" placeholder="Y-m-d"
                                           id="income_date" value="{{$income->income_date}}"/>
                                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-refresh"> Update</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function () {
            var currentTime = new Date();
            // First Date Of the month
            var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);
            // Last Date Of the Month
            var startDateTo = new Date(currentTime.getFullYear(),currentTime.getMonth() +1,0);
            $('#datetimepicker1').datetimepicker({
                showClear: true,
                format:'YYYY-MM-DD',
                minDate: startDateFrom,
                maxDate: startDateTo
            });

            $(document).on('change', '#source', function(){
                var source_id = $(this).val();
                var url = "{{request()->getBaseUrl()}}/sources/"+source_id;
                axios.get(url)
                    .then((response) => {
                        $("#income").val(response.data.income)
                        $("#expected-income").val(response.data.income)
                    }).catch((error) => {

                })
            });
        })
    </script>
@endsection
