<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "./Content/credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
   
    public function insertPraticien($data) {
        $sql = "INSERT INTO praticien (
                    mode_consultation, adresse_cabinet, diplomes, nombre_heures_pratique, description,
                    annees_experience, tarifs_consultation, photo_profil_url, taux_satisfaction, statut_validation, Id_Utilisateur
                ) VALUES (
                    :mode_consultation, :adresse_cabinet, :diplomes, :nombre_heures_pratique, :description,
                    :annees_experience, :tarifs_consultation, :photo_profil_url, NULL, 'en attente', :Id_Utilisateur
                )";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':mode_consultation', $data['mode_consultation']);
        $stmt->bindParam(':adresse_cabinet', $data['adresse_cabinet']);
        $stmt->bindParam(':diplomes', $data['diplomes']);
        $stmt->bindParam(':nombre_heures_pratique', $data['nombre_heures_pratique']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':annees_experience', $data['annees_experience']);
        $stmt->bindParam(':tarifs_consultation', $data['tarifs_consultation']);
        $stmt->bindParam(':photo_profil_url', $data['photo_profil_url']);
        $stmt->bindParam(':Id_Utilisateur', $data['Id_Utilisateur']);
        $success = $stmt->execute();

        if (!$success) {
            $error = $stmt->errorInfo();
            error_log(print_r($error, true)); // Pour voir l'erreur dans les logs
            // echo "<pre>"; print_r($error); echo "</pre>"; // Pour debug à l'écran
        }

        return $success;
    }
    

    public function getUserByEmail($email) {
        $stmt = $this->bd->prepare("SELECT * FROM utilisateur WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function insertUser($nom, $prenom, $email, $hashedPassword, $role = 'therapeute', $telephone = null, $consentement_cgu = true, $consentement_partage = false) {
        $sql = "INSERT INTO utilisateur (
                    mail, nom, prenom, date_inscription, derniere_connexion,
                    role_utilisateur, statut_compte, mot_de_passe,
                    consentement_cgu, consentement_partage_donnees_sante_,
                    telephone_
                )
                VALUES (
                    :mail, :nom, :prenom, CURRENT_DATE, NOW(),
                    :role_utilisateur, 'actif', :mot_de_passe,
                    :consentement_cgu, :consentement_partage_donnees_sante_,
                    :telephone_
                )";
                
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':role_utilisateur', $role);
        $stmt->bindParam(':mot_de_passe', $hashedPassword);
        $stmt->bindParam(':consentement_cgu', $consentement_cgu, PDO::PARAM_BOOL);
        $stmt->bindParam(':consentement_partage_donnees_sante_', $consentement_partage, PDO::PARAM_BOOL);
        $stmt->bindParam(':telephone_', $telephone, $telephone !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

        if ($stmt->execute()) {
            return $this->bd->lastInsertId();
        } else {
            return false;
        }
    }
    public function getByEmail($mail) {
     
        $stmt = $this->bd->prepare("SELECT * FROM utilisateur WHERE mail = :mail");
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne le tableau utilisateur ou false si inexistant
    }
    
    public function getUserById($id)
{
    $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
    $stmt = $this->bd->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}
