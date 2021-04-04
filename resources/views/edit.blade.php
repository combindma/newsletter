@extends('dashui::layouts.app')
@section('title', 'Modifier abonné')
@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-md">
            <form id="form-action" action="{{ route('newsletter::newsletter.update', $subscriber) }}" method="POST">
                <div class="py-6 px-4 sm:p-6">
                    <div class="mb-4">
                        <h1 class="text-lg leading-6 font-medium text-gray-900">Modifier information abonné</h1>
                    </div>
                    @include('dashui::components.alert')
                    @csrf
                    @method('PUT')
                    @include('newsletter::form')
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="btn">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
