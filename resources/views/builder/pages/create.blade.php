@extends('layouts.panel.master')

@section('page-title', 'Create Page')

@section('content')
    <div class="container">
        <main>
            <form action="{{ route('builder.store.page') }}" method="POST">@csrf
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                                <h4 class="fw-bold">Create pages</h4>
                                <a href="{{ route('builder.listing') }}" class="btn btn-primary btn-lg">Back to pages</a>
                            </div>
                        </div>
                    </div>
                    <div class="grey-bg px-4 py-4 mb-4 shadow-sm m-5">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <input type="text" name="page_name" class="form-control" placeholder="Enter page Name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end align-items-center">
                                    <select class="form-select text-secondary " name="funnel_id">
                                        <option value="">Select Funnels</option>
                                        @forelse($funnels as $funnel)
                                            <option value="{{ $funnel->id }}">{{ $funnel->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end align-items-center">
                                    <input type="submit" value="submit" class="btn btn-primary btn-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">var URL = "{{ route('upsellfunnels') }}";</script>
    <script type="text/javascript" src="{{ asset('js/upsellfunnels.js') }}"></script>
@endsection
