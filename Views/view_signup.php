<?php require "view_begin.php"; ?>
<div class="thera-container">
    <h1>Créer un compte <span style="color:#ffd447;">Thérapeute</span></h1>
    <?php if (isset($error)) : ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="?Controller=therapeute&action=checkSignup" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">Adresse e-mail *</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe *</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="double-fields">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone">
        </div>

        <div class="form-group">
            <label for="mode_consultation">Mode de consultation </label>
            <select id="mode_consultation" name="mode_consultation">
                <option value="">Sélectionnez</option>
                <option value="Présentiel">Présentiel</option>
                <option value="Visio">Visio</option>
                <option value="Mixte">Mixte</option>
            </select>
        </div>

        <div class="form-group">
            <label for="adresse_cabinet">Adresse du cabinet</label>
            <input type="text" id="adresse_cabinet" name="adresse_cabinet">
        </div>

        <div class="form-group">
            <label for="diplomes">Diplômes *</label>
            <input type="text" id="diplomes" name="diplomes" placeholder="ex : Master en sophrologie" required>
        </div>

        <div class="form-group">
            <label for="annees_experience">Années d'expérience *</label>
            <input type="number" id="annees_experience" name="annees_experience" min="0" max="60" required>
        </div>

        <div class="form-group">
            <label for="heures_pratique">Nombre d'heures de pratique *</label>
            <input type="number" id="heures_pratique" name="heures_pratique" placeholder="ex : 150" required>
        </div>

        <div class="form-group">
            <label for="specialites">Spécialités *</label>
            <input type="text" id="specialites" name="specialites" placeholder="ex : Sophrologie, Nutrition" required>
        </div>

        <div class="form-group">
            <label for="tarifs_consultation">Tarifs consultation (€)</label>
            <input type="number" id="tarifs_consultation" name="tarifs_consultation" step="0.01" min="0">
        </div>

        <div class="form-group">
            <label for="description">Description du praticien</label>
            <textarea id="description" name="description" rows="3" placeholder="Présentez-vous brièvement..."></textarea>
        </div>

        <div class="form-group">
            <label for="photo_profil">Photo de profil</label>
            <input type="file" id="photo_profil" name="photo_profil" accept="image/*">
        </div>

        <div class="form-group" style="margin: 14px 0 8px;">
            <input type="checkbox" id="consentement_cgu" name="consentement_cgu" required>
            <label for="consentement_cgu" style="display:inline;font-weight:400;">J'accepte les CGU et la politique de confidentialité *</label>
        </div>

        <div class="form-group">
            <input type="checkbox" id="consentement_partage_donnees" name="consentement_partage_donnees">
            <label for="consentement_partage_donnees" style="display:inline;font-weight:400;">J'accepte le partage de mes données de santé</label>
        </div>

        <div class="button-row" style="margin-top:18px;">
            <a href="?controller=connection&action=login" class="btn light">Déjà un compte ?</a>
            <button type="submit" class="btn dark">Créer mon compte</button>
        </div>
    </form>
</div>
<?php require "view_end.php"; ?>
