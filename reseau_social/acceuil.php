<?php

session_start();
include_once "db.php";




// SESSION
if (isset($_SESSION["email"])) {

    $email = $_SESSION["email"];
    $idu = $_SESSION['idu'];
    $profil = $_SESSION['profil'];



    $sql = "SELECT * FROM utilisateurs";
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


    header("Location: conn_insc.php");
    exit();
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Acceuil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="includes/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="includes/bootstrap/mdb.min.css" />
    <link rel="stylesheet" href="includes/bootstrap/style.css">
</head>

<body style="background-color: #efefef ; ">



    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand me-2" href="https://mdbgo.com/">
                <img src="includes/img/books.png" height="40" alt="..." loading="lazy" style="margin-top: -1px;" />
            </a>
            <a class="navbar-brand me-2" href="#">Reseau social</a>

            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">

                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <a type="button" class="btn btn-link px-3 me-2" href="conn_insc.php">

                        Se connecter
                    </a>
                    <a type="button" class="btn btn-primary me-3" href="conn_insc.php">
                        S'inscrire
                    </a>

                </div>
            </div>
        </div>
    </nav>
    <br><br>




    <div class="container jsjhr">
        <div class="row skfjh justify-content-center">



            <div class="col-md-6" style="justify-content-center">







                <?php
                $sql = "SELECT p.*,u.* FROM utilisateurs u INNER JOIN posts p ON u.idu = p.idu WHERE u.idu = p.idu ORDER BY p.idu DESC";


                $result = mysqli_query($conn, $sql);
                if ($result) {



                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) { ?>
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