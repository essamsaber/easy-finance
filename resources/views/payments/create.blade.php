
@extends('layouts.main')
@section('title','Payment Process')
@section('content')
    <section class="content-header">
        <h1>
            Income
            <small>payment process</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="{{route('payment.index')}}">Payments</a></li>
            <li class="active"><a href="#">Payment process</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('payment.store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="box">
                        <div class="box-header">
                            <div class="pull-left">
                                <a href="{{route('payment.index')}}" class="btn btn-info">
                                    <i class="fa fa-arrow-circle-left"></i>
                                    Back to payments
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{$errors->has('expense_item_id') ? 'has-error' : ''}}">
                                <label for="source_id">Expense Item:</label>
                                <select name="expense_item_id" id="expense_item_id" class="form-control">
                                    <option value="">Please choose the expense item</option>
                                    @foreach($items as $item)
                                        <option {{old('expense_item_id') == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('expense_item_id'))
                                    <span class="help-block">{{$errors->first('expense_item_id')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('notes') ? 'has-error' : ''}}">
                                <label for="notes">Notes:</label>
                                <textarea placeholder="(Optional)" name="notes" id="" rows="6" class="form-control">{{old('notes')}}</textarea>
                                @if($errors->has('notes'))
                                    <span class="help-block">{{$errors->first('notes')}}</span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('actual_expense') ? 'has-error' : ''}}">
                                <label for="income">Amount:</label>
                                <input name="actual_expense" class="form-control" id="expense" value="{{old('actual_expense')}}">
                                <input type="hidden" name="expected_expense" class="form-control" id="expected_expense" value="{{old('expected_expense')}}">
                                @if($errors->has('actual_expense'))
                                    <span class="help-block">{{$errors->first('actual_expense')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('expense_date') ? 'has-error' : ''}}">
                                <label for="expense_date">Payment Date:</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control" name="expense_date" placeholder="Y-m-d"
                                           id="expense_date"/>
                                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                </div>
                                @if($errors->has('expense_date'))
                                    <span class="help-block">{{$errors->first('expense_date')}}</span>
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

            $(document).on('change', '#expense_item_id', function(){
                var item_id = $(this).val();
                var url = "{{request()->getBaseUrl()}}/expense-items/"+item_id;
                axios.get(url)
                    .then((response) => {
                        $("#expense").val(response.data.requested_amount)
                        $("#expected_expense").val(response.data.requested_amount)
                    }).catch((error) => {

                })
            });
        })
    </script>
@endsection
