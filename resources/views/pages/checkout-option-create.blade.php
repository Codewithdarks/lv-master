@extends('layouts.app')
@section('content')
    <div class="container">
    <form action="{{ route('checkout.option') }}" method="POST"> @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Option Name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="option_name" aria-describedby="emailHelp" placeholder="Enter Option name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Option For</label>
            <input type="text" class="form-control" id="exampleInput" name="option_for" placeholder="Option for">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Option value</label>
            <input type="text" class="form-control" id="exampleInput" name="option_value" placeholder="Option value">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
@endsection
