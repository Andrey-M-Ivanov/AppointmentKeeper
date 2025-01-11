<x-layout>
    <x-slot:heading>
        All Appointments
    </x-slot:heading>

    <form method="GET" action="{{route('appointments.index')}}" class="mb-6">
        <div class="flex justify-between gap-6">
            <div class="flex flex-col">
                <x-form-label for="date"> Date Selector</x-form-label>
                <x-form-input name="date" value="{{request('date')}}" type="date" />
            </div>
            <div class="flex flex-col">
                <x-form-label for="ucn"> Search by UCN/ЕГН</x-form-label>
                <x-form-input name="ucn" value="{{request('ucn')}}" placeholder="Enter UCN" />
            </div>
            <div class="flex items-end">
                <x-form-button>Filter</x-form-button>
            </div>
        </div>
    </form>


    <x-table>

        <x-table-header :headers="['Name','UCN/ЕГН','Date','Time','Description']" />

        <tbody>

        @foreach($appointments as $appointment)
            <x-table-row :routeFor="'appointments.show'" :idFor="$appointment" :rowData="[
                                            $appointment->client->name,
                                            $appointment->client->ucn,
                                            $appointment->date,
                                            $appointment->time,
                                            $appointment->description]" />
        @endforeach

        </tbody>
    </x-table>

    <div>
        {{$appointments->links()}}
    </div>

</x-layout>



