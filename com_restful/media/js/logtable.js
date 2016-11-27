js = jQuery.noConflict();

var count;

js(document).ready(function () {
	logCount();
});


function logCount() {
	setTimeout(function () {
		js.ajax({
			url: juri_base + 'index.php?option=com_ajax&plugin=logrestful&log=true&format=json',
			success: function (data) {
				if (count != data.data[0]) {
					count = data.data[0];
				}
			}, dataType: "json", complete: logCount
		});
	}, 1000);
}