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
                <form action="{{ route('users.update', ['user' => Auth::id()]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="file" name="image" id="userImage" />
                    <button class="btn btn-success mt-3">Update Photo</button>
                </form>
            </div>



            <div class="input-group mb-3 mt-3">
                <div>
                </div>
            </div>
        </div>



        <h3>{{ $user->name }}</h3>


    </div>
@endsection
