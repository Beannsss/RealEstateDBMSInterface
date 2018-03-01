<?php

include('testconfig.php');

function get($key) {
    if(isset($_GET[$key])) {
        return $_GET[$key];
    }

    else {
        return '';
    }
}
function isAdmin($dbh)
{
    $sql = "SELECT *
       FROM LOGIN
       WHERE
	   userID = :userid";
    $params = array(
        'userID' => $_SESSION['USERID']
    );
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    $users = $statement->fetchall(PDO::FETCH_ASSOC);
    $user = $users[0];

    if($user['STATUS'] > 0)
        return true;
    else
        return false;
}