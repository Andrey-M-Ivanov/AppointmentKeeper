<x-layout>
    <x-slot:heading>
        {{$client->name . " Information" }}
    </x-slot:heading>


    <div class="block w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Client Details</h2>
        <div class="space-y-4 mt-5">
            <p class="text-base text-gray-600"><span class="font-medium">Name:</span> {{$client->name}}</p>
            <p class="text-base text-gray-600"><span class="font-medium">Email:</span> {{$client->email}}</p>
            <p class="text-base text-gray-600"><span class="font-medium">Phone:</span> {{$client->phone}}</p>
            <p class="text-base text-gray-600"><span class="font-medium">UCN/ЕГН:</span> {{$client->ucn}}</p>
        </div>

        <div class="mt-2 flex justify-end space-x-4">

            <x-button href="{{route('clients.edit', $client)}}">Edit</x-button>
            <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-red-800 dark:border-gray-600 dark:text-gray-100 dark:focus:border-red-700 dark:active:bg-red-700 dark:active:text-red-300" form="delete-client">Delete</button>

            <form class="hidden" method="POST" id="delete-client" action="{{route('clients.show', $client)}}">
                @csrf
                @method("DELETE")
            </form>

        </div>
    </div>

</x-layout>



