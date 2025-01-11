<x-layout>
    <x-slot:heading>
        {{$appointment->client->name . " Appointments" }}
    </x-slot:heading>


    <div class="block w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Appointment Details</h2>
        <div class="space-y-4 mt-5">
            <p class="text-base text-gray-600"><span class="font-medium">Name:</span> {{$appointment->client->name}}</p>
        </div>
        <div class="space-y-4 mt-4">
            <p class="text-base text-gray-600"><span class="font-medium">Date:</span> {{$appointment->date}}</p>
            <p class="text-base text-gray-600"><span class="font-medium">Time:</span> {{$appointment->time}}</p>
        </div>
        <div class="space-y-4 mt-4">
            <p class="text-base text-gray-600 break-words"><span class="font-medium" >Description:</span> {{$appointment->description ?? "No Additional information"}}</p>
        </div>

        <div class="mt-2 flex justify-end space-x-4">

            <x-button href="{{route('appointments.edit', $appointment)}}">Edit</x-button>
            <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-red-800 dark:border-gray-600 dark:text-gray-100 dark:focus:border-red-700 dark:active:bg-red-700 dark:active:text-red-300" form="delete-appointment">Delete</button>

            <form class="hidden" method="POST" id="delete-appointment" action="{{route('appointments.show', $appointment)}}">
                @csrf
                @method("DELETE")
            </form>

        </div>
    </div>


    @if($clientAppointments->isNotEmpty())

        <h2 class="text-xl font-semibold text-center text-gray-800 mt-8 mb-4">
            Future Appointment for {{$appointment->client->name}}
        </h2>


        <div class="mt-8">
        <x-table>

            <x-table-header :headers="['Name','Date','Time','Description','Created_on']" />

            <tbody>

            @foreach($clientAppointments as $appointment)
                <x-table-row :routeFor="'appointments.show'" :idFor="$appointment" :rowData="[$appointment->client->name,
                                                $appointment->date,
                                                $appointment->time,
                                                $appointment->description,
                                                $appointment->updated_at]" />
            @endforeach

            </tbody>
        </x-table>
        </div>
    @else
        <h2 class="text-xl font-semibold text-center text-gray-800 mt-8 mb-4">
            There are no future appointment for {{$appointment->client->name}}
        </h2>
    @endif
</x-layout>



