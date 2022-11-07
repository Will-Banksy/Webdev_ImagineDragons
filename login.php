<?php

// Return Status
// SUCCESS          - Success
// WRONG_USERNAME   - Incorrect Username
// WRONG_PASSWORD   - Incorrect Password
// AVAIL_USERNAME   - Available Username
// UNAVAIL_USERNAME - Unavailable Username
// NO_USERN_OR_PASS - Username or Password not provided
// DB_CONN_FAIL     - Connection to database failed
// USERN_TOO_LONG   - Username is too long (>=255 chars)

// ini_set("display_errors", 1);
// ini_set("display_startup_errors", 1);
// error_reporting(E_ALL);

if(isset($_COOKIE["PHPSESSID"])) {
	session_start();
}

$is_create_account = isset($_POST["create-account-username"]) && isset($_POST["create-account-password"]);
$is_login = isset($_POST["login-username"]) && isset($_POST["login-password"]);
$is_check_username = isset($_POST["check-username"]);

// Check for empty
if($is_create_account && (empty($_POST["create-account-username"]) || empty($_POST["create-account-password"]))) {
	die("NO_USERN_OR_PASS"); // Username or Password not provided
} else if($is_login && (empty($_POST["login-username"]) || empty($_POST["login-password"]))) {
	die("NO_USERN_OR_PASS"); // Username or Password not provided
} else if($is_check_username && empty($_POST["check-username"])) {
	die("NO_USERN_OR_PASS"); // Username or Password not provided
}

// Check for username length
if($is_create_account && strlen($_POST["create-account-username"]) >= 255) {
	die("USERN_TOO_LONG"); // Username is too long
} else if($is_login && strlen($_POST["login-username"]) >= 255) {
	die("USERN_TOO_LONG"); // Username is too long
} else if($is_check_username && strlen($_POST["check-username"]) >= 255) {
	die("USERN_TOO_LONG"); // Username is too long
}

// NEED SQL SERVER
$db_server = "";
$db_username = "";
$db_password = "";
$db_name = "";

if($is_create_account) {
	$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

	if(!$conn) {
		die("DB_CONN_FAIL"); // Connection to database failed | $conn->connect_error
	}

	$ca_username = $_POST["create-account-username"];
	$ca_password = $_POST["create-account-password"];
	$ca_username_esc = $conn->real_escape_string($ca_username); // Input sanitisation
	$ca_password_hash = password_hash($ca_password, PASSWORD_DEFAULT); // Hash should be sql safe

	$query = $conn->prepare("SELECT Username FROM Accounts WHERE Username=?");
	$query->bind_param("s", $ca_username_esc);
	$query->execute();
	$qresult = $query->get_result();

	if($qresult->num_rows > 0) { // Really there should only ever be max 1 row returned from the query
		die("UNAVAIL_USERNAME"); // Unavailable Username
	}

	$query = $conn->prepare("INSERT INTO Accounts(Username, Password) VALUES (?, ?)");
	$query->bind_param("ss", $ca_username_esc, $ca_password_hash);
	$query->execute();

	session_start();
	$_SESSION["username"] = $ca_username;

	mysqli_close($conn);

	die("SUCCESS"); // Success
} else if($is_login) {
	$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

	if(!$conn) {
		die("DB_CONN_FAIL");
	}

	$li_username = $_POST["login-username"];
	$li_password = $_POST["login-password"];
	$li_username_esc = $conn->real_escape_string($li_username); // Input sanitisation

	$query = $conn->prepare("SELECT Username, Password FROM Accounts WHERE Username=?");
	$query->bind_param("s", $li_username_esc);
	$query->execute();
	$qresult = $query->get_result();

	if($row = $qresult->fetch_row()) { // fetch_row() can return null or false which are both falsy so the if fails
		if(password_verify($li_password, $row[1])) {
			session_start();
			$_SESSION["username"] = $li_username;
			mysqli_close($conn);
			die("SUCCESS"); // Logged in
		} else {
			die("WRONG_PASSWORD");
		}
	} else {
		die("WRONG_USERNAME");
	}

	mysqli_close($conn);
} else if($is_check_username) {
	$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

	if(!$conn) {
		die("DB_CONN_FAIL"); // Connection to database failed | $conn->connect_error
	}

	$cu_username = $_POST["check-username"];
	$cu_username_esc = $conn->real_escape_string($cu_username); // Input sanitisation

	$query = $conn->prepare("SELECT Username FROM Accounts WHERE Username=?");
	$query->bind_param("s", $cu_username_esc);
	$query->execute();
	$qresult = $query->get_result();

	if($qresult->num_rows > 0) { // Really there should only ever be max 1 row returned from the query
		die("UNAVAIL_USERNAME"); // Unavailable Username
	} else {
		die("AVAIL_USERNAME");
	}

	mysqli_close($conn);
}

?>

<!doctype html>

<html lang="en">
	<head>
		<title>Login | Imagine Dragons</title>

		<?php include "parts/head.php" ?>

		<!-- Scripts for changing the form between Login and Create Account and form handling -->
		<script src="assets/js/form-script.js" defer></script>

		<!-- Styling for dialogs -->
		<link rel="stylesheet" href="assets/css/dialog.css">
	</head>

	<body class="container-fluid">
		<?php include "parts/nav.php" ?>

		<header class="page-header container-xxl">
			<h1>Login</h1>
		</header>

		<div class="page-content">
			<main class="container-xxl">
				<p>By creating an account or logging in, you're agreeing to the storage/usage of cookies on this site. Read the <a href="privacy.php">privacy policy</a> for more information.</p>
				<div class="centre-row row">
					<form id="login-form" action="#" class="fullwidth-children col-md-4"> <!-- Going to intercept submit with javascript -->
						<!-- Username field -->
						<label for="login-username">Username</label><br>
						<input id="login-username" type="text" name="login-username"><br><br>

						<!-- Password field -->
						<label for="login-password">Password</label><br>
						<input id="login-password" type="password" name="login-password"><br><br>

						<input type="submit" value="Login">
					</form>

					<form id="create-account-form" action="#" class="fullwidth-children col-md-4" style="display: none;">
						<!-- Username field -->
						<label for="create-account-username">Username</label><br>
						<input id="create-account-username" type="text" name="create-account-username"><br><br>

						<!-- Password field -->
						<label for="create-account-password">Password</label><br>
						<input id="create-account-password" type="password" name="create-account-password"><br><br>
						<p id="unavailable-username-warning" style="display: none;">Username is unavailable ⛔</p>

						<input type="submit" value="Create Account">
					</form>
				</div>

				<br><br>

				<div class="centre-row row">
					<!-- Button to switch between login and create account -->
					<p class="col-md-4">
						Or, <input id="switch-form-btn" type="button" value="create an account" onclick="javascript:SwitchForm()">
					</p>
				</div>
			</main>

			<?php include "parts/footer.php" ?>
		</div>
	</body>
</html>