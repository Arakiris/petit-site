<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tournament;
use App\Member;
Use App\Team;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idTournament)
    {
        $tournament = Tournament::findOrFail($idTournament);
        $members = Member::all();

        return view('admin.teams.create', compact('tournament', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validatedTeam = request()->validate([
            'name' => 'bail|nullable|string|max:255',
            'display_rank' => 'bail|boolean',
            'members.*.id' => 'bail|nullable|numeric',
            'members.*.rank' => 'nullable|string'
        ]);
        
        $team = new Team;
        $team->name = $validatedTeam["name"];
        $team->display_rank = $validatedTeam["display_rank"];

        $tournament = Tournament::findOrFail($id);
        $tournament->teams()->save($team);

        if(isset($validatedTeam["members"])){
            $memberpick;
            foreach($validatedTeam["members"] as $member){
                $rank = isset($member['rank']) ? $member['rank'] : "";
                $memberpick[$member['id']] = ['rank' => $rank];
            }
            $team->members()->sync($memberpick);
        }
        else {
            $team->members()->detach();
        }

        $tournament->members()->detach();

        session()->flash('notification_management_admin', 'L\'équipe a été créée');
        return redirect()->route('admin.tournois.edit', [$id]);
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
    public function edit($idTournament, $idTeam)
    {
        $team = Team::with('members')->findOrFail($idTeam);
        $members = Member::all();
        $tournament = $team->tournament;
        
        return view('admin.teams.edit', compact('team', 'tournament', 'members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idtournament, $idteam)
    {
        $validatedTeam = request()->validate([
            'name' => 'bail|nullable|string|max:255',
            'display_rank' => 'bail|boolean',
            'members.*.id' => 'bail|nullable|numeric',
            'members.*.rank' => 'nullable|string'
        ]);
        
        $team = Team::findOrFail($idteam);
        $team->name = $validatedTeam["name"];
        $team->display_rank = $validatedTeam["display_rank"];

        $team->save();

        if(isset($validatedTeam["members"])){
            $memberpick;
            foreach($validatedTeam["members"] as $member){
                $rank = isset($member['rank']) ? $member['rank'] : "";
                $memberpick[$member['id']] = ['rank' => $rank];
            }
            $team->members()->sync($memberpick);
        }
        else {
            $team->members()->detach();
        }

        $tournament = Tournament::findOrFail($idtournament);
        $tournament->members()->detach();

        session()->flash('notification_management_admin', 'L\'équipe a été éditée');
        return redirect()->route('admin.tournois.edit', [$idtournament]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idtournament, $idteam)
    {
        Team::findOrFail($idteam)->delete();

        session()->flash('notification_management_admin', 'L\'équipe a bien été supprimée');
        return redirect()->route('admin.tournois.edit', [$idtournament]);
    }
}
