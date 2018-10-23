@extends('layouts.main')
@section('title','Edit '.$source->name. ' source')
@section('content')
    <section class="content-header">
        <h1>
            Sources
            <small>view all</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="{{route('sources.index')}}">Sources of Income</a></li>
            <li class="active"><a href="#">Edit {{$source->name}} source</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('sources.update', $source)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="box">
                        <div class="box-header">
                            <div class="pull-left">
                                <a href="{{route('sources.index')}}" class="btn btn-info">
                                    <i class="fa fa-arrow-circle-left"></i>
                                    Back to sources
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                <label for="name">Name:</label>
                                <input name="name" class="form-control" value="{{$source->name}}">
                                @if($errors->has('name'))
                                    <span class="help-block">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                                <label for="description">Description:</label>
                                <textarea name="description" id="" rows="6" class="form-control">{{$source->description}}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{$errors->first('description')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('period') ? 'has-error' : ''}}">
                                <label for="period">Period:</label>
                                <select name="period" id="" class="form-control">
                                   @foreach(config('finance.periods') as $period)
                                        <option {{$source->period == $period ? 'selected' : ''}} value="{{$period}}">{{ucfirst($period)}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('period'))
                                    <span class="help-block">{{$errors->first('period')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('income') ? 'has-error' : ''}}">
                                <label for="income">Income:</label>
                                <input name="income" class="form-control" id="income" value="{{$source->income}}">
                                @if($errors->has('income'))
                                    <span class="help-block">{{$errors->first('income')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('average') ? 'has-error' : ''}}">
                                <label for="average">Average:</label>
                                <input name="average" id="average" class="form-control" value="{{$source->average}}">
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
