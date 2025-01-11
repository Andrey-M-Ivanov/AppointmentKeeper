<x-layout>
    <x-slot:heading>
        Edit Client
    </x-slot:heading>


    <form method="POST" action="{{route('clients.update', $client)}}">
        @csrf
        @method("PATCH")
        <div class="space-y-12 pl-20 pr-20">

            <div class="border-b border-gray-900/10 pb-12">

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-4">

                    <div class="sm:col-span-4">
                        <x-form-label for="name">Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="name" name="name" value="{{$client->name}}" required/>
                        </div>
                        <x-form-error-message name="name" />
                    </div>

                    <div class="sm:col-span-4">
                        <x-form-label for="email" >Email Address</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="email" name="email" value="{{$client->email}}" required/>
                        </div>
                        <x-form-error-message name="email" />
                    </div>

                    <div class="sm:col-span-2 sm:col-start-1">
                        <x-form-label for="phone" >Telephone Number</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="phone" id="phone" value="{{$client->phone}}" required/>
                        </div>
                        <x-form-error-message name="phone" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-form-label for="ucn" >UCN / ЕГН</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="ucn" id="ucn" value="{{$client->ucn}}" required/>
                        </div>
                        <x-form-error-message name="ucn" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6 pl-20 pr-20">
            <x-button href="{{route('clients.index')}}">Cancel</x-button>
            <x-form-button>Save</x-form-button>
        </div>
    </form>



</x-layout>


