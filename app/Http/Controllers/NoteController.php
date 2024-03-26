<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::whereBelongsTo(Auth::user())->latest('updated_at')->paginate(5);
        return view('notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'title' => 'required|max:120',
                'text' => 'required'
            ]
        );
        $validate['user_id'] = Auth::id();
        $validate['uuid'] = str()->uuid();

        Note::create($validate);

        return to_route('notes.index')->with('success', 'Note Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }

        $validate = $request->validate(
            [
                'title' => 'required|max:120',
                'text' => 'required'
            ]
        );

        $note->update($validate);
        return to_route('notes.index')->with('success', 'Update Note Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }
        $note->delete();
        return to_route('notes.index')->with('success', 'Note Move to Trash!');
    }
}
