@extends('layouts.master')

@section('content')
    @if(isset($warnings) && !is_null($warnings))
        <div class="main-content-title">
    @else
        <div class="main-content-title margin-top-30">
    @endif
        <h1>Version 1.0.0</h1>
    </div>
    <div class="main-content-version">
        <p> Ce site est destiné à l'ensemble des joueurs du BC Ozoir. Il est également accessible aux autres joueurs pour consultation. </p>
        <p>Ses pages proposent diverses informations telles que la liste des membres, les actualités, la programmation des tournois, les résultats, les photos et vidéos des tournois et évènements organisés par le club, les liens utiles, l'archivage des tournois, etc... L'arrivée de ce site permet de donner vie au club d'Ozoir en offrant à ses membres toutes les informations pratiques dont ils ont besoin. En même temps, il représente un socle commun ayant pour but de réunir, avec convivialité, la famille des passionnés de cette discipline qu'est le BOWLING.</p>
        <p> Cette première version est amenée à une évolution future en tenant compte des relevés de bogues et des demandes d'améliorations de la part des utilisateurs.</p>
        <p>Bonne utilisation à tous. </p>
    </div>
@endsection