@extends('layouts.app')

@section('title')
    {{ __('strings.home_title') }}
@endsection

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                {{ __('strings.home_title') }}
            </div>
        </div>
    </div>
@endsection
