const dialogTemplate = '<div class="dialog-root">\
	<div class="dialog-body">\
		${DIALOG_TEXT}\
		<button type="button" onclick="javascript:HideDialog(this)">Okay</button>\
	</div>\
</div>';

function q(query) {
	return document.querySelector(query);
}

function DeleteCookie(cookieName) {
	document.cookie = cookieName + '=; Max-Age=-9999; path=/; domain=' + location.hostname;
}

function ShowDialog(message, noAddPTag) {
	if(!noAddPTag) {
		message = "<p>" + message + "</p>";
	}
	let html = dialogTemplate;
	html = html.replace(/\$\{DIALOG_TEXT\}/g, message);
	let templateElem = document.createElement("template");
	templateElem.innerHTML = html;
	let clone = templateElem.content.cloneNode(true);
	document.body.appendChild(clone);
}

function HideDialog(btnElem) {
	btnElem.parentElement.parentElement.remove();
}

q("#change-username-form").addEventListener("submit", (event) => {
	event.preventDefault();

	let formData = new FormData(event.target); // Create FormData from the form element

	fetch("account.php", {
		method: "POST",
		body: formData
	}).then((response) => {
		return response.text();
	}).then((responseText) => {
		switch(responseText) {
			case "SUCCESS":
				location.reload(true);
				break;

			case "DB_CONN_FAIL":
				ShowDialog("Internal Server Error: Connection To Database Failed 🔗");
				break;

			case "NO_USERN_OR_PASS":
				ShowDialog("Username Not Provided ❌");
				break;

			case "USERN_TOO_LONG":
				ShowDialog("Username Is Too Long (>= 255 characters) 🏴󠁧󠁢󠁷󠁬󠁳󠁿");
				break;

			case "UNAVAIL_USERNAME":
				ShowDialog("Unavailable Username 👥");
				break;

			default:
				ShowDialog("Unrecognised response while creating account 😧: <pre>" + responseText + "</pre>");
				console.log("Unrecognised response while creating account 😧: " + responseText);
				break;
		}
	}).catch((err) => {
		ShowDialog("An error has occurred while logging in to your account. Please contact the administrators.");
	});
});

q("#new-username").addEventListener("change", (event) => {
	let formData = new FormData();
	formData.append("check-username", event.target.value);
	console.log(event.target.value);

	fetch("login.php", {
		method: "POST",
		body: formData
	}).then((response) => {
		return response.text();
	}).then((responseText) => {
		let p = q("#unavailable-username-warning");
		switch (responseText) {
			case "UNAVAIL_USERNAME":
				p.innerHTML = "Username is unavailable ⛔";
				p.style.display = "block";
				break;

			case "NO_USERN_OR_PASS":
			case "AVAIL_USERNAME":
				p.innerHTML = "Username is unavailable ⛔";
				p.style.display = "none";
				break;

			case "DB_CONN_FAIL":
				p.innerHTML = "Internal Server Error: Connection To Database Failed 🔗";
				p.style.display = "block";
				break;

			case "USERN_TOO_LONG":
				p.innerHTML = "Username Is Too Long (>= 255 characters) 🏴󠁧󠁢󠁷󠁬󠁳󠁿";
				p.style.display = "block";
				break;

			default:
				p.innerHTML = "Unrecognised Response while checking username 😧: <pre>" + responseText + "</pre>";
				p.style.display = "block";
				console.log("Unrecognised Response while checking username 😧: " + responseText);
				break;
		}
	}).catch((err) => {
		ShowDialog("An error has occurred while checking your username. Please contact the administrators.");
	});
});

q("#log-out-btn").addEventListener("click", (event) => {
	let formData = new FormData();
	formData.append("logout", "y");

	fetch("account.php", {
		method: "POST",
		body: formData
	}).then((response) => {
		return response.text();
	}).then((responseText) => {
		switch(responseText) {
			case "SUCCESS":
				DeleteCookie("PHPSESSID"); // Attempt cookie deletion in JS too. I couldn't get either the PHP or JS cookie deletion to work on firefox
				location.assign("index.php");
				break;

			default:
				ShowDialog("Unrecognised response while creating account 😧: <pre>" + responseText + "</pre>");
				console.log("Unrecognised response while creating account 😧: " + responseText);
				break;
		}
	}).catch((err) => {
		ShowDialog("An error has occurred while logging in to your account. Please contact the administrators.");
	});
});

q("#del-account-btn").addEventListener("click", (event) => {
	let formData = new FormData();
	formData.append("del-account", "y");

	fetch("account.php", {
		method: "POST",
		body: formData
	}).then((response) => {
		return response.text();
	}).then((responseText) => {
		switch(responseText) {
			case "SUCCESS":
				DeleteCookie("PHPSESSID"); // Attempt cookie deletion in JS too. I couldn't get either the PHP or JS cookie deletion to work on firefox
				location.assign("index.php");
				break;

			case "DB_CONN_FAIL":
				ShowDialog("Internal Server Error: Connection To Database Failed 🔗");
				break;

			default:
				ShowDialog("Unrecognised response while creating account 😧: <pre>" + responseText + "</pre>");
				console.log("Unrecognised response while creating account 😧: " + responseText);
				break;
		}
	}).catch((err) => {
		ShowDialog("An error has occurred while logging in to your account. Please contact the administrators.");
	});
});