<header class="row">
    @include('includes.header')
    <link rel="stylesheet" href="{{ asset('css/header/header.css') }}">

</header>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<footer>
    @include('includes/footer')
    <link rel="stylesheet" href="{{ asset('css/footer/footer.css') }}">
</footer>
