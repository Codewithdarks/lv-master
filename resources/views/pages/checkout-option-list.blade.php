@extends('layouts.panel.master')

@section('page-title', 'Option Lists')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Checkout Options</h4>
                    <a href="{{ route('checkout.new') }}" class="btn btn-primary btn-lg">Create New</a>
                </div>
            </div>
        </div>
        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="table-list">
                        <table class="table table-bordered align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>For</th>
                                <th>Title</th>
                                <th>Value</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($display as $key=>$value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ($value['option_for'] == 'checkout_page_why') ? 'Why Choose Us' : 'Review' }}</td>
                                    <td>{{ $value['option_name'] }}</td>
                                    <td>{{ $value['option_value'] }}</td>
                                    <td><a href="{{ route('checkout.edit', $value->id)}}" class="btn btn-secondary">Edit</a></td>
                                    <td><button id="delkey{{ $key }}" class="btn btn-danger">Delete</button>
                                        <form action="{{ route('checkout.delete', $value->id) }}" method="POST" id="delNum{{$key}}">@csrf</form>
                                        <script type="text/javascript">
                                            document.getElementById('delkey{{ $key }}').addEventListener('click',function (){
                                                document.getElementById('delNum{{$key}}').submit();
                                            });
                                        </script>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No records available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- end table-list -->
                    <!-- end table-navigation -->
                </div>
            </div>
        </div>
    </div>
@endsection
