<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(ContactResource::collection(Contact::all()),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->toArray(),[
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'jobTitle' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);
        if($validate->fails()){
            return response($validate->errors(),400);
        }
        return response(new ContactResource(Contact::create($validate)),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($contact)
    {
        return response(new ContactResource(Contact::findorFail($contact)),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $validate = Validator::make($request->toArray(),[
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'jobTitle' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);
        if($validate->fails()){
            return response($validate->errors(),400);
        }
        $contact->update($validate->validate());
        return response(new ContactResource($contact),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findorFail($id);
        if($contact->delete()){
            return response(null, 204);
        }
    }
}
