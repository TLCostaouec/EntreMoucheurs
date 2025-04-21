<?php

/**
*	Controleur : création de spot
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/spotModel.php';
require_once ROOT . '/app/models/mediaModel.php';

requireLogin();

$nameError = $descriptionError = $departmentError = $creditError = $coordsError = $imageError = null;

// traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $credit = trim($_POST['credit'] ?? '');

    $valid = true;

    // nom du spot
    if (empty($name)) {
        $nameError = "Le nom du spot est requis.";
        $valid = false;
    } elseif (mb_strlen($name) > 26) {
        $nameError = "Le nom du spot doit faire 26 caractères maximum.";
        $valid = false;
    } elseif (spotNameExists($name)) {
        $nameError = "Ce nom de spot est déjà utilisé.";
        $valid = false;
    }

    // description
    if (mb_strlen($description) > 500) {
        $valid = false;
        $descriptionError = "La description ne doit pas dépasser 500 caractères.";
    }

    // département
    if (empty($department)) {
        $departmentError = "Le département est requis.";
        $valid = false;
    } elseif (mb_strlen($department) > 25) {
        $departmentError = "Le nom du département ne doit pas dépasser 25 caractères.";
        $valid = false;
    }

    // crédit
    if (empty($credit)) {
        $creditError = "Le crédit photo est requis.";
        $valid = false;
    } elseif (mb_strlen($credit) > 50) {
        $creditError = "Le crédit photo ne doit pas dépasser 50 caractères.";
        $valid = false;
    }

    // coordonnées
    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        $coordsError = "Les coordonnées doivent être valides.";
        $valid = false;
    }

    // images

    /** 
    *   $_FILES['images'] = [
    *       'name' => ['photo1.jpg', 'photo2.jpg'],
    *       'type' => ['image/jpeg', 'image/png'],
    *       'tmp_name' => ['/tmp/php1234', '/tmp/php5678'],
    *       'error' => [0, 0],
    *       'size' => [312000, 456000]
    *   ];
    */
    $images = $_FILES['images'] ?? null; // $_FILES['images'] contient tous les fichiers uploadés dans ce champ
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp']; // correspond aux types MIME détectés automatiquement par PHP via $_FILES['images']['type']
    $maxSize = 500 * 1024; // 500 Ko max / 1024 = nbr d'octets dans 1 Ko

    if (!$images || empty($images['name'][0])) {
        $imageError = "Vous devez ajouter au moins une image.";
        $valid = false;
    } elseif (count($images['name']) > 3) {
        $imageError = "Vous ne pouvez ajouter que 3 images maximum.";
        $valid = false;
    } else {
        foreach ($images['tmp_name'] as $key => $tmpName) {
            $type = mime_content_type($tmpName);
            $size = $images['size'][$key];

            if (!in_array($type, $allowedTypes)) {
                $imageError = "Seuls les fichiers JPEG, PNG ou WebP sont autorisés.";
                $valid = false;
                break;
            }

            if ($size > $maxSize) {
                $imageError = "Chaque image doit faire moins de 500 Ko.";
                $valid = false;
                break;
            }

            // vérifie si le fichier est bien une image grâce à la signature d'image
            if (!in_array(@exif_imagetype($tmpName), [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP])) {
                $imageError = "Un des fichiers n'est pas une image valide";
                $valid = false;
                break;
            }
        }
    }

    if ($valid) {
        try {

            // création du spot
            $userId = $_SESSION['user_id'];
            $spotId = createSpot($name, $description, $department, $latitude, $longitude, $userId);

            // gestion images
            foreach ($images['tmp_name'] as $key => $tmpName) {
                $extension = pathinfo($images['name'][$key], PATHINFO_EXTENSION); // pathinfo() permet d'extraire des infos via le chemin d'un fichier. PATHINFO_EXTENSION extrait uniquement l'extension, ex: .jpg
                $filename = uniqid('spot_', true) . '.' . $extension; // uniquid génère un identifiant unique qui commence par spot_ et true affine en ajoutant des microsecondes
                $destination = ROOT . '/public/assets/uploads/' . $filename;

                // déplacement du fichier temporaire vers le dossier uploads
                move_uploaded_file($tmpName, $destination);

                addMedia($filename, $credit, $spotId);
            }

            // message + redirection
            $_SESSION['success_create'] = "Votre spot a bien été ajouté.";
            header('Location: spot');
            exit;

        } catch (Exception $e) {
            $imageError = "Une erreur est survenue lors de l'enregistrement du spot.";
        }
    }
}

?>