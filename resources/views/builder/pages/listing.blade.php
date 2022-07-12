@extends('layouts.panel.master')

@section('page-title', 'Builder Pages')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Builder Pages</h4>
                    <a href="{{ route('builder.create.page') }}" class="btn btn-primary btn-lg">Create New Page</a>
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
                                    <th>Name</th>
                                    <th>Funnel</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    <!-- end table-list -->
                    <!-- end table-navigation -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">var URL = "{{ route('builder.listing') }}";</script>
    <script type="text/javascript" src="{{ asset('js/builder-list.js') }}"></script>
@endsection
