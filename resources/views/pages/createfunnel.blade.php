@extends('layouts.panel.master')

@section('page-title', 'Add Upsell Funnel')

@section('custom-css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="page-title d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h4 class="fw-bold">Create Upsell Funnel</h4>
                    <a href="{{ route('upsellfunnels') }}" class="btn btn-primary btn-lg">View Funnel</a>
                </div>
            </div>
        </div>
        <div class="bg-white p-3 p-md-4 shadow-sm">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="page-title text-center pb-2 mb-3">
                        <h2 class="fw-bold">Create Funnel</h2>
                    </div>
                    <div class="upsell-form">
                        <form name="" action="{{ route('save.funnel') }}" method="post">
                            @csrf
                            
                            <div class="mb-3">
                                @error('name') <br><span class="text-danger text-small">{{ $message }}</span> @enderror
                            <input type="text" class="form-control py-lg-3 @error('name') is-invalid @enderror" placeholder="Name your funnel" name="name" value="{{old('name')}}" maxlength="100" required >
                            </div>
                            <div class="mb-3">
                                @error('tag') <span class="text-danger text-small">{{ $message }}</span> @enderror
                            <input type="text" class="form-control py-lg-3 @error('tag') is-invalid @enderror" placeholder="Tag: Shaving" name="tag" value="{{old('tag')}}" maxlength="100">
                            </div>
                            <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg py-lg-3">Create</button>
                            </div>
                        </form>
                    </div>
                </div>    
            </div>
        </div>

        

    </div>
@endsection

@section('custom-js')

@endsection
