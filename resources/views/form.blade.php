<div class="mb-4">
    <label class="form-label">Ajouter à une liste</label>
    <input type="text" name="list" value="{{ old('list', optional($subscriber)->list) }}" class="form-control">
</div>
<div class="mb-4">
    <label class="form-label">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', optional($subscriber)->nom) }}" class="form-control">
</div>

<div class="mb-4">
    <label class="form-label">Prénom</label>
    <input type="text" name="prenom" value="{{ old('prenom', optional($subscriber)->prenom) }}" class="form-control">
</div>

<div class="mb-4">
    <label class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('email', optional($subscriber)->email) }}" class="form-control" required>
</div>

<div class="mb-4">
    <label class="form-label">Téléphone</label>
    <input type="tel" name="phone" value="{{ old('phone', optional($subscriber)->phone) }}" class="form-control">
</div>
