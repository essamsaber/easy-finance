@extends('layouts.main')
@section('title','Payments')
@section('content')
    <section class="content-header">
        <h1>
            Payments
            <small>view payments</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><a href="#">Payments</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-left">
                            <a href="{{route('payment.create')}}" class="btn btn-info">
                                <i class="fa fa-plus"></i>
                                Add Payment
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="myTable" class="table table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Expected Payment</th>
                                <th>Actual Payment</th>
                                <th>Notes</th>
                                <th>Payment Date</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$payment->item->name}}</td>
                                    <td>{{$payment->expected_expense}}</td>
                                    <td>{{$payment->actual_expense}}</td>
                                    <td width="300">{{$payment->notes}}</td>
                                    <td>{{$payment->date}}</td>
                                    <td>
                                        <a href="{{route('payment.edit', $payment)}}" class="btn btn-primary btn xs"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-payment-id="{{$payment->id}}" class="delete-payment btn btn-danger btn xs"><i class="fa fa-times"></i></a>
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
                            {{--{{$payments->links()}}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{asset('plugins/dataTables/js/jquery.dataTables.min.js')}}"></script>

    <script>
        $(function(){
            // Initializing Datatable
            $('#myTable').DataTable(); // End

            // Delete payment event
            $(document).on('click', '.delete-payment', function(e){
                e.preventDefault();
                var payment_id = $(this).data('payment-id');
                $.confirm({
                    text: "Are you sure you want to delete that record?",
                    title: "Confirmation required",
                    confirm: function(button) {
                        var url = "{{request()->getBaseUrl()}}/payment/"+payment_id
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
            // End delete payment event
        })
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/dataTables/css/jquery.dataTables.min.css')}}">
@endsection