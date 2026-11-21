<div class="mb-3">
    <label for="titre" class="form-label">Titre du chapitre *</label>
    <input type="text" id="titre" name="titre" value="{{ old('titre', $chapitre->titre) }}" maxlength="255" required
           class="form-control @error('titre') is-invalid @enderror">
    @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="ordre" class="form-label">Ordre dans la matière</label>
    <input type="number" id="ordre" name="ordre" value="{{ old('ordre', $chapitre->ordre) }}" min="1" max="65535"
           class="form-control @error('ordre') is-invalid @enderror">
    @error('ordre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ $retour }}" class="btn btn-outline-secondary">Annuler</a>
</div>
