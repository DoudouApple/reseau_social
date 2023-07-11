<?php
session_start();

include_once "db.php";


if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['passwd'];


  $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";


  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['passwd'])) {

      $_SESSION['email'] = $row['email'];
      $_SESSION['idu'] = $row['idu'];
      $_SESSION['profil'] = $row['profil'];


      header("Location: index.php");
      exit();
    } else {

      echo "Identifiants de connexion invalides.";
    }
  } else {

    echo "Identifiants de connexion invalides.";
  }
}



if (isset($_POST['register'])) {
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $password = $_POST['passwd'];
  $profil = $_FILES['profil']['name']; // Chemin temporaire du fichier téléchargé
  $destination = "./includes/img".$profil; // Lire les données de l'image
  move_uploaded_file($_FILES['profil']['name'],$destination);
 


  $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    
    echo "Cet email est déjà utilisé. Veuillez en choisir un autre.";
  } else {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO utilisateurs (nom, prenom, email, passwd, profil) VALUES ('$nom', '$prenom', '$email', '$hashedPassword','$profil')";


    if (mysqli_query($conn, $sql)) {
      echo "Compte créé avec succès.";
    } else {
      echo "Erreur lors de la création du compte : " . mysqli_error($conn);
    }
  }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Material Design for Bootstrap</title>

  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap">
  <link rel="stylesheet" href="includes/bootstrap/mdb.min.css" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container">
      <!-- Navbar brand -->
      <a class="navbar-brand me-2" href="https://mdbgo.com/">
        <img src="includes/img/books.png" height="40" alt="..." loading="lazy" style="margin-top: -1px;" />
      </a>
      <a class="navbar-brand me-2" href="#">Reseau social</a>

      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample"
        aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarButtonsExample">
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">

          </li>
        </ul>
        <!-- Left links -->

        <div class="d-flex align-items-center">
          <button type="button" class="btn btn-link px-3 me-2">
            Se connecter
          </button>
          <button type="button" class="btn btn-primary me-3">
            S'inscrire
          </button>

        </div>
      </div>
      <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
  <br><br>





  <div class="container">
    <div class="card">

      <!-- Pills navs -->
      <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="#pills-login" role="tab"
            aria-controls="pills-login" aria-selected="true">Se connecter</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="#pills-register" role="tab"
            aria-controls="pills-register" aria-selected="false">S'inscrire</a>
        </li>
      </ul>
      <!-- Pills navs -->






      <!-- Pills content -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
          <form action="" method="post">
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="loginName" class="form-control" name="email" />
              <label class="form-label" for="loginName">Email</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="loginPassword" class="form-control" name="passwd" />
              <label class="form-label" for="loginPassword">Mot de passe</label>
            </div>

            <!-- 2 column grid layout -->
            <div class="row mb-4">
              <div class="col-md-6 d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check mb-3 mb-md-0">
                  <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked />
                  <label class="form-check-label" for="loginCheck"> Se rappeler de moi ? </label>
                </div>
              </div>

            </div>

            <!-- Submit button -->
            <button type="submit" name="login" class="btn btn-primary btn-block mb-4">Se connecter</button>

            <!-- Register buttons -->
            <div class="text-center">
              <p>Pas de compte? <a href="#">S'inscrire</a></p>
            </div>
          </form>
        </div>






        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
          <form action="" method="post" enctype="multipart/form-data">

            <!-- Name input -->
            <div class="form-outline mb-4">
              <input type="text" id="registerName" class="form-control" name="nom" />
              <label class="form-label" for="registerName">Nom</label>
            </div>

            <!-- Username input -->
            <div class="form-outline mb-4">
              <input type="text" id="registerUsername" class="form-control" name="prenom" />
              <label class="form-label" for="registerUsername">Prenom</label>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="registerEmail" class="form-control" name="email" />
              <label class="form-label" for="registerEmail">Email</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="registerPassword" class="form-control" name="passwd" />
              <label class="form-label" for="registerPassword">Mot de passe</label>
            </div>

            <div class="form-group mb-4">
              <label for="fileInput" class="form-label">Photo de profil</label>
              <input type="file" class="form-control" id="fileInput" name="profil" accept="image/*, video/*">
            </div>


            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-center mb-4">
              <input class="form-check-input me-2" type="checkbox" value="" id="registerCheck" checked
                aria-describedby="registerCheckHelpText" />
              <label class="form-check-label" for="registerCheck">
                I have read and agree to the terms
              </label>
            </div>

            <!-- Submit button -->
            <button type="submit" name="register" class="btn btn-primary btn-block mb-3">S'inscrire</button>
          </form>
        </div>
      </div>
      <!-- Pills content -->
    </div>
  </div>

  <script type="text/javascript" src="includes/bootstrap/mdb.min.js"></script>

</body>

</html>