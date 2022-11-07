// Using jQuery

const popupTemplate = '<div class="album-popup-root">\
	<div class="album-popup">\
		<button type="button" onclick="javascript:Close(this)">Close</button>\
		<div class="album-cover-tracks-container">\
			<figure>\
				<img src="${DZ_COVER_LARGE}" alt="Album Cover - ${DZ_TITLE}">\
				<figcaption>${DZ_TITLE}</figcaption>\
			</figure>\
			<div class="album-tracks">\
				<div class="album-tracks-header">\
					<span>Title</span>\
					<span>Artist(s)</span>\
				</div>\
				${HTML_TRACKS}\
			</div>\
		</div>\
		<a href="${DZ_LINK}" target="_blank" rel="noopener noreferrer">This album on Deezer</a>\
	</div>\
</div>';

const trackTemplate = '<div class="album-tracks-entry">\
	<span>${DZ_TITLE}</span>\
	<span>${DZ_ARTIST}</span>\
</div>';

function setupAlbumPopups() {
	$(".album-cover-button").click(function(event) {
		let dataContainer = $("img", this);
		let albumId = dataContainer.attr("dz-id");
		let albumCover = dataContainer.attr("dz-cover-large");
		let albumTitle = dataContainer.attr("dz-title");
		let albumLink = dataContainer.attr("dz-link");
		$.ajax("dz-api.php?dz-endpoint=/album/" + albumId + "/tracks")
			.done((response) => {
				let obj = JSON.parse(response);
				obj.data.sort((a, b) => a.track_position > b.track_position); // Sort by track number

				let html = popupTemplate;
				html = html.replace(/\$\{DZ_ID\}/g, albumId);
				html = html.replace(/\$\{DZ_TITLE\}/g, albumTitle);
				html = html.replace(/\$\{DZ_LINK\}/g, albumLink);
				html = html.replace(/\$\{DZ_COVER_LARGE\}/g, albumCover);

				let trackHtml = "";
				obj.data.forEach(track => {
					let workingTemplate = trackTemplate;
					workingTemplate = workingTemplate.replace(/\$\{DZ_TITLE\}/g, track.title);
					workingTemplate = workingTemplate.replace(/\$\{DZ_ARTIST\}/g, track.artist.name);
					trackHtml += workingTemplate;
				});

				html = html.replace(/\$\{HTML_TRACKS\}/g, trackHtml);

				$("body").prepend(html);
				$(":root").css("overflow", "hidden");
			});
	});
}

function Close(element) {
	$(element).parent().parent().remove(); // Yeet it out of the DOM
	$(":root").css("overflow", "auto");
}