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
            return response()->json($appointments);
        }

        return view('index', ['appointments' => $appointments]);
    }

    // Create
    public function create()
    {
        return view('create');
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'ucn' => ['required', 'numeric', 'digits:10'],
            'date' => ['required', 'date_format:d-m-Y','after_or_equal:today'],
            'time' => ['required', 'date_format:H:i', new ValidDateTime()],
            'description' => ['max:255']
        ]);

        // check if client already exist in db before creating new record

           $client = Client::where("ucn", $validated["ucn"])->first();

           if(!$client) {
               //check if the email is taken from another client
               if(Client::where("email", $validated["email"])->exists()) {
                   return redirect()->back()->withErrors(['email' => 'Email is already taken.'])->withInput();
               }
               //check if the phone is taken from another client

               if(Client::where("phone", $validated["phone"])->exists()){
                   return redirect()->back()->withErrors(['phone' => 'Phone is already taken.'])->withInput();
               }
               $client = Client::create([
                   "name" => $validated["name"],
                   "email" => $validated["email"],
                   "phone" => $validated["phone"],
                   "ucn" => $validated["ucn"],
               ]);
           }

        //check if current client has changed email and update it
        if ($client['email'] !== $validated['email']) {
            if (Client::where("email", $validated["email"])->where("ucn", "!=", $client["ucn"])->exists()) {
                return redirect()->back()->withErrors(['email' => 'Email is already taken.'])->withInput();
            } else {
                $client->update(["email" => $validated["email"]]);
            }
        }
        //check if current client has changed phone and update it
        if ($client['phone'] !== $validated['phone']) {
            if (Client::where("phone", $validated["phone"])->where("ucn", "!=", $client["ucn"])->exists()) {
                return redirect()->back()->withErrors(['phone' => 'Phone is already taken.'])->withInput();
            } else {
                $client->update(["phone" => $validated["phone"]]);
            }
        }

        $newAppointment = Appointment::create([
            "client_id" => $client->id,
            "date" => $validated['date'],
            "time" => $validated['time'],
            "description" => $validated['description'],
        ]);

        //flash message
        session()->flash('success', "Appointment added successfully {$validated['name']} will be informed by " . request('notification_type'));
        if(request()->wantsJson()) {
            $newAppointment->client->toArray();
            return response()->json($newAppointment);
        }
        return redirect()->route('index');
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

        return view('show', ['appointment' => $appointment, "clientAppointments"=>$clientAppointments]);
    }

    // Edit
    public function edit(Appointment $appointment)
    {
        return view('edit', ['appointment' => $appointment]);
    }

    //Update

    public function update(Appointment $appointment)
    {
        $rules_client = [];
        $rules_appointment = [];

        if($appointment->client->name !== request('name')) {
            $rules_client['name'] = ['required', 'string', 'max:255'];
        }

        if($appointment->client->email !== request('email')) {
            $rules_client['email'] = ['required', 'email', 'max:255'];
        }

        if($appointment->client->phone !== request('phone')) {
            $rules_client['phone'] = ['required'];
        }

        if($appointment->client->ucn !== request('ucn')) {
            $rules_client['ucn'] = ['required', 'min:10', 'max:10'];
        }

        if($appointment->date !== request('date')) {
            $rules_appointment['date'] = ['required', 'date_format:d-m-Y','after_or_equal:today'];
        }

        if($appointment->time !== request('time')) {
            $rules_appointment['time'] = ['required', 'date_format:H:i', new ValidDateTime()];
        }

        if($appointment->description !== request('description')) {
            $rules_appointment['description'] = ['max:255'];
        }

        if(!empty($rules_client)) {
            $validated_client = request()->validate($rules_client);
            $appointment->client()->update($validated_client);
        }

        if(!empty($rules_appointment)) {
            $validated_appointment = request()->validate($rules_appointment);
            $appointment->update($validated_appointment);
        }

        session()->flash('success', "Appointment added successfully ". request('name') . " will be informed by " . request('notification_type'));

        return redirect()->route('show', ['appointment' => $appointment]);
    }

    //Destroy
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('index');
    }

}
