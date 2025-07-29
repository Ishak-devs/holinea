<?php
require_once 'Models/Model.php';

class Controller_therapeute extends Controller
{
    public function action_default()
    {
        $this->action_signup();
    }

    public function action_signup()
    {
        $this->render("signup", ["title" => "Création de compte Thérapeute"]);
    }

    public function action_checkSignup()
    {
        // Vérification des champs obligatoires
        $required = [
            'email', 'password', 'nom', 'prenom', 'diplomes', 
            'annees_experience', 'heures_pratique', 'specialites', 'consentement_cgu'
        ];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $this->render("signup", [
                    "title" => "Création de compte Thérapeute",
                    "error" => "Veuillez remplir tous les champs obligatoires."
                ]);
                return;
            }
        }

        // Récupération des données
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $telephone = trim($_POST['telephone'] ?? null);
        $mode_consultation = $_POST['mode_consultation'] ?? null;
        $adresse_cabinet = trim($_POST['adresse_cabinet'] ?? null);
        $diplomes = trim($_POST['diplomes']);
        $annees_experience = intval($_POST['annees_experience']);
        $heures_pratique = intval($_POST['heures_pratique']);
        $specialites = trim($_POST['specialites']);
        $tarifs_consultation = isset($_POST['tarifs_consultation']) ? floatval($_POST['tarifs_consultation']) : null;
        $description = trim($_POST['description'] ?? '');
        $consentement_cgu = isset($_POST['consentement_cgu']) ? 1 : 0;
        $consentement_partage_donnees = isset($_POST['consentement_partage_donnees']) ? 1 : 0;

        // Gestion de la photo de profil
        $photo_profil_url = null;
        if (!empty($_FILES['photo_profil']['name'])) {
            $uploadDir = "Uploads/photos/";
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
            $fileName = uniqid()."_".basename($_FILES['photo_profil']['name']);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $targetFile)) {
                $photo_profil_url = $targetFile;
            }
        }

        $model = Model::getModel();

        // Vérifie si l'email existe déjà
        if ($model->getUserByEmail($email)) {
            $this->render("signup", [
                "title" => "Création de compte Thérapeute",
                "error" => "Un compte avec cet email existe déjà."
            ]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($telephone === "" || !is_numeric($telephone)) {
            $telephone = null;
        }
        // Création du compte utilisateur (rôle = 'therapeute')
        $userId = $model->insertUser(
    $nom, $prenom, $email, $hashedPassword, 'therapeute', $telephone,
    $consentement_cgu == 1 || $consentement_cgu === true,  // true ou false
    $consentement_partage_donnees == 1 || $consentement_partage_donnees === true
);


        // Insertion dans la table PRATICIEN (profil thérapeute)
        $success = $model->insertPraticien([
            'mode_consultation'       => $mode_consultation,
            'adresse_cabinet'         => $adresse_cabinet,
            'diplomes'                => $diplomes,
            'nombre_heures_pratique'  => $heures_pratique,           // AJOUT IMPORTANT
            'description'             => $description,
            'annees_experience'       => $annees_experience,
            'tarifs_consultation'      => $tarifs_consultation,       // ATTENTION AU NOM !
            'photo_profil_url'        => $photo_profil_url,
            'Id_Utilisateur'          => $userId
        ]);
        

        // (Optionnel) Gérer les spécialités associées via table a_la_spécialité

        if ($success) {
            
            header("Location: ?controller=connection&action=login");
            exit;
        } else {
            $this->render("signup", [
                "title" => "Création de compte Thérapeute",
                "error" => "Erreur lors de l'enregistrement du profil thérapeute."
            ]);
        }
    }
}
