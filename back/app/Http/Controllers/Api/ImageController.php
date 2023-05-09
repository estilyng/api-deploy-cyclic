<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\json_decode;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call)
    {
        $user = User::find(auth()->user()->id);
        $call = $user->calls()->where('call_id', $call->id)->get();
        // $image = $call->images[0]->path;
        return response()->json($call->images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::find(auth()->user()->id);
        $call = $user->calls()->orderBy('created_at', 'desc')->first();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/calls/' . $call->id);
                $path = str_replace('public/', '', $path);
                $call->images()->create(['path' => $path]);
            }
            return response()->json($call);
        }
        if ($request->file('images') == null) {
            return response($call);
        }
        return response()->json(['error' => 'Dado não é um arquivo.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $call = Call::find($id);
        return response($call->images);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * storeImageInCall the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeImageInCall(Request $request, $id)
    {
        $call = Call::find($id);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/calls/' . $call->id);
                $path = str_replace('public/', '', $path);
                $call->images()->create(['path' => $path]);
            }
            return response()->json(['success' => $call]);
        }
        if ($request->file('images') == null) {
            return response(['error' => $call]);
        }
        return response()->json(['error' => 'Dado não é um arquivo.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return 'route delete image';
    }
}
