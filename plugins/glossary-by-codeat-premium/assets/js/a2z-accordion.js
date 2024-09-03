document.addEventListener("DOMContentLoaded", (event) => {
	document.querySelectorAll("span.glossary-link-initial-item a, span.glossary-letter").forEach(function (item) {
		item.addEventListener("click", function(e) {
			document.querySelectorAll(".glossary-block ul.open").forEach(function (ul) {
				ul.classList.remove('open');
			});
			document.querySelector('.glossary-block-' + e.target.innerText.toLowerCase() + ' ul').classList.add('open');
			e.preventDefault();
		});
	});
});
