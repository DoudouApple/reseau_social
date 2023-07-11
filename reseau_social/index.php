<?php

session_start();
include_once "db.php";


// Publier
if (isset($_POST['publier'])) {
  if (empty($_FILES['media']['name']) || empty($_POST['post'])) {
    $error_message = "Veuillez remplir tous les champs.";
  } else {

    $media = ($_FILES['media']['name']);
    $post = $_POST['post'];
    $idu = $_SESSION["idu"];
    $profil = $_SESSION["profil"];

    $target_dir = "includes/img/";
    $target_file = $target_dir . basename($_FILES["media"]["name"]);

    $mediaFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'webp');

    if (!in_array($mediaFileType, $allowedTypes)) {
      $error_message = "Le fichier doit être une image (JPG, JPEG, PNG, GIF,WEBP) ou une vidéo (MP4).";
    } else {
      if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO posts (idu, media, post) VALUES ('$idu', '$media', '$post')";

        if (mysqli_query($conn, $sql)) {
          echo "Publication enregistrée avec succès.";
          header("location:index.php");
        } else {
          echo "Erreur lors de l'enregistrement de la publication : " . mysqli_error($conn);
        }
      } else {
        echo "Erreur lors du téléchargement du fichier.";
      }
    }
  }
}


// SESSION
if (isset($_SESSION["email"])) {

  $email = $_SESSION["email"];
  $idu = $_SESSION['idu'];
  $profil = $_SESSION['profil'];



  $sql = "SELECT * FROM utilisateurs WHERE idu = $idu";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $idu = $row['idu'];
    $profil = $row['profil'];



  } else {
    header("Location: conn_insc.php");
    exit();
  }
}

// Logout
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
  <title>Index</title>
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

          <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar"
            role="button" data-mdb-toggle="dropdown" aria-expanded="false" style="padding-right:10px;">


            <img src="<?php echo "includes/img/" . $row['profil']; ?>" class="rounded-circle" height="30" width="30"
              alt="..." loading="lazy" style="margin-left:10px;" />
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

      <div class="col-md-4 sfjhe">
        <div class=" sjfsj">
          <img src="<?php echo "includes/img/" . $row['profil']; ?>" alt=""
            style="widht: 150px; height:150px; border-radius: 50%;">
          <h5 class="text-center pt-3">
            <?php echo $row['nom']; ?>
          </h5>
          <p class="text-muted text-center">
            <?php echo $row['prenom']; ?>
          </p>
          <hr>

          <div class="text-center">
            <a href="publications.php" class="font-weight-bold text-decoration-none text-center">
            <button class="btn btn-primary">

              Mon profil
            </button>
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-6" style="justify-content-center">
        <div class="jfheuf  ">
          <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#publicationModal">
              Faire une publication
            </button>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="publicationModal" tabindex="-1" aria-labelledby="publicationModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="publicationModalLabel">Nouvelle publication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="fileInput" class="form-label">Choisir un fichier</label>
                    <input type="file" class="form-control" id="fileInput" name="media" accept="image/*, video/*">
                  </div>
                  <div class="mb-3">
                    <label for="postDetails" class="form-label">Détails du post</label>
                    <textarea class="form-control" id="postDetails" name="post" rows="3"
                      placeholder="Entrez les détails de votre post"></textarea>
                  </div>
                  <button type="submit" name="publier" class="btn btn-primary">Publier</button>
                </form>
              </div>
            </div>
          </div>
        </div>



        <?php

        $sql = "SELECT p.*,u.*
        FROM utilisateurs u
        INNER JOIN posts p ON u.idu = p.idu
        WHERE u.idu = p.idu ORDER BY p.idu DESC";


        $result = mysqli_query($conn, $sql);
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $(".btn-like").click(function () {
        // Récupérer l'ID du post
        var postId = $(this).data("post-id");
        // Récupérer l'élément bouton cliqué
        var likeButton = $(this);

        // Envoyer une requête AJAX pour ajouter/supprimer un like
        $.ajax({
          url: "ajouter_like.php",
          type: "POST",
          data: {
            postId: postId
          },
          success: function (response) {
            if (response === "liked") {
              // L'utilisateur a aimé le post
              likeButton.addClass("liked");
            } else if (response === "unliked") {
              // L'utilisateur a annulé son j'aime
              likeButton.removeClass("liked");
            }
          }
        });
      });
    });
  </script>

</body>

</html>