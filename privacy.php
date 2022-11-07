<!doctype html>

<?php

if(isset($_COOKIE["PHPSESSID"])) {
	session_start();
}

?>

<html lang="en">
	<head>
		<title>Privacy Policy | Imagine Dragons</title>

		<?php include "parts/head.php" ?>

		<!-- Import script for creating popups when you click an album cover -->
		<script src="assets/js/album-popup.js" defer></script>

		<!-- Import script for using the Deezer API to load artist discography -->
		<script src="assets/js/discography-fetch.js" defer></script>

		<!-- Import stylesheet for popups -->
		<link rel="stylesheet" href="assets/css/album-popup.css">

		<!-- Make a Deezer API request with JSONP to override CORS -->
		<script src="https://api.deezer.com/artist/416239/albums?output=jsonp&output=jsonp&version=js-v1.0.0&callback=populateDiscography" defer></script>
	</head>

	<body class="container-fluid">
		<?php include "parts/nav.php" ?>

		<header class="page-header container-xxl">
			<h1>Privacy Policy</h1>
		</header>

		<div class="page-content">
			<main class="container-xxl">
				<section class="main-section col-md-12">
					<?php include "parts/privacy-policy.html" ?>
				</section>
			</main>

			<?php include "parts/footer.php" ?>
		</div>
	</body>
</html>