@extends('layouts.panel.master')

@section('page-title', 'Add Upsell Funnel')

@section('custom-css')

@endsection

@section('content')
    <div class="container position-absolute top-50 start-50 translate-middle w-50  ">
        <form class="form shadow-sm p-3 mb-5 bg-body rounded p-lg-5" action="{{ route('builder.update.page', \Illuminate\Support\Facades\Crypt::encrypt($page['id'])) }}" method="POST"> @csrf
            <h3 class="text text-center f">Page Form</h3>
            <div class="form-floating mb-3">
                <input type="text" name="page_name" value="{{ $page['name']  }}" class="form-control" id="floatingInput" placeholder="Page Name">
                <label for="floatingInput">Page Name</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" name="funnel_id" >
                    <option value="">Select Funnels</option>
                    @forelse($funnels as $name)
                        <option value="{{ $name->id }}" @if($page->funnel_id == $name->id) selected @else @endif>{{ $name->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection


