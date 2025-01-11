<x-layout>
    <x-slot:heading>
        All Clients
    </x-slot:heading>

    <form method="GET" action="{{route('clients.index')}}" class="mb-6">
        <div class="flex justify-between gap-6">
            <div class="flex flex-col">
                <x-form-label for="name"> Search by Name</x-form-label>
                <x-form-input name="name" value="{{request('name')}}" placeholder="Enter Name"/>
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

        <x-table-header :headers="['Name','UCN/ЕГН','Email','Phone']" />

        <tbody>

        @foreach($clients as $client)
            <x-table-row :routeFor="'clients.show'" :idFor="$client" :rowData="[
                                            $client->name,
                                            $client->ucn,
                                            $client->email,
                                            $client->phone]" />
        @endforeach

        </tbody>
    </x-table>

    <div>
        {{$clients->links()}}
    </div>

</x-layout>



