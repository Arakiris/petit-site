@extends('layouts.master')

@section('keywords')
    <meta name="keywords" content="membres listing" />
@endsection


@section('content')
<div class="content__title">
    <h1 class="heading-1">{{$member->first_name}} {{$member->last_name}}</h1>
</div>
<div class="member-tournaments">
        @if(isset($tournaments) && !empty($tournaments))
            <table class="table">
                <thead>
                    <th class="table__th table__width-15">Date</th>
                    <th class="table__th table__width-30">Tournoi</th>
                    <th class="table__th table__width-10">Type</th>
                    <th class="table__th table__width-15">Lieu</th>
                    <th class="table__th table__width-10">Homol.</th>
                    <th class="table__th table__width-20">Classement podiums</th>
                </thead>
                <tbody>
                    <?php $now = \Carbon\Carbon::now(); ?>
                    @foreach($tournaments as $tournament)
                        <tr class="table__tr--membertournament {{$now->gt($tournament->date) ? 'table__past-tournament' : 'table__future-tournament'}}">
                            <td class="table__td--membertournament"><?php setlocale(LC_TIME, 'fr'); echo utf8_encode(strftime("%d-%B-%Y", $tournament->date->timestamp)); ?></td>
                            <td class="table__td--membertournament">{{$tournament->title}}</td>
                            <td class="table__td--membertournament">{{$tournament->type->title}}</td>
                            <td class="table__td--membertournament">{{$tournament->place}}</td>
                            <td class="table__td--membertournament">{{$tournament->is_accredited ? "Oui" : "Non"}}</td>
                            <td class="table__td--membertournament">{{!empty($tournament->rank) ? $tournament->rank : ''}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="member-tournaments__nocontent">
                <p>Il n'y a pas encore de listing d'enregistrer.</p>
            </div>
        @endif
</div>
@endsection