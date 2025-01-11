<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Rules\ValidDateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;



class AppointmentController extends Controller
{

    // SHOW
    public function index(Request $request)
    {
        $appointments = Appointment::with("client");

        if(request()->has('date') && $request->date) {
            $formatted_date = Carbon::createFromFormat('Y-m-d', request()->date)->format('d-m-Y');
            $appointments->where('date', $formatted_date);
        }

        if(request()->has('ucn') && $request->ucn) {
            $searchedUcn = request()->ucn;
            $appointments->whereHas('client', function ($query) use ($searchedUcn) {
                $query->where('ucn','like', $searchedUcn . '%');
            });
        }
        $appointments = $appointments->latest()->paginate(10);

        if(request()->wantsJson()) {
            return response()->json(Appointment::all());
        }

        return view('appointments.index', ['appointments' => $appointments]);
    }

    // Create
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('appointments.create', ["clients" => $clients]);
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => ['required', "exists:clients,name"],
            'date' => ['required', 'date_format:d-m-Y','after_or_equal:today'],
            'time' => ['required', 'date_format:H:i', new ValidDateTime()],
            'description' => ['max:255']
        ]);

        $clientId = Client::where("name", $validated["client_name"])->first()->id;
        $newAppointment = Appointment::create([
            "client_id" => $clientId,
            "date" => $validated['date'],
            "time" => $validated['time'],
            "description" => $validated['description'],
        ]);

        //flash message
        session()->flash('success', "Appointment added successfully {$newAppointment->client->name} will be informed by " . request('notification_type'));

        if(request()->wantsJson()) {
            return response()->json($newAppointment);
        }

        return redirect()->route('appointments.index');
    }

    // Show
    public function show(Appointment $appointment)
    {
        //Get all future appointments for current client
        $clientAppointments = Appointment::where("client_id", $appointment->client_id)
                                         ->where(function ($query) use ($appointment) {
                                             $query->where("date", "=", $appointment->date)
                                                   ->where("time", ">", $appointment->time)
                                                   ->orWhere("date",">", $appointment->date);
                                         })->get();

        if(request()->wantsJson()) {
            $appointment->client->toArray();
            return response()->json($appointment);
        }

        return view('appointments.show', ['appointment' => $appointment, "clientAppointments"=>$clientAppointments]);
    }

    // Edit
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', ['appointment' => $appointment]);
    }

    //Update

    public function update(Appointment $appointment)
    {
        $rules_appointment = [];

        if($appointment->date !== request('date')) {
            $rules_appointment['date'] = ['required', 'date_format:d-m-Y','after_or_equal:today'];
        }

        if($appointment->time !== request('time')) {
            $rules_appointment['time'] = ['required', 'date_format:H:i', new ValidDateTime()];
        }

        if($appointment->description !== request('description')) {
            $rules_appointment['description'] = ['max:255'];
        }

        if(!empty($rules_appointment)) {
            $validated = request()->validate($rules_appointment);
            $appointment->update($validated);
        }

        session()->flash('success', "Changes applied successfully. ". $appointment->client->name . " will be informed by " . request('notification_type'));

        return redirect()->route('appointments.show', ['appointment' => $appointment]);
    }

    //Destroy
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index');
    }

}
