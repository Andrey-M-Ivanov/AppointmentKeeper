<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        $query = Client::query();

        if(request()->has('name') && request()->name){
            $query->where("name", "like", request()->name."%");
        }

        if(request()->has('ucn') && request()->ucn){
            $query->where("ucn", "like", request()->ucn. "%");
        }

        $clients = $query->orderBy('name')->paginate(10);

        if(request()->wantsJson()){
            return response()->json(Client::all());
        }

        return view("clients.index", ["clients" => $clients]);
    }


    public function create()
    {
        return view('clients.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255", "unique:clients"],
            "phone" => ["required", "numeric", "digits:10", "unique:clients"],
            "ucn" => ["required", "numeric", "digits:10" ,"unique:clients"],
        ]);

        $newClient = Client::create($validated);

        if(request()->wantsJson()){
            return response()->json($newClient);
        }

        session()->flash("success", "Client Registered Successfully");
        return redirect()->route("clients.index");
    }


    public function show(Client $client)
    {
        if(request()->wantsJson()){
            return response()->json($client);
        }
        return view("clients.show", ["client" => $client]);
    }


    public function edit(Client $client)
    {
        return view("clients.edit", ["client" => $client]);
    }


    public function update(Request $request, Client $client)
    {

        $rules_client = [];

        if($client->name !== request('name')) {
        $rules_client['name'] = ['required', 'string', 'max:255'];
        }

        if($client->email !== request('email')) {
            $rules_client['email'] = ['required', 'email', 'max:255'];
        }

        if($client->phone !== request('phone')) {
            $rules_client['phone'] = ['required'];
        }

        if($client->ucn !== request('ucn')) {
            $rules_client['ucn'] = ['required', 'min:10', 'max:10'];
        }

        if(!empty($rules_client)) {
            $validated = $request->validate($rules_client);
            $client->update($validated);
        }

        session()->flash("success", "Client Details Updated Successfully");
        return redirect()->route("clients.index");
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index');
    }
}
