@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col col-4">
            <div>
                @if ($user->image)
                    <img class="mb-3 rounded-circle" height="200px" width="200px" src="{{ $user->image->url() }}" alt="{{ $user->name }}" />
                @else
                    <img class="mb-3 rounded-circle" height="200px" width="200px" src="/storage/userImages/user.jpg" alt="{{ $user->name }}" />
                @endif

                @auth
                    @can('update', $user)
                        <form action="{{ route('users.update', ['user' => Auth::id()]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <input type="file" name="image" id="userImage" />
                            <button class="btn btn-success mt-3">Update Photo</button>
                        </form>
                    @endcan
                @endauth
            </div>
        </div>
        <div class="col col-md-8">
            <h3>{{ $user->name }}</h3>
            {{-- how many people is seeing this profile --}}
            <span class="badge badge-info">{{ $currentlyReading }} people seeing this profile</span>

            <div class="my-3">
                @include('comments._form')
            </div>

            @comments(['list' => $user->profileComments])
            @endcomments
        </div>
    </div>
@endsection
