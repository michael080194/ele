<?php
//PUT THIS HEADER ON TOP OF EACH UNIQUE PAGE
// session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}
