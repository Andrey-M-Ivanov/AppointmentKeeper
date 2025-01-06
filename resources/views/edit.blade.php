<x-layout>
    <x-slot:heading>
        Edit Appointment
    </x-slot:heading>


    <form method="POST" action="{{route('edit', $appointment)}}">
        @csrf
        @method("PATCH")

        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <x-form-label for="name">Name</x-form-label>
                        <div class="mt-2">
                          <x-form-input id="name" name="name" required value="{{$appointment->client->name}}" required/>
                        </div>
                        <x-form-error-message name="name" />
                    </div>

                    <div class="sm:col-span-4">
                        <x-form-label for="email" >Email Address</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="email" name="email" required value="{{$appointment->client->email}}"/>
                        </div>
                        <x-form-error-message name="email" />
                    </div>

                    <div class="sm:col-span-2 sm:col-start-1">
                        <x-form-label for="phone" >Telephone Number</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="phone" id="phone" required value="{{$appointment->client->phone}}"/>
                        </div>
                        <x-form-error-message name="phone" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-form-label for="ucn" >UCN / ЕГН</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="ucn" id="ucn" value="{{$appointment->client->ucn}}" required />
                        </div>
                        <x-form-error-message name="ucn" />
                    </div>

                    <div class="sm:col-span-2 sm:col-start-1">
                        <x-form-label for="date">Appointment Date</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="date" id="date" required value="{{$appointment->date}}"/>
                        </div>

                    </div>

                    <div class="sm:col-span-2">
                        <x-form-label for="time" >Appointment Time</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="time" id="time" required value="{{$appointment->time}}"/>
                        </div>
                    </div>

                    <div class="col-span-4">
                        <x-form-error-message name="date" />
                        <x-form-error-message name="time" />
                    </div>

                    <div class="col-span-4">
                        <x-form-label for="description" >Description</x-form-label>
                        <div class="mt-2">
                            <textarea name="description" id="description" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Additional information goes here."
                                      >{{$appointment->description}}</textarea>
                        </div>
                        <x-form-error-message name="description" />
                    </div>

                    <div class="col-span-4">
                        <x-form-label> Notify With</x-form-label>
                    </div>

                    <div class="sm:col-span-2 sm:col-start-1">
                        <input id="notification_type" type="radio" value="Phone" name="notification_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="notification_type" class="ms-2 text-sm font-medium text-black-900 dark:text-black-300">SMS</label>
                    </div>
                    <div class="sm:col-span-2">
                        <input checked id="notification_type" type="radio" value="Email" name="notification_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="notification_type" class="ms-2 text-sm font-medium text-black-900 dark:text-black-300">Email</label>
                    </div>

                </div>
            </div>



        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <x-button href="{{route('index')}}">Cancel</x-button>
            <x-form-button>Save</x-form-button>
        </div>
    </form>



</x-layout>


