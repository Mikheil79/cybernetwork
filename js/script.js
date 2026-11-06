// Дата в шапке, фильтр тем и сообщения на всех языках формирует PHP (inc/, templates/).

// Архив: поиск и фильтр по рубрикам
var archiveSearch = document.getElementById("archive-search");
if (archiveSearch) {
	var archiveItems = document.querySelectorAll(".archive-item");
	var archiveMonths = document.querySelectorAll(".archive-month");
	var filterButtons = document.querySelectorAll(".filter-btn");
	var archiveEmpty = document.getElementById("archive-empty");
	var activeCat = "all";

	function filterArchive() {
		var query = archiveSearch.value.trim().toLowerCase();
		var found = 0;
		archiveItems.forEach(function (item) {
			var title = item.querySelector("a").textContent.toLowerCase();
			var show = (activeCat === "all" || item.dataset.cat === activeCat) && title.indexOf(query) !== -1;
			item.hidden = !show;
			if (show) found++;
		});
		// Месяц, в котором ничего не осталось, скрывается
		archiveMonths.forEach(function (month) {
			month.hidden = !month.querySelector(".archive-item:not([hidden])");
		});
		archiveEmpty.hidden = found > 0;
	}

	archiveSearch.addEventListener("input", filterArchive);
	filterButtons.forEach(function (btn) {
		btn.addEventListener("click", function () {
			filterButtons.forEach(function (b) { b.classList.remove("active"); });
			btn.classList.add("active");
			activeCat = btn.dataset.cat;
			filterArchive();
		});
	});
}
