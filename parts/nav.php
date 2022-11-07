<nav class="container-xxl">
	<img src="assets/img/artist-text-logo.png" alt="Imagine Dragons Logo" class="nav-heading">
	<span class="nav-link-list">
		<a href="index.php">Home</a>
		<a href="req.php">Requirements</a>
		<a href="privacy.php">Privacy</a>

<?php

if(!isset($_SESSION["username"])) {
	echo "<a href=\"login.php\">Login</a>";
} else {
	echo "<a href=\"account.php\">Account</a>";
}

?>

	</span>
</nav>