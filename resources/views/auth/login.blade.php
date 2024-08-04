@extends('layouts.app')

{{-- @push('css') --}}
<style>
    body {
        /* background-image: linear-gradient(120deg, #619dff 0%, #c2e9fb 100%); */
        /* background-image: linear-gradient(to top, #941A3C 0%, #EA493A 100%); */
        background-image: linear-gradient(to top, #EA493A 0%, #941A3C 100%);
        
    }

    .width-100 {
        width: 100px;
    }
</style>
{{-- @endpush --}}
@section('content')
<div class="container m-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}
            <div class="card-body shadow">
                <div class="text-center mb-3">
                    <img src="{{asset('/images/vbe.png')}}" alt="" style="max-width: 40%;">
                </div>
                <form method="POST" class="m-0" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                        <div class="col-md-5">
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                                name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>

                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-5">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        {{-- <div class="col-md-8 offset-md-4 text-center"> --}}
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary width-100">
                                {{ __('Login') }}
                            </button>

                            {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                            </a>
                            @endif --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

<!-- เพิ่มส่วนของ SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ!',
        text: '{{ session('success') }}',
    });
</script>
@endif
