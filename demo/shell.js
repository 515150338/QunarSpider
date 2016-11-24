setInterval(function(){
	var data = {};
	$('.b_ugcfeed').map(function(index, value){
		var el = $(value);
		data.id = el.data('id');
		data.usernickname = el.find('.usernickname a').text();
		data.userlevel = el.find('.userlevel a').text();
		data.userstat = [];
		el.find('.userstat li').each(function(index){
			data.userstat[index] = $(this).text();
		});
	});
	$.getJSON('http://localhost/QunarSpider/demo/store.php?jsoncallback=?',data,function(result){
    	console.log(result);
	});
	$('.next a').trigger('click');
},1000);