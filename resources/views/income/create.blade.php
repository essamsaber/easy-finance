@extends('layouts.main')
@section('title','Add Income')
@section('content')
    <section class="content-header">
        <h1>
            Income
            <small>add income</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="{{route('income.index')}}">Income</a></li>
            <li class="active"><a href="#">Add Income</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('income.store')}}" method="POST">
                    {{csrf_field()}}
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
                            <div class="form-group {{$errors->has('source_id') ? 'has-error' : ''}}">
                                <label for="source_id">Source:</label>
                                <select name="source_id" id="source" class="form-control">
                                    <option value="">Please choose the income source</option>
                                    @foreach($sources as $source)
                                        <option {{old('source_id') == $source->id ? 'selected' : ''}} value="{{$source->id}}">{{$source->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('source_id'))
                                    <span class="help-block">{{$errors->first('source_id')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('notes') ? 'has-error' : ''}}">
                                <label for="notes">Notes:</label>
                                <textarea placeholder="(Optional)" name="notes" id="" rows="6" class="form-control">{{old('notes')}}</textarea>
                                @if($errors->has('notes'))
                                    <span class="help-block">{{$errors->first('notes')}}</span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('actual_income') ? 'has-error' : ''}}">
                                <label for="income">Income:</label>
                                <input name="actual_income" class="form-control" id="income" value="{{old('actual_income')}}">
                                <input type="hidden" name="expected_income" class="form-control" id="expected-income" value="{{old('expected_income')}}">
                                @if($errors->has('actual_income'))
                                    <span class="help-block">{{$errors->first('actual_income')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('income_date') ? 'has-error' : ''}}">
                                <label for="income_date">Income Date:</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control" name="income_date" placeholder="Y-m-d"
                                           id="income_date"/>
                                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                                @if($errors->has('income_date'))
                                    <span class="help-block">{{$errors->first('income_date')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"> Save</i>
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
