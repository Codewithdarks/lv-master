@extends('layouts.app')
@section('title','Reset Password')
<style>
.bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: 10px;

}

</style>
@section('content')
<main class="form-signin text-center">
@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  <form method="POST" action="{{ route('password.update') }}">
  @csrf

                        
    <img class="mb-4" src="/images/logo.png" alt="" width="200">
    <h1 class="h3 mb-3 fw-normal">Rest Password</h1>
	
    
    <div class="form-floating">
      <input id="floatingEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
      <label for="floatingEmail">Email address</label>
	  
    </div>
	@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
    
    <button class="w-100 btn btn-lg btn-primary" type="submit">{{ __('Send Password Reset Link') }}</button>
   
                                    <a class="btn btn-link" href="{{ route('login') }}">
                                        {{ __('Sign In') }}
                                    </a>

  </form>
</main>
@endsection