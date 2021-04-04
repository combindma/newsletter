@extends('dashui::adminlayouts.app')
@section('title', 'Abonnés aux newsletters')
@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div x-data="{ open: false }" @keydown.window.escape="open = false" class="mb-4 border-b border-gray-200">
            <div class="pb-8 sm:flex sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                        Abonnés aux newsletters
                    </h1>
                </div>
                <div class="mt-4 flex sm:mt-0 sm:ml-4">
                    <button @click="open=true" type="button" class="btn">
                        Ajouter un nouveau abonné
                    </button>
                </div>
            </div>
            <div x-show="open" class="z-10 fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <section @click.away="open = false" class="absolute inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16" aria-labelledby="slide-over-heading">
                        <div x-show="open"
                             x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                             x-transition:enter-start="translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="translate-x-full"
                             class="bg-gray-500 bg-opacity-75 transition-opacity w-screen max-w-xl">
                            <div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl overflow-y-scroll">
                                <div class="min-h-0 flex-1 flex flex-col overflow-y-scroll">
                                    <div class="py-6 px-4 bg-primary-700 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <h2 id="slide-over-heading" class="text-lg font-medium text-white">
                                                Ajouter un nouveau abonné
                                            </h2>
                                            <div class="ml-3 h-7 flex items-center">
                                                <button @click="open=false" class="bg-primary-700 rounded-md text-primary-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                    <span class="sr-only">Close panel</span>
                                                    <!-- Heroicon name: outline/x -->
                                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 relative flex-1 px-4 py-6 sm:px-6">
                                        <form id="form-action" action="{{ route('newsletter::newsletter.store') }}" method="POST">
                                            @csrf
                                            @include('newsletter::form', ['subscriber' => new \Combindma\Newsletter\Models\NewsletterSubscription()])
                                        </form>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 px-4 py-4 flex justify-end">
                                    <button @click="open=false" type="button" class="btn-subtle">
                                        Annuler
                                    </button>
                                    <button onclick="document.getElementById('form-action').submit();" type="submit" class="btn ml-3">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @include('dashui::admincomponents.alert')
        @if ($subscribers->isEmpty())
            @component('dashui::admincomponents.blank-state')
                @slot('icon')
                    <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                @endslot
                @slot('heading')
                    Liste vide
                @endslot
                Aucun abonné trouvé
            @endcomponent
        @else
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Liste
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prénom
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Téléphone
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($subscribers as $subscriber)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $subscriber->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ucfirst($subscriber->list)??'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 underline">
                                        <a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($subscriber->nom)??'-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($subscriber->prenom)??'-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($subscriber->phone)??'-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @include('newsletter::menu-action', ['subscriber' => $subscriber])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="bg-white border-t border-gray-200 px-4 py-4 sm:px-6">
                            {{ $subscribers->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
