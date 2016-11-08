setInterval(function(){
	var data = new Object();
	$('.b_ugcfeed').map(function(index, value){
		data.id = $(value).data('id');
		data.usernickname = $(value).find('.usernickname a').text();
		data.userlevel = $(value).find('.userlevel a').text(); 
		data.userstat = [];
		$(value).find('.userstat li').each(function(index){
			data.userstat[index] = $(this).text();
		});
	});
	
	$.getJSON('http://localhost/QunarSpider/demo/hello.php?jsoncallback=?',data,function(result){
    	console.log(result);
	});
	$('.next a').trigger('click');
},1000);