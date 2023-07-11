<?php

session_start();

include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $postId = $_POST['postId'];

  $userId = $_SESSION['idu'];
  $checkSql = "SELECT * FROM likes WHERE idp = '$postId' AND idu = '$userId'";
  $checkResult = mysqli_query($conn, $checkSql);

  if (mysqli_num_rows($checkResult) === 0) {

    $insertSql = "INSERT INTO likes (idu, idp) VALUES ('$userId', '$postId')";
    if (mysqli_query($conn, $insertSql)) {
      echo "liked";
    } else {
      echo "error";
    }
  } else {

    $deleteSql = "DELETE FROM likes WHERE idu = '$userId' AND idp = '$postId'";
    if (mysqli_query($conn, $deleteSql)) {
      echo "unliked";
    } else {
      echo "error";
    }
  }
} else {
  echo "invalid_request";
}
?>
