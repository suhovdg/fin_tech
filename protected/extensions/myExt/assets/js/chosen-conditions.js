function checkTime(i) {
	if (i < 10) {
		i = "0" + i;
	}
	return i;
}

function getDateToPayUntil(n) {
	var dayarray = new Array("воскресенья", "понедельника", "вторника", "среды", "четверга", "пятницы", "субботы");
	var montharray = new Array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

	var d = new Date();
	d.setTime(d.getTime() + n * 24 * 60 * 60 * 1000);

	return dayarray[d.getDay()] + ", " + d.getDate() + " " + montharray[d.getMonth()] + " " + checkTime(d.getFullYear());
}

function showConditions(obj) {
	$('.price_count').html(obj.attr('data-price'));
	$('.price_month').html(obj.attr('data-price-count'));
	$('.count_subscribe').html(obj.attr('data-count'));
	var n = obj.attr('data-time');
	$('.date').html(getDateToPayUntil(n));
	$('.final_price').html(obj.attr('data-final-price'));
}

$(document).ready(function () {
	if ($('#ClientSelectProductForm').is("form")) {
		$('#ClientSelectProductForm .radio').click(function () {
			showConditions($(this).find("label > span"));
		});
	} else {
		$('#ClientSelectProductForm2 .radio').click(function () {
			showConditions($(this).find("label > span"));
		});
	}
	if ($('#ClientSelectProductForm').is("form")) {
		showConditions($('#ClientSelectProductForm .radio:first label > span'));
	} else {
		showConditions($('#ClientSelectProductForm2 .radio:first label > span'));
	}


	if ($('#ClientSelectProductForm').is("form")) {
		$('#ClientSelectProductForm .radio').each(function () {
			if (($(this).find("input:checked").attr("value")) !== undefined) {
				showConditions($(this).find("label > span"));
				if ($(this).find("input:checked").attr("value") == 0) $(".conditions").hide();
			}
		});
	} else {
		$('#ClientSelectProductForm2 .radio').each(function () {
			if (($(this).find("input:checked").attr("value")) !== undefined) {
				showConditions($(this).find("label > span"));
				if ($(this).find("input:checked").attr("value") == 0) $(".conditions").hide();
			}
		});
	}
});
