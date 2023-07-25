<!DOCTYPE html>
<html>
<head>
    <title>Cabinet Médical</title>
</head>
<body>
    <h1>Cabinet Médical</h1>

    <?php
    // Connexion à la base de données
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "cabinet_medical";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    // Fonction pour lister les patients
    function listerPatients($conn) {
        $sql = "SELECT * FROM patient";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Liste des patients</h2>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . $row["numPatient"] . " - " . $row["nomComplet"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun patient trouvé.";
        }
    }

    // Fonction pour ajouter un patient
    function ajouterPatient($conn, $numPatient, $nomComplet) {
        $sql = "INSERT INTO patient (numPatient, nomComplet) VALUES ('$numPatient', '$nomComplet')";
        if (mysqli_query($conn, $sql)) {
            echo "Patient ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du patient : " . mysqli_error($conn);
        }
    }

    // Fonction pour modifier un patient
    function modifierPatient($conn, $numPatient, $nomComplet) {
        $sql = "UPDATE patient SET nomComplet = '$nomComplet' WHERE numPatient = '$numPatient'";
        if (mysqli_query($conn, $sql)) {
            echo "Patient modifié avec succès.";
        } else {
            echo "Erreur lors de la modification du patient : " . mysqli_error($conn);
        }
    }

    // Fonction pour supprimer un patient
    function supprimerPatient($conn, $numPatient) {
        $sql = "DELETE FROM patient WHERE numPatient = '$numPatient'";
        if (mysqli_query($conn, $sql)) {
            echo "Patient supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du patient : " . mysqli_error($conn);
        }
    }

    // Fonction pour enregistrer un rendez-vous
    function enregistrerRendezVous($conn, $date, $etat) {
        $sql = "INSERT INTO rendez_vous (date, etat) VALUES ('$date', '$etat')";
        if (mysqli_query($conn, $sql)) {
            echo "Rendez-vous enregistré avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement du rendez-vous : " . mysqli_error($conn);
        }
    }

    // Fonction pour lister les rendez-vous
    function listerRendezVous($conn) {
        $sql = "SELECT * FROM rendez_vous";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Liste des rendez-vous</h2>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>Date: " . $row["date"] . ", État: " . $row["etat"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun rendez-vous trouvé.";
        }
    }

    // Vérifier si un formulaire a été soumis pour ajouter/modifier/supprimer un patient
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'ajouter') {
            $numPatient = $_POST['numPatient'];
            $nomComplet = $_POST['nomComplet'];
            ajouterPatient($conn, $numPatient, $nomComplet);
        } elseif ($action === 'modifier') {
            $numPatient = $_POST['numPatient'];
            $nomComplet = $_POST['nomComplet'];
            modifierPatient($conn, $numPatient, $nomComplet);
        } elseif ($action === 'supprimer') {
            $numPatient = $_POST['numPatient'];
            supprimerPatient($conn, $numPatient);
        } elseif ($action === 'enregistrerRendezVous') {
            $date = $_POST['date'];
            $etat = $_POST['etat'];
            enregistrerRendezVous($conn, $date, $etat);
        }
    }

    // Afficher la liste des patients
    listerPatients($conn);

    // Afficher la liste des rendez-vous
    listerRendezVous($conn);

    // Fermer la connexion à la base de données
    mysqli_close($conn);
    ?>

    <h2>Ajouter un nouveau patient</h2>
    <form method="post">
        <input type="hidden" name="action" value="ajouter">
        <label>Numéro du patient:</label>
        <input type="text" name="numPatient" required>
        <br>
        <label>Nom complet du patient:</label>
        <input type="text" name="nomComplet" required>
        <br>
        <input type="submit" value="Ajouter">
    </form>

    <h2>Modifier un patient</h2>
    <form method="post">
        <input type="hidden" name="action" value="modifier">
        <label>Numéro du patient à modifier:</label>
        <input type="text" name="numPatient" required>
        <br>
        <label>Nouveau nom complet:</label>
        <input type="text" name="nomComplet" required>
        <br>
        <input type="submit" value="Modifier">
    </form>

    <h2>Supprimer un patient</h2>
    <form method="post">
        <input type="hidden" name="action" value="supprimer">
        <label>Numéro du patient à supprimer:</label>
        <input type="text" name="numPatient" required>
        <br>
        <input type="submit" value="Supprimer">
    </form>

    <h2>Enregistrer un nouveau rendez-vous</h2>
    <form method="post">
        <input type="hidden" name="action" value="enregistrerRendezVous">
        <label>Date du rendez-vous:</label>
        <input type="text" name="date" required>
        <br>
        <label>État du rendez-vous:</label>
        <input type="text" name="etat" required>
        <br>
        <input type="submit" value="Enregistrer Rendez-vous">
    </form>

</body>
</html>
