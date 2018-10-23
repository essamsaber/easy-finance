@if(session()->has('success'))
    <div class="text-center alert alert-success">
        <strong>{{session('success')}}</strong>
    </div>
@endif

@if(session()->has('failed'))
    <div class="text-center alert alert-danger">
        <strong>{{session('failed')}}</strong>
    </div>
@endif