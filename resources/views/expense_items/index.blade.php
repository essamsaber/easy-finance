@extends('layouts.main')
@section('title','Expense Items')
@section('content')
    <section class="content-header">
        <h1>
            Expense Items
            <small>view all</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><a href="#">Expense Items</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-left">
                            <a href="{{route('expense-items.create')}}" class="btn btn-info">
                                <i class="fa fa-plus"></i>
                                Add new expense item
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Income</th>
                                <th>Average</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->name}}</td>
                                    <td width="300">{{$item->description}}</td>
                                    <td>{{$item->period}}</td>
                                    <td>{{$item->requested_amount}}</td>
                                    <td>{{$item->average}}</td>
                                    <td>
                                        <a href="{{route('expense-items.edit', $item)}}" class="btn btn-primary btn xs"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-item-id="{{$item->id}}" class="delete-source btn btn-danger btn xs"><i class="fa fa-times"></i></a>
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
                            {{$items->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script>
    $(function(){
        $(document).on('click', '.delete-source', function(e){
            e.preventDefault();
            var item_id = $(this).data('item-id');
            $.confirm({
                text: "Are you sure you want to delete that record?",
                title: "Confirmation required",
                confirm: function(button) {
                    var url = "{{request()->getBaseUrl()}}/expense-items/"+item_id
                    axios.delete(url)
                    .then((response) => {
                        location.reload();
                    }).catch((error) => {

                    })
                },
                cancel: function(button) {

                },
                confirmButton: "Yes I am",
                cancelButton: "No",
                post: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-default",
                dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
            });
        })

    })
</script>
@endsection