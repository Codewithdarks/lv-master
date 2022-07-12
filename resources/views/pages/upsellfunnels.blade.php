@extends('layouts.panel.master')

@section('page-title', 'Upsell Funnels')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Upsell Funnel</h4>
                    <a href="{{ route('create.funnel') }}" class="btn btn-primary btn-lg">Create Funnel</a>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 p-md-4 p-lg-5 shadow-sm">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                @if($tabledata=='empty')
                <div class="no-result">
                    <img src="{{ asset('images/no-result.png') }}" width="100" >
                    <h5>There is no upsell funnel yet.</h5>
                    <p><a class="fst-italic" href="{{ route('create.funnel') }}">Click here</a> to create your First Upsell.</p>
                  </div>
                @else
                <div class="table-list">
                    <table class="table table-bordered align-middle" id="TargetTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Tag</th>
                                <th>Status</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                @endif
                    
                    <!-- end table-list -->
                    <!-- end table-navigation -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">var URL = "{{ route('upsellfunnels') }}";</script>
    <script type="text/javascript" src="{{ asset('js/upsellfunnels.js') }}"></script>
@endsection
