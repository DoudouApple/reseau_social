<?php

session_start();
include_once "db.php";





$id = $_GET['id'];


// SESSION
if (isset($_SESSION["email"])) {


    $email = $_SESSION["email"];
    $idu = $_SESSION['idu'];
    $profil = $_SESSION['profil'];



    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'  ";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $idu = $row['idu'];
        $profil = $row['profil'];



    } else {
        header("Location: acceuil.php");
        exit();
    }
}

// Deconnexion
if (isset($_GET['logout'])) {

    session_destroy();


    header("Location: acceuil.php");
    exit();
}

$idu = $_SESSION['idu'];

// Récupérer les informations actuelles du profil
$selSql = "SELECT * FROM utilisateurs WHERE idu = $idu";
$resultat = mysqli_query($conn, $selSql);
$row = mysqli_fetch_assoc($resultat);

if (isset($_POST['confirmer'])) {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $passwd = mysqli_real_escape_string($conn, $_POST['passwd']);

    // Hasher le mot de passe si nécessaire
     $hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);

    $updateSql = "UPDATE utilisateurs SET nom = '$nom', prenom = '$prenom', passwd = '$hashedPasswd' WHERE idu = $idu";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        // La mise à jour a réussi, rediriger vers une page de succès
        header("Location:publications.php");
        exit();
    } else {
        // La mise à jour a échoué, afficher un message d'erreur ou rediriger vers une page d'erreur
        echo "Une erreur s'est produite lors de la mise à jour du profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Modification du profil</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap">
        <link rel="stylesheet" href="includes/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="includes/bootstrap/mdb.min.css" />
        <link rel="stylesheet" href="includes/bootstrap/style.css">
    </head>
</head>

<body style="background-color: #efefef ; ">

    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img src="includes/img/books.png" height="40" alt="MDB Logo" loading="lazy" />
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Acceuil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="publications.php">Mes publications</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">

                <div class=" d-flex dropdown">
                    <?php echo $email; ?>

                    <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                        id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false"
                        style="padding-right:10px;">


                        <img src="<?php echo "includes/img/" . $row['profil']; ?>" class="rounded-circle" height="30"
                            width="30" alt="..." loading="lazy" style="margin-left:10px;" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li>
                            <a class="dropdown-item" href="publications.php">
                                Mon profil
                            </a>

                        </li>
                        <li>
                            <a class="dropdown-item" href="?logout=1">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </nav><br><br>





    <div class="container jsjhr">
        <div class="row skfjh justify-content-center">



            <div class="col-md-6" style="justify-content-center">
                <form  method="post">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <input type="text" id="form3Example1" class="form-control"
                                    value="<?php echo $row['nom']; ?>" name="nom" />
                                <label class="form-label" for="nom">Nom</label>
                            </div>
                        </div>


                        <div class="col">
                            <div class="form-outline">
                                <input type="text" id="form3Example2" class="form-control"
                                    value="<?php echo $row['prenom']; ?>" name="prenom" />
                                <label class="form-label" for="prenom">Prenom</label>
                            </div>
                        </div>
                    </div>




                    <div class="form-outline mb-4">
                        <input type="password" id="form3Example4" class="form-control"
                            value="<?php echo $row['passwd']; ?>" name="passwd" />
                        <label class="form-label" for="passwd">Mot de passe</label>
                    </div>

                    <button  type="submit" name="confirmer" class="btn btn-primary">Confirmer</button>



                </form>



            </div>
        </div>
    </div>

</body>
<script src="includes/bootstrap/mdb.min.js"></script>
<script src="includes/bootstrap/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>
