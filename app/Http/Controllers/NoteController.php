<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use App\User;
use App\Http\Resources\Note as NoteResource;
use App\Http\Requests\StoreNote;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return request()->user()->notes;

        // return Note::with('users')->get();

        return NoteResource::collection(request()->user()->notes()->with('users')->get());
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
    public function store(StoreNote $request)
    {
        $validated = $request->validated();

        $note = Note::create([
            'content' => $validated['content'],
            'title' => $validated['title']
        ]);

        $note->users()->attach($request->user()->id, ['role' => 'owner']);


        return $note;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Note::with('users')->where('id', $id)->firstOrFail();

        return new NoteResource(Note::with('users')->where('id', $id)->firstOrFail());
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNote $request, $id)
    {
        $validated = $request->validated();

        // return $request->all();

        $note = Note::find($id);
        $user = User::where('email', $request->access)->firstOrFail();

        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();

        $note->users()->attach($user->id, ['role' => 'member']);

        return new NoteResource(Note::with('users')->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        $note->users()->detach();
        Note::destroy($id);
        return [];
    }
}
