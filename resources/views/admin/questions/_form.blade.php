@php
    $typeActuel = old('type', $question->type?->value ?? 'qcm');

    // Lignes de réponses du QCM : [clé => libellé]. La clé identifie la bonne réponse.
    if (old('reponses') !== null) {
        $lignes = (array) old('reponses');
        $correcte = old('correcte');
    } elseif ($question->exists && $question->type === \App\Enums\TypeQuestion::QCM) {
        $lignes = $question->reponses->pluck('libelle', 'id')->all();
        $correcte = optional($question->reponses->firstWhere('est_correcte', true))->id;
    } else {
        $lignes = [];
        $correcte = null;
    }

    // Vrai/faux : la bonne réponse actuelle.
    if (old('correcte_vf') !== null) {
        $vraiFaux = old('correcte_vf');
    } elseif ($question->exists && $question->type === \App\Enums\TypeQuestion::VRAI_FAUX) {
        $vraiFaux = optional($question->reponses->firstWhere('libelle', 'Vrai'))->est_correcte ? 'vrai' : 'faux';
    } else {
        $vraiFaux = 'vrai';
    }
@endphp

<div class="mb-3">
    <label for="enonce" class="form-label">Énoncé de la question *</label>
    <textarea id="enonce" name="enonce" rows="3" required
              class="form-control @error('enonce') is-invalid @enderror">{{ old('enonce', $question->enonce) }}</textarea>
    @error('enonce')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="type" class="form-label">Type de question *</label>
    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
        @foreach (\App\Enums\TypeQuestion::cases() as $type)
            <option value="{{ $type->value }}" @selected($typeActuel === $type->value)>{{ $type->libelle() }}</option>
        @endforeach
    </select>
    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

{{-- QCM : réponses libres, une seule bonne réponse --}}
<div id="bloc-qcm" class="mb-3">
    <label class="form-label">Réponses * <span class="text-muted small">(cochez la bonne réponse)</span></label>
    <div id="liste-reponses">
        @foreach ($lignes as $cle => $libelle)
            <div class="input-group mb-2 ligne-reponse">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" name="correcte" value="{{ $cle }}"
                           title="Bonne réponse" @checked((string) $correcte === (string) $cle)>
                </div>
                <input type="text" name="reponses[{{ $cle }}]" value="{{ $libelle }}" maxlength="255"
                       class="form-control" placeholder="Libellé de la réponse">
                <button type="button" class="btn btn-outline-danger supprimer-reponse" title="Supprimer cette réponse">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        @endforeach
    </div>
    <button type="button" id="ajouter-reponse" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-plus-lg me-1"></i>Ajouter une réponse
    </button>

    @error('reponses')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
    @foreach ($errors->get('reponses.*') as $messages)
        @foreach ($messages as $message)
            <div class="text-danger small mt-1">{{ $message }}</div>
        @endforeach
    @endforeach
    @error('correcte')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

{{-- Vrai/faux : l'administrateur indique si l'affirmation est vraie ou fausse --}}
<div id="bloc-vrai-faux" class="mb-3 d-none">
    <label class="form-label">L'affirmation est : *</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="correcte_vf" id="vf-vrai" value="vrai" @checked($vraiFaux === 'vrai')>
        <label class="form-check-label" for="vf-vrai">Vraie</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="correcte_vf" id="vf-faux" value="faux" @checked($vraiFaux === 'faux')>
        <label class="form-check-label" for="vf-faux">Fausse</label>
    </div>
    @error('correcte_vf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="explication" class="form-label">Explication de la correction <span class="text-muted small">(facultatif)</span></label>
    <textarea id="explication" name="explication" rows="2"
              class="form-control @error('explication') is-invalid @enderror">{{ old('explication', $question->explication) }}</textarea>
    @error('explication')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Affichée à l'étudiant dans la correction.</div>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ route('admin.quiz.show', $quiz) }}" class="btn btn-outline-secondary">Annuler</a>
</div>

<template id="modele-reponse">
    <div class="input-group mb-2 ligne-reponse">
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="correcte" value="__CLE__" title="Bonne réponse">
        </div>
        <input type="text" name="reponses[__CLE__]" value="" maxlength="255"
               class="form-control" placeholder="Libellé de la réponse">
        <button type="button" class="btn btn-outline-danger supprimer-reponse" title="Supprimer cette réponse">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</template>

@push('scripts')
    <script src="{{ asset('js/question-form.js') }}"></script>
@endpush
