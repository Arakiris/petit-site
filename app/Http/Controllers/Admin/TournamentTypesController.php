<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CommonTrait;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TournamentType;

class TournamentTypesController extends Controller
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournamentTypes = TournamentType::all();
        return view('admin.tournamentsType.index', compact('tournamentTypes'));
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
        $validatedTournamentsType= request()->validate([
            'title' => 'required'
        ]);

        TournamentType::create($validatedTournamentsType);
        $this->updateStatisticDate();

        session()->flash('notification_management_admin', 'Le type de tournois a bien été enregistré');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tournamentType = TournamentType::findOrFail($id);
        return view('admin.tournamentsType.edit', compact('tournamentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedTournamentsType= request()->validate([
            'title' => 'required'
        ]);

        TournamentType::findOrFail($id)->update($validatedTournamentsType);
        $this->updateStatisticDate();

        session()->flash('notification_management_admin', 'Le type de tournois a bien été modifié');

        return redirect('/administration/typeTournois');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TournamentType::findOrFail($id)->delte();
        $this->updateStatisticDate();
        
        session()->flash('notification_management_admin', 'Le type de tournois a bien été supprimé');

        return redirect('/administration/typeTournois');
    }
}
