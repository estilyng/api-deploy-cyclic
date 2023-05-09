<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::with('user')->get();

        //Gate::authorize('ver-chamado', $services );

        return response()->json($services);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:100'],
            'destiny' => ['required','string', 'max:255'],
            'term' => ['required', 'integer'],
            'initials' => ['string', 'max:15'],
            'priority' => ['required','string', 'max:50'],
        ]);

        if ($validated) {

            $service = DB::transaction(function () use ($request) {
               
                $service = Service::create($request->all());
                return $service;
            });
            // $newService = Service::with('user')->find($service->id);
            return response()->json($service);

        } else return response()->json(['error' => 'dados inválidos']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:100'],
            'destiny' => ['string', 'max:255'],
            'term' => ['required', 'integer'],
            'initials' => ['string', 'max:15'],
            'priority' => ['string', 'max:50'],
        ]);
        if ($validated) {

            $service = DB::transaction(function () use ($service, $request) {
                $service->update($request->all());
                return $service;
            });

            return response($service);

        } else return response()->json(['error' => 'dados inválidos']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(200);
    }
}
