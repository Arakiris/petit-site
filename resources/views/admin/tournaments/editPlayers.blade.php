@extends('layouts.admin')
@section('content')

@if(Session::has('notification_management_admin'))
    <div class="notification">
        <span class="notification__text">{{session('notification_management_admin')}}</span>
    </div>
@endif

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Gestion des participants des tournois</h1>

    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Tournois</li>
        <li class="active">Participants</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Gestion des participants de la ligue {{ $tournament->title }} - Saison  {{ date('Y', strtotime($tournament->start_season)) }}/{{ date('Y', strtotime($tournament->end_season)) }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="POST" action="/administration/tournois/{{$tournament->id}}/joueurs" >
                        {{csrf_field()}}
                        <div class="form-group">
                             <button type="submit" id="save" class="btn btn-primary">Mettre à jour</button>
                        </div>

                        <div class="form-group">
                            <label for="name">Nom du membre à ajouter</label>
                            <input id="autocomplete-members" class="dropdown-input"/>
                        </div>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nom - Prénom</th>
                                    <th>Classement</th>
                                    <th>Ordre d'affichage</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="add-members">
                                @if($tournament->members)
                                    <?php $count = 0; ?>
                                    @foreach($tournament->members as $member)
                                        <tr class="member">
                                            <td><input type="hidden" name="members[{{ $count }}][id]" class="form-control" value="{{ $member->id }}">{{ $member->last_name }} - {{ $member->first_name }}</td>
                                            <td><input type="text" name="members[{{$count}}][rank]" class="form-control" placeholder="Insérer son classement si existant" value="{{ $member->pivot->rank }}"></td>
                                            <td> <button class="btn-delete-member" type="button">Retirer le joueur</button> </td>
                                        </tr>

                                        <?php $count++; ?>
                                    @endforeach
                                @endif
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Nom - Prénom</th>
                                    <th>Classement</th>
                                    <th>Ordre d'affichage</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="form-group">
                            <button type="submit" id="save" class="btn btn-primary">Mettre à jour</button>
                       </div>
                    </form>
                    <div>
                        <a class="btn btn-default" href="{{ route('admin.tournois.edit',  $tournament->id) }}">Retour</a>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
         <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
@endsection

@section('scripts')
    <script>
        let inputmember = document.getElementById("autocomplete-members");
        let addmember = document.getElementById("add-members");
        let count = 0;
        count = <?php echo (($tournament->members->count() == 0) ? "0" : $tournament->members->count() + 1 ); ?>;
        let currentInput = "";

        inputmember.addEventListener("keydown", (e) => {
            if(e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });

        new Awesomplete(inputmember, {
            minChars: 0,
            list: [
                @if($members)
                    @foreach($members as $member)
                        <?php echo "{label: \"" . $member->last_name . " " . $member->first_name . "\", value: \"" . $member->id  . "\" },"; ?>
                    @endforeach
                @endif
            ],
            replace:  function(suggestion){
                this.input.value = suggestion.label;
            }
        }, false);

        inputmember.addEventListener("awesomplete-selectcomplete", event => {
            renderAddingMember(event.text.value, event.text.label);

            event.target.value = null;
        }, false);

        addmember.addEventListener("click", event => {
            if(event.target && event.target.classList.contains("btn-delete-member")){
                const member = event.target.closest(".member");

                member.parentElement.removeChild(member);
            }
        }, false)

        const renderAddingMember = (id, name) => {
            const markup = `
                <tr class="member">
                    <td><input type="hidden" name="members[${count}][id]" class="form-control" value="${id}">${name}</td>
                    <td><input type="text" name="members[${count}][rank]" class="form-control" placeholder="Insérer son classement si existant"></td>
                    <td> <button class="btn-delete-member" type="button">Retirer le joueur</button> </td>
                </tr>
            `;

            // OLD -> <td><input type="number" name="members[${count}][order_display]" class="form-control" placeholder="Ordre d'affichage"></td> 
            
            addmember.insertAdjacentHTML("beforeend", markup);
            
            count++;
        };
    </script>
@endsection
