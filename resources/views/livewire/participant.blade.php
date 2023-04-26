<div>
    <form role="form" class="form-group">
        <div class="row ">
            <div class="col-lg-12">
                @if (session()->has("message"))
                <div class="col-md-6 col-md-offset-3">
                    <div class="alert alert-{{session()->get('type')}} alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{ session()->get('message') }}
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="form-inlin">
                    <input type="text"
                        placeholder="Trouvez un client par son téléphone ou l'e-mail pour éviter les doublons"
                        class="form-control" name='titre' autocomplete="off"
                        wire:model.debounce.500ms="client">

                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-inlin">
                    <button class="btn btn-sm btn-primary"
                        wire:click.prevent="opneFolder('{{ empty($tab)?'':$tab->id }}')"
                        type="submit" @disabled($existe)>
                        <i class="fa fa-folder-open"></i> Ouvrir le dossier de {{
                        empty($tab)?'':$tab->prenom.' '.$tab->nom }}</button>

                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-inlin">
                    <button class="btn btn-sm btn-warning"
                        wire:click.prevent="store('{{ empty($tab)?'':$tab->id }}')"
                        type="submit" @disabled($existe)>
                        <i class="fa fa-folder-open"></i>Enregistrer {{
                        empty($tab)?'':$tab->prenom.' '.$tab->nom }}</button>
                </div>
            </div>
            <br>
                <div class="col-sm-12 form-group " {{ empty($tab)?'hidden':""  }}>
                    <label>Conférences</label>
                    <select name="statut" id="statut"
                        class="form-control select2"
                        onchange="select(this.value)" required
                        wire:model.defer='reunion'>
                        <option value="" disabled selected> --Selectionez une réunion--</option>
                        @forelse ($reunions as $s)
                        <option value="{{ $s->id }}">{{"(".$s->context.") ".$s->titre }}</option>
                        @empty

                        @endforelse
                    </select>

                    @error('statut') <span class="error text-danger">{{ $message}}</span> @enderror

                </div>
                <br>
                {{-- @if (session()->has('qrcode')!="")
                        <div class="col-lg-offset-3 col-lg-6 col-sm-12 form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <a href="{{ route('viewQrcode',["id"=>session()->get('qrcode')]) }}" target="_blank"
                                    class="btn btn-lg btn-outline btn-primary">Voir le QRCODE du participant</a>

                            </div>

                        </div>
                        @endif --}}
        </div>
    </form>
    <br> <br>
    <div class="ibox-title">
        <h5>Ce formulaire vous permet d'enregistrer un participant</h5>
    </div>
    <div class="ibox-content " wire:loading.class='sk-loading'>
        <div class="sk-spinner sk-spinner-wandering-cubes">
            <div class="sk-cube1"></div>
            <div class="sk-cube2"></div>
        </div>
        <div class='row'>
            <div class=" col-lg-12 col-sm-12">
                <form method="POST" class="" action=""
                    class='form-group' data-parsley-validate wire:submit.prevent="saveClient">
                    <div class="row">
                        <div>
                            <input name="id" hidden value=""  wire:model.defer='ids'/>
                        </div>
                        <div class="col-sm-6 form-group ">
                            <label>NOM</label>
                            <input type="text" placeholder="Nom de la personne"
                                class="form-control" name='nom' required aria-required="true"
                                value="" data-parsley-minlength="2" data-parsley-trigger="change"
                                wire:model.defer='nom'>
                        </div>
                        <div class="col-sm-6 form-group ">
                            <label>POSTNOM</label>
                            <input type="text" placeholder="Postnom de la personne"
                                class="form-control" name='postnom'
                                wire:model.defer='postnom'>
                        </div>
                        <div class="col-sm-6 form-group ">
                            <label>PRENOM</label>
                            <input type="text" placeholder="Prenom de la personne"
                                class="form-control" name='prenom' required aria-required="true"
                                value="" data-parsley-minlength="2"data-parsley-trigger="change"
                                wire:model.defer='prenom'>
                        </div>
                        <div class="col-sm-6 form-group ">
                            <label>Sexe</label>
                            <select class=" form-control" id="" required aria-required="true"
                                class="validate" data-parsley-trigger="change" name="type"
                                wire:model.defer='sexe'>
                                <option value="" disabled selected>Selectionnez genre
                                </option>
                                <option value="HOMME">HOMME</option>
                                <option value="FEMME">FEMME</option>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group ">
                            <label>Téléphone</label>
                            <input type="text" placeholder="Numéro de téléphone"
                                class="form-control" name='phone' required aria-required="true"
                                value="" data-parsley-minlength="2" data-parsley-trigger="change"
                                wire:model.defer='phone'>
                                @error('phone') <span class="error text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                        <div class="col-sm-6 form-group ">
                            <label>Email</label>
                                <input type="text" name="email" class="form-control"
                                    placeholder='Email' wire:model.defer='email'>
                                    @error('email') <span class="error text-danger">{{ $message
                                    }}</span> @enderror
                        </div>

                        <div class="col-lg-offset-3 col-lg-6 col-sm-12 form-group">

                            <div class="col-sm-offset-4 col-sm-5">
                                <button class="ladda-button btn btn-sm btn-primary"
                                    type="submit" name='btnReunion'>Enregistrer</button>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
