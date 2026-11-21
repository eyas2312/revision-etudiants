<div class="mb-3">
    <label for="titre" class="form-label">Titre du quiz *</label>
    <input type="text" id="titre" name="titre" value="{{ old('titre', $quiz->titre) }}" maxlength="255" required
           class="form-control @error('titre') is-invalid @enderror">
    @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ $retour }}" class="btn btn-outline-secondary">Annuler</a>
</div>
