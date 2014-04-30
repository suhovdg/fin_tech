$(document).ready(function () {
	$('.tableBtn').click(function () {
		var action = this.id.split('_');
		if (action[0] == 'payBill') {
			location.href = '../../qiwi/gate/order/external/main.action?shop=' + action[1] + '&transaction=' + action[2];
		}
		$.ajax({
			type: "POST",
			url: 'orders/' + action[0],
			data: 'order_id=' + action[1],
			success: function (data) {
				$('#message').dialog({
					title: data['title'], show: 'fade', hide: 'fade', modal: true, close: function () {
						location.reload();
					}
				}).html(data['message']);
			}
		});
	});
});

