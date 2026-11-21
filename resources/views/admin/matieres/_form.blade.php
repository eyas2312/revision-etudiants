<div class="mb-3">
    <label for="nom" class="form-label">Nom de la matière *</label>
    <input type="text" id="nom" name="nom" value="{{ old('nom', $matiere->nom) }}" maxlength="150" required
           class="form-control @error('nom') is-invalid @enderror">
    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $matiere->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ route('admin.matieres.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>
