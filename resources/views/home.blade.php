@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                        <h1>{{ __('messages.hello', ['name' => Auth::user()->name] ) }}</h1>
                    @endauth

                    <h1>{{ __('messages.welcome') }}</h1>
                    {{-- <h1>@lang('messages.welcome')</h1> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
