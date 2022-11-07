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

$is_change_uname = isset($_POST["new-username"]);
$is_logout = isset($_POST["logout"]);
$is_del_account = isset($_POST["del-account"]);

// Check for empty
if($is_change_uname && empty($_POST["new-username"])) {
	die("NO_USERN_OR_PASS"); // Username or Password not provided
}

// Check for username length
if($is_change_uname && strlen($_POST["new-username"]) >= 255) {
	die("USERN_TOO_LONG"); // Username is too long
}

// NEED SQL SERVER
$db_server = "";
$db_username = "";
$db_password = "";
$db_name = "";

if($is_change_uname) {
	$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

	if(!$conn) {
		die("DB_CONN_FAIL"); // Connection to database failed | $conn->connect_error
	}

	$cu_username = $_POST["new-username"];
	$cu_username_esc = $conn->real_escape_string($cu_username); // Input sanitisation

	$query = $conn->prepare("SELECT Username FROM Accounts WHERE Username=?");
	$query->bind_param("s", $cu_username_esc);
	$query->execute();
	$qresult = $query->get_result();

	if($qresult->num_rows > 0) { // Really there should only ever be max 1 row returned from the query
		die("UNAVAIL_USERNAME"); // Unavailable Username
	}

	$query = $conn->prepare("UPDATE Accounts SET Username=? WHERE Username=?");
	$query->bind_param("ss", $cu_username_esc, $conn->real_escape_string($_SESSION["username"]));
	$query->execute();
	// $qresult = $query->get_result();

	$_SESSION["username"] = $cu_username;

	mysqli_close($conn);

	die("SUCCESS");
} else if($is_logout) {
	$_SESSION = array();
	session_destroy();
	setcookie("PHPSESSID", "", 1); // Attempt deletion of cookie using php (JS backup)
	die("SUCCESS");
} else if($is_del_account) {
	$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

	if(!$conn) {
		die("DB_CONN_FAIL"); // Connection to database failed | $conn->connect_error
	}

	$query = $conn->prepare("DELETE FROM Accounts WHERE Username=?");
	$query->bind_param("s", $conn->real_escape_string($_SESSION["username"]));
	$query->execute();

	mysqli_close($conn);

	$_SESSION = array();
	session_destroy();
	setcookie("PHPSESSID", "", 1); // Attempt deletion of cookie using php (JS backup)
	die("SUCCESS");
}

?>

<!doctype html>

<html lang="en">
	<head>
		<title>Account | Imagine Dragons</title>

		<?php

		include "parts/head.php";

		if(!isset($_SESSION["username"])) {
			echo "<meta http-equiv=\"Refresh\" content=\"0; url='login.php'\">";
		}

		?>

		<!-- Script for dealing with account actions -->
		<script src="assets/js/account-script.js" defer></script>

		<!-- Styling for dialogs -->
		<link rel="stylesheet" href="assets/css/dialog.css">
	</head>

	<body class="container-fluid">
		<?php include "parts/nav.php" ?>

		<header class="page-header container-xxl">
			<?php

			if(isset($_SESSION["username"])) {
				echo "<h1>Hello, " . htmlspecialchars($_SESSION["username"]) . "</h1>";
			} else {
				echo "Account";
			}

			?>
		</header>

		<div class="page-content">
			<main class="container-xxl">
				<section class="main-section col-md-12">
					<?php if(!isset($_SESSION["username"])): ?>
						<a href="login.php">Login</a>
					<?php else: ?>
						<div class="centre-items-hor">
							<div class="space-below">
								<form action="#" id="change-username-form">
									<label for="new-username">New Username</label><br>
									<input type="text" name="new-username" id="new-username">

									<input type="submit" value="Change Username"><br>
									<p id="unavailable-username-warning" style="display: none;">Username is unavailable ⛔</p>
								</form>
							</div>

							<div>
								<button type="button" id="log-out-btn">Log Out</button>
								<button type="button" id="del-account-btn">Delete Account</button>
							</div>
						</div>
					<?php endif ?>
				</section>
			</main>

			<?php include "parts/footer.php" ?>
		</div>
	</body>
</html>