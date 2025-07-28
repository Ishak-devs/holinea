<?php
    require "view_begin.php";
?>
<div class="container" style="max-width:480px;margin:50px auto;">
  <h2>Créer un compte HoliHealth</h2>
  <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>
  <form method="post" action="?page=inscription">
    <label>Nom</label>
    <input type="text" name="nom" required>
    <label>Prénom</label>
    <input type="text" name="prenom" required>
    <label>Email</label>
    <input type="email" name="mail" required>
    <label>Mot de passe</label>
    <input type="password" name="mot_de_passe" required>
    <label>
      <input type="checkbox" name="cgu" required>
      J'accepte les <a href="#">CGU</a>
    </label>
    <button type="submit" class="btn">S'inscrire</button>
  </form>
  <p>Déjà inscrit ? <a href="?page=connexion">Connexion</a></p>
</div>

<?php
    require "view_end.php";
?>