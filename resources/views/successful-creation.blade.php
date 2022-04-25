@extends('layouts.app')
@section('title', 'Information stored successfully.')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="tab-content text-center mb-3">
                <h1 class="mb-5">{{ $pet->pet_name }} has been successfully registered!</h1>
                <img class="w-100" src="{{ asset("/images/success-funy-image.jpg") }}" style="border-radius: 500px;">
            </div>
            <p class="text-center text-muted"><a href="{{ route('pets') }}" style="color: gray">Sofya is that you? Go to registered pets.</a></p>
        </div>
    </div>
@endsection

