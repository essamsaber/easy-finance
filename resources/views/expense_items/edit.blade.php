@extends('layouts.main')
@section('title','Edit '.$expenseItem->name. ' item')
@section('content')
    <section class="content-header">
        <h1>
            Expense Items
            <small>view all</small>
        </h1>
        <ol class="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li><a href="{{route('expense-items.index')}}">Expense Items</a></li>
                <li class="active"><a href="#">Edit {{$expenseItem->name}} item</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('expense-items.update', $expenseItem)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="box">
                        <div class="box-header">
                            <div class="pull-left">
                                <a href="{{route('expense-items.index')}}" class="btn btn-info">
                                    <i class="fa fa-arrow-circle-left"></i>
                                    Back to expense items
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                <label for="name">Name:</label>
                                <input name="name" class="form-control" value="{{$expenseItem->name}}">
                                @if($errors->has('name'))
                                    <span class="help-block">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                                <label for="description">Description:</label>
                                <textarea name="description" id="" rows="6" class="form-control">{{$expenseItem->description}}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('period') ? 'has-error' : ''}}">
                                <label for="period">Period:</label>
                                <select name="period" id="" class="form-control">
                                   @foreach(config('finance.periods') as $period)
                                        <option {{$expenseItem->period == $period ? 'selected' : ''}} value="{{$period}}">{{ucfirst($period)}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('period'))
                                    <span class="help-block">{{$errors->first('period')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('requested_amount') ? 'has-error' : ''}}">
                                <label for="income">Requested Amount:</label>
                                <input name="requested_amount" class="form-control" id="requested_amount" value="{{$expenseItem->requested_amount}}">
                                @if($errors->has('requested_amount'))
                                    <span class="help-block">{{$errors->first('requested_amount')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('average') ? 'has-error' : ''}}">
                                <label for="average">Average:</label>
                                <input name="average" id="average" class="form-control" value="{{$expenseItem->average}}">
                                @if($errors->has('average'))
                                    <span class="help-block">{{$errors->first('average')}}</span>
                                @endif
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
        $(document).on('blur', '#income', function(){
            var income = $(this).val();
            if(income != '') {
                $('#average').val(income);
            }
        });
    </script>
@endsection
