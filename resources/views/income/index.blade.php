@extends('layouts.main')
@section('title','Income')
@section('content')
    <section class="content-header">
        <h1>
            Income
            <small>view income</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><a href="#">Income</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-left">
                            <a href="{{route('income.create')}}" class="btn btn-info">
                                <i class="fa fa-plus"></i>
                                Add income
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="myTable" class="table table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Source</th>
                                <th>Expected Income</th>
                                <th>Actual Income</th>
                                <th>Notes</th>
                                <th>Income Date</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($income as $in)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$in->source->name}}</td>
                                    <td>{{$in->expected_income}}</td>
                                    <td>{{$in->actual_income}}</td>
                                    <td width="300">{{$in->notes}}</td>
                                    <td>{{$in->date}}</td>
                                    <td>
                                        <a href="{{route('income.edit', $in)}}" class="btn btn-primary btn xs"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-source-id="{{$in->id}}" class="delete-source btn btn-danger btn xs"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No data exists in our record</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="text-center">
                            {{$income->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
