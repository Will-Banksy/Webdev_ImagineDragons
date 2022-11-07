const dialogTemplate = '<div class="dialog-root">\
	<div class="dialog-body">\
		${DIALOG_TEXT}\
		<button type="button" onclick="javascript:HideDialog(this)">Okay</button>\
	</div>\
</div>';

function q(query) {
	return document.querySelector(query);
}

function SwitchForm() {
	let loginForm = q("#login-form");
	let createAccountForm = q("#create-account-form");

	if(loginForm.style.display == "none") {
		loginForm.style.display = "block";
		createAccountForm.style.display = "none";
		q("title").innerText = "Login | Imagine Dragons";
		q(".page-header h1").innerText = "Login";
		q("#switch-form-btn").value = "create an account"
	} else {
		loginForm.style.display = "none";
		createAccountForm.style.display = "block";
		q("title").innerText = "Create Account | Imagine Dragons";
		q(".page-header h1").innerText = "Create Account";
		q("#switch-form-btn").value = "log in to an existing account"
	}
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

q("#login-form").addEventListener("submit", (event) => {
	event.preventDefault();

	let formData = new FormData(q("#login-form")); // Create FormData from the form element

	fetch("login.php", {
		method: "POST",
		body: formData
	}).then((response) => {
		return response.text();
	}).then((responseText) => {
		switch(responseText) {
			case "SUCCESS":
				location.assign("index.php");
				break;

			case "WRONG_PASSWORD":
				ShowDialog("Incorrect Password 🔑");
				break;

			case "WRONG_USERNAME":
				ShowDialog("Incorrect Username 👤");
				break;

			case "DB_CONN_FAIL":
				ShowDialog("Internal Server Error: Connection To Database Failed 🔗");
				break;

			case "NO_USERN_OR_PASS":
				ShowDialog("Username Or Password Not Provided ❌");
				break;

			case "USERN_TOO_LONG":
				ShowDialog("Username Is Too Long (>= 255 characters) 🏴󠁧󠁢󠁷󠁬󠁳󠁿");
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

q("#create-account-form").addEventListener("submit", (event) => {
	event.preventDefault();

	let formData = new FormData(q("#create-account-form"));

	fetch("login.php", {
		method: "POST",
		body: formData
	}).then((response) => {
		return response.text();
	}).then((responseText) => {
		switch(responseText) {
			case "SUCCESS":
				location.assign("index.php");
				break;

			case "UNAVAIL_USERNAME":
				ShowDialog("Unavailable Username 👥");
				break;

			case "DB_CONN_FAIL":
				ShowDialog("Internal Server Error: Connection To Database Failed 🔗");
				break;

			case "NO_USERN_OR_PASS":
				ShowDialog("Username Or Password Not Provided ❌");
				break;

			case "USERN_TOO_LONG":
				ShowDialog("Username Is Too Long (>= 255 characters) 🏴󠁧󠁢󠁷󠁬󠁳󠁿");
				break;

			default:
				ShowDialog("Unrecognised response while logging in 😧: <pre>" + responseText + "</pre>");
				console.log("Unrecognised response while logging in 😧: " + responseText);
				break;
		}
	}).catch((err) => {
		ShowDialog("An error has occurred while creating your account. Please contact the administrators.");
	});
});

q("#create-account-username").addEventListener("change", (event) => {
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