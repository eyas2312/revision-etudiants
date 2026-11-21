<div class="mb-3">
    <label for="titre" class="form-label">Titre du cours *</label>
    <input type="text" id="titre" name="titre" value="{{ old('titre', $cours->titre) }}" maxlength="255" required
           class="form-control @error('titre') is-invalid @enderror">
    @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="contenu" class="form-label">Contenu du cours *</label>
    <textarea id="contenu" name="contenu" rows="14" required
              class="form-control @error('contenu') is-invalid @enderror">{{ old('contenu', $cours->contenu) }}</textarea>
    @error('contenu')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Texte simple : les sauts de ligne sont conservés à l'affichage.</div>
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ $retour }}" class="btn btn-outline-secondary">Annuler</a>
</div>
