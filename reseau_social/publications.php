<?php

session_start();
include_once "db.php";








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



?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Mon profil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap">
  <link rel="stylesheet" href="includes/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" href="includes/bootstrap/mdb.min.css" />
  <link rel="stylesheet" href="includes/bootstrap/style.css">

</head>

<body style="background-color: #efefef ; ">



  <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="navbar-brand mt-2 mt-lg-0" href="#">
          <img src="includes/img/books.png" height="40" alt="MDB Logo" loading="lazy" />
        </a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Acceuil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="publications.php">Mes publications</a>
          </li>
        </ul>
      </div>

      <div class="d-flex align-items-center">

        <div class=" d-flex dropdown">
          <?php echo $email; ?>

          <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar"
            role="button" data-mdb-toggle="dropdown" aria-expanded="false" style="padding-right:10px;">


            <img src="<?php echo "includes/img/" . $row['profil']; ?>" class="rounded-circle" height="30" width="30"
              alt="..." loading="lazy" style="margin-left:10px;" />
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
            <li>
              <a class="dropdown-item" href="#">Mon profil</a>
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


      <div class="col-md-4 sfjhe">
        <br>
        <div class=" sjfsj">
          <br>
          <img src="<?php echo "includes/img/" . $row['profil']; ?>" alt=""
            style="widht: 150px; height:150px; border-radius: 50%;">
          <h5 class="text-center pt-3">
            <?php echo $row['nom'] ?>
            <?php echo $row['prenom'] ?>
          </h5>
          <hr>

          <div class="text-center">



          
            <a href="modification_profil.php?id=<?php echo $row['idu'] ?>">
            <button type="button" class="btn btn-primary" >
              Modifier le profil
            </button>
            </a>

            



          </div>



        </div>
      </div>


      <div class="col-md-6" style="justify-content-center">


        <?php
        $idu = $_SESSION['idu'];
        $req = "SELECT p.*,u.* FROM utilisateurs u INNER JOIN posts p ON u.idu = p.idu WHERE u.idu = $idu ORDER BY p.idu DESC";
        $result = mysqli_query($conn, $req);
        if ($result) {



          if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
              $postId = $row['idp'];
              $likesSql = "SELECT COUNT(*) AS total_likes FROM likes WHERE idp = '$postId'";
              $likesResult = mysqli_query($conn, $likesSql);
              $likesRow = mysqli_fetch_assoc($likesResult);
              $totalLikes = $likesRow['total_likes'];
               ?>
              <div class="box1">
                <div class="d-flex skfjkk">
                  <div class="lkt40">
                    <img src=" <?php echo "includes/img/" . $row['profil']; ?>" alt="" width="30" height="30">
                  </div>
                  <div class="pl-2 pt-2">
                    <h6 style="padding-left: 15px">

                      <?php echo $row["nom"] ?>
                      <?php echo $row["prenom"] ?>

                    </h6>
                  </div>
                </div>

                <br>

                <div class="ratio ratio-16x9">
                  <img src="<?php echo "includes/img/" . $row['media'] ?>" class="card-img-top">
                </div>
                <hr>
                <p class="text-muted">
                  <?php echo $row["post"] ?>
                </p>
                <hr>
                <div>

                </div>
                <div>

                </div>
                <div class="d-flex justify-content-around">
                  <div>
                  <button class="btn btn-like" data-post-id="<?php echo $postId; ?>">
                      <i class="fa fa-heart"></i>
                      <?php echo $totalLikes; ?>
                      J'aime
                    </button>
                  </div>
                  <div>
                    <button class="btn">
                      <i class="fa fa-comment"></i>
                      Commenter
                    </button>
                  </div>

                  <div>
                    <button class="btn">
                      <i class="fa fa-share"></i>
                      Partager
                    </button>
                  </div>
                </div>
              </div>
              <br>
              <?php
            }
          }
        } ?>





      </div>
    </div>
  </div>







  <script src="includes/bootstrap/mdb.min.js"></script>
  <script src="includes/bootstrap/bootstrap.min.js"></script>
</body>

</html>