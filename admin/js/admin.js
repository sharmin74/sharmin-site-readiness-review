document.addEventListener('DOMContentLoaded', function () {

	// Get all filter buttons and check cards.
	const filters = document.querySelectorAll('.slc-filter');
	const checks = document.querySelectorAll('.slc-check');

	// Handle filter button clicks.
	filters.forEach(function (filterButton) {

		filterButton.addEventListener('click', function () {

			const selectedFilter = filterButton.dataset.filter;

			// Update the active filter button.
			filters.forEach(function (button) {
				button.classList.remove('active');
			});

			filterButton.classList.add('active');

			// Show or hide checks based on the selected status.
			checks.forEach(function (check) {

				const checkStatus = check.dataset.status;

				if ('all' === selectedFilter || checkStatus === selectedFilter) {
					check.style.display = '';
				} else {
					check.style.display = 'none';
				}

			});

		});

	});

});