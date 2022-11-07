<!doctype html>

<?php

if(isset($_COOKIE["PHPSESSID"])) {
	session_start();
}

?>

<html lang="en">
	<head>
		<title>Home | Imagine Dragons</title>

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
			<h1>Home</h1>
		</header>

		<div class="page-content">
			<main class="container-xxl">
				<div class="row">
					<section class="main-section col-md-12">
						<h2>About</h2>
						<p><i><a href="https://en.wikipedia.org/wiki/Imagine_Dragons" target="_blank" rel="noopener noreferrer">Wikipedia</a></i></p>
						<p>Imagine Dragons is an American pop rock band from Las Vegas, Nevada, consisting of lead singer Dan Reynolds, guitarist Wayne Sermon, bassist Ben McKee, and drummer Daniel Platzman. The band first gained exposure with the release of their single "It's Time", followed by their award-winning debut studio album Night Visions (2012), which resulted in the chart-topping singles "Radioactive" and "Demons". Rolling Stone named "Radioactive", which held the record for most weeks charted on the Billboard Hot 100, the "biggest rock hit of the year". MTV called them "the year's biggest breakout band", and Billboard named them their "Breakthrough Band of 2013" and "Biggest Band of 2017". and placed them at the top of their "Year in Rock" rankings for 2013, 2017, and 2018. Imagine Dragons topped the Billboard Year-End "Top Artists – Duo/Group" category in 2018.</p>
						<p>The band's second studio album Smoke + Mirrors (2015) reached number one in the US, Canada and the UK. This was followed by their third studio album, Evolve (2017) which resulted in three chart-topping singles, "Believer", "Thunder", and "Whatever It Takes", also making them the artist with the most weeks at number-one on the Billboard Hot Rock Songs chart. The album reached the top five in many countries. The band's fourth studio album Origins (2018) featured the single "Natural", which became their fifth song to top the Hot Rock Songs chart. While all four albums were commercially successful, critical reception was mixed. The band released their fifth studio album Mercury – Act 1 on September 3, 2021.</p>
						<p>Imagine Dragons has won three American Music Awards, nine Billboard Music Awards, one Grammy Award, one MTV Video Music Award and one World Music Award. In May 2014, the band was nominated for fourteen Billboard Music Awards, including Top Artist of the Year and a Milestone Award, which recognizes innovation and creativity of artists across different genres. In April 2018, the band was nominated eleven more times for Billboard Music Awards.</p>
						<p>Imagine Dragons have sold more than 75 million records worldwide. They were the most streamed group of 2018 on Spotify and are the first rock act to have four songs, "Radioactive", "Demons", "Believer" and "Thunder", to surpass one billion streams each. According to Billboard, they also have the top three rock songs of the 2010s on the US charts, "Believer", "Thunder", and "Radioactive".</p>
					</section>
				</div>

				<section class="main-section col-md-12">
					<h2>Discography</h2>
					<p>Discography fetched from <a href="https://www.deezer.com" target="_blank" rel="noopener noreferrer">Deezer</a> via the <a href="https://developers.deezer.com/api" target="_blank" rel="noopener noreferrer">official API</a>.</p>
					<p>Click on an album for details.</p>
					<div id="album-list-container" class="col-md-12 album-list-container">
					</div>
				</section>
			</main>

			<?php include "parts/footer.php" ?>
		</div>
	</body>
</html>