const albumTemplate = '<div class="centre-items-hor album-list-item">\
	<figure class="album-list-item-internal-wrapper">\
		<button type="button" class="album-cover-button">\
			<img src="${DZ_COVER_MED}" alt="Album Cover - ${DZ_TITLE}" dz-title="${DZ_TITLE}" dz-id="${DZ_ID}" dz-link="${DZ_LINK}" dz-cover-large="${DZ_COVER_LARGE}" class="album-cover-img">\
		</button>\
		<figcaption>${DZ_TITLE}</figcaption>\
	</figure>\
</div>';

function populateDiscography(response) {
	let html = "";
	response.data.sort((a, b) => Date.parse(a.release_date) < Date.parse(b.release_date));
	response.data.forEach(album => {
		let workingTemplate = albumTemplate;
		workingTemplate = workingTemplate.replace(/\$\{DZ_ID\}/g, album.id);
		workingTemplate = workingTemplate.replace(/\$\{DZ_TITLE\}/g, album.title);
		workingTemplate = workingTemplate.replace(/\$\{DZ_LINK\}/g, album.link);
		workingTemplate = workingTemplate.replace(/\$\{DZ_COVER_MED\}/g, album.cover_medium);
		workingTemplate = workingTemplate.replace(/\$\{DZ_COVER_LARGE\}/g, album.cover_big);
		html += workingTemplate;
	});
	let container = document.querySelector("#album-list-container");
	container.innerHTML = html;
	setupAlbumPopups();
}