<?php
require("db-conn.php");

$imageID = $_POST["rated-image-id"];
$ratingUser = $_POST["rating-user"];

if(isset($_POST["create-btn"])) {
    if(empty($_POST["rating"])) {
        header("Location: ../image.php?id=" . $imageID . "&error=emptyfields");
        exit();
    }

    $rating = $_POST["rating"];

    $sql= 'INSERT INTO PHOTORATING (PHOTOID, RATINGUSERID, RATING) VALUES (:imageID, :ratingUser, :rating)';
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt,':imageID',$imageID);
    oci_bind_by_name($stmt,':ratingUser',$ratingUser);
    oci_bind_by_name($stmt,':rating',$rating);


    oci_execute($stmt);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    } else {
        oci_free_statement($stmt);
        header("Location: ../image.php?id=" . $imageID . "&photorating=success");
        exit();
    }
} else {
    echo 'Hozzáférés megtagadva!';
}
