<?php

include('testconfig.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT *
       FROM LOGIN
       WHERE
	   username = :username AND
       password = :password";
    $params = array(
        'username' => $user,
        'password' => $password
    );
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    $users = $statement->fetchall(PDO::FETCH_ASSOC);
    if (!empty($users)) {
        $user = $users[0];
        print_r($user);
        echo htmlspecialchars($user['USERID']);
        $_SESSION['USERID'] = $user['USERID'];
        echo $_SESSION['USERID'];
        header("Location: testindex.php");
    }
}
?>
    <head>
	<meta charset="utf-8">

  	<title>Login</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style(1).css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Login</h1>
		<form method="POST">
			<input type="text" name="username" placeholder="Username" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" value="Log In" />
		</form>
	</div>
</body>
</html>