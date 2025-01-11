<!doctype html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Keeper</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">

@if(session('success'))
    <div class="fixed top-0 left-0 right-0 z-50 p-4">
        <div class="bg-green-500 text-white p-4 rounded-md" style="animation: fadeOut 2s ease-in-out forwards;">
            <span>{{session('success')}}</span>
        </div>
    </div>

    <style>
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            80% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
@endif

<div class="min-h-full">
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <img class="size-8" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <x-nav-link href="{{route('appointments.index')}}" :active="request()->is('/')">Appointments</x-nav-link>
                            <x-nav-link href="{{route('clients.index')}}" :active="request()->is('clients')">Clients</x-nav-link>
                            <x-nav-link href="{{route('appointments.create')}}" :active="request()->is('appointments/create')">Create New Appointment</x-nav-link>
                            <x-nav-link href="{{route('clients.create')}}" :active="request()->is('clients/register')">Create New Client</x-nav-link>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <x-nav-link href="{{route('appointments.index')}}" :active="request()->is('/')">Appointments</x-nav-link>
                <x-nav-link href="{{route('clients.index')}}" :active="request()->is('clients')">Clients</x-nav-link>
                <x-nav-link href="{{route('appointments.create')}}" :active="request()->is('appointments/create')">Create New Appointment</x-nav-link>
                <x-nav-link href="{{route('clients.create')}}" :active="request()->is('clients/register')">Create New Client</x-nav-link>

            </div>
        </div>
    </nav>

    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $heading }}</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</div>




</body>
</html>
