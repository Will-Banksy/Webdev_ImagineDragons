<!doctype html>

<?php

if(isset($_COOKIE["PHPSESSID"])) {
	session_start();
}

?>

<html lang="en">
	<head>
		<title>Requirements | Imagine Dragons</title>

		<?php include "parts/head.php" ?>
	</head>

	<body class="container-fluid">
		<?php include "parts/nav.php" ?>

		<header class="page-header container-xxl">
			<h1>CMP204 Requirements Page - Unit 2 Assessment</h1>
		</header>

		<div class="page-content">
			<main class="container-xxl">
				<!-- <section class="main-section">
					<p>If you have not met a requirement, do not delete it from the table.</p>
				</section> -->

				<section class="main-section">
					<table>
						<thead>
							<tr>
								<th>Requirement</th>
								<th>How did you meet this requirement?</th>
								<th>File name(s), line no.</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>HTML, CSS, JavaScript has been contained within separate files.</td>
								<td>I put the HTML, CSS and JavaScript in different files.</td>
								<td>N/A</td>
							</tr>
							<tr>
								<td>A clear use of HTML5.</td>
								<td>I have used HTML5 features such as a concise doctype and the figure element.</td>
								<td>HTML5 doctype: index.php line 1<br>Figure element: discography-fetch.js line 2</td>
							</tr>
							<tr>
								<td>Use of the Bootstrap framework providing a responsive layout.</td>
								<td>I have used the bootstrap grid layout to lay out my site.</td>
								<td>index.php line 38</td>
							</tr>
							<tr>
								<td>Use of JavaScript to manipulate the DOM based on an event.</td>
								<td>I used JavaScript to insert a list of albums into the homepage.</td>
								<td>discography-fetch.js line 23</td>
							</tr>
							<tr>
								<td>Use of jQuery in conjunction with the DOM.</td>
								<td>I used jquery to insert and delete a popup showing tracks belonging to an album.</td>
								<td>album-popup.js line 56</td>
							</tr>
							<tr>
								<td>Use of AJAX (pure JavaScript i.e. without the use of a library).</td>
								<td>I used the fetch function (as a concise alternative to creating an XMLHttpRequest) to intercept form events and submit the request and handle the response.</td>
								<td>form-script.js line 52</td>
							</tr>
							<tr>
								<td>Use of the jQuery AJAX function.</td>
								<td>I used the jquery ajax function to fetch the tracks belonging to an album to then be turned into html and inserted into the DOM.</td>
								<td>album-popup.js line 35</td>
							</tr>
							<tr>
								<td>User login functionality (PHP/MySQL).</td>
								<td>My website provides login functionality</td>
								<td>login.php lines 79-109</td>
							</tr>
							<tr>
								<td>Ability to select (SELECT), add (INSERT), edit (UPDATE) and delete (DELETE) information from a database (PHP/MySQL).</td>
								<td>There is a username availability checker (SELECT), the option to change username (UPDATE), the ability to create an account (INSERT), and the ability to delete an account (DELETE).</td>
								<td>SELECT: login.php line 119<br>INSERT: login.php line 69<br>UPDATE: account.php line 59<br>DELETE: account.php line 81</td>
							</tr>
							<tr>
								<td>Consideration of GDPR and the Cookie Law.</td>
								<td>I have written a GDPR compliant privacy policy</td>
								<td>privacy-policy.html</td>
							</tr>
							<tr>
								<td>SQL queries written as prepared statements.</td>
								<td>All my SQL queries are written as prepared statements</td>
								<td>login.php (e.g. lines 119, 69), account.php (e.g. lines 59, 81)</td>
							</tr>
							<tr>
								<td>Passwords should be salted and hashed.</td>
								<td>I used the php password_hash() function to produce salted hashes of passwords.</td>
								<td>login.php line 58</td>
							</tr>
							<tr>
								<td>User input is sanitised.</td>
								<td>I have used the htmlspecialchars() function to sanitise the username before using as html, and I have used mysqli_real_escape_string() to sanitise the username before using in SQL.</td>
								<td>htmlspecialchars: account.php line 125<br>mysqli_real_escape_string: login.php line 57</td>
							</tr>
						</tbody>
					</table>
				</section>
			</main>

			<?php include "parts/footer.php" ?>
		</div>
	</body>
</html>
