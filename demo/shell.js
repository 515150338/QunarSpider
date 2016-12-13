if (typeof jQuery == 'undefined') { 
// jQuery 未加载
// var qunarFrame = document.getElementById("qunarFrame")；
console.log("无jq");
}
$("<iframe src="+window.location.href+" width='400px' height='400px' id='qunarFrame' name='qunarFrame'></iframe>").prependTo('body');
$('#qunarFrame').get(0).onload = function () {
    var is_onload = false;
    setTimeout(test(this,is_onload),1000);
    
};
function _test(context,is_onload) {
    return function () {
        test(context,is_onload);
    }
}

function test(context,is_onload){

    var url = 'http://hotel.qunar.com/city/shenzhen/dt-';
    var hotel = {};

    var win = context.contentWindow;
    var match = context.src.match(/dt-\d+/);
    var hotel_id = match[0].substring(3);
    hotel.id = hotel_id;
    if(!is_onload){
        console.log('onload!');
        if(win.$('.noHotelInfoContainer').length > 0){
            console.log('酒店不存在');
            $("#qunarFrame").attr("src", url+(++hotel_id)+'/');
            return;
        }
        if(win.$('.waring-icon').length > 0){
            console.log('酒店停业');
            $("#qunarFrame").attr("src", url+(++hotel_id)+'/');
            return;
        }

        hotel.name = win.$('.htl-info').find('h2 span').text();

        var score = win.$('.score');
        if(score.hasClass('no_score')){
            hotel.goods_rate= win.$('.no_score').text();
        }else{
            hotel.goods_rate= score.find('span').text();
        }

        if(win.$('.js-positiveCount').length > 0){
            hotel.goods_count = (win.$('.js-positiveCount').text().match(/\d+/))[0];
            hotel.mids_count = (win.$('.js-neutralCount').text().match(/\d+/))[0];
            hotel.bads_count = (win.$('.js-negativeCount').text().match(/\d+/))[0];
        }
        $.getJSON('http://localhost/QunarSpider/demo/store_hotel.php?jsoncallback=?',hotel,function(result){
            console.log(result);
        });
    }


    if(win.$('.js_no_com').length > 0){
        console.log('酒店无评论');
        $("#qunarFrame").attr("src", url+(++hotel_id)+'/');
        return;
    }
    var data = {};
    var length = win.$('.b_ugcfeed').length;
    console.log('aa:'+length);

    var count = 0;
    win.$('.b_ugcfeed').map(function(index, value){
        var el = $(value);
        data.id = el.data('id');

        data.hotel_id = hotel_id;

        data.usernickname = el.find('.usernickname a').text();
        data.userlevel = el.find('.userlevel a').text();

        data.userstat = [];
        el.find('.userstat li').each(function(index){
            data.userstat[index] = $(this).text();
        });

        data.title = el.find('.title a').text();
        data.like_count = el.find('.js_like_count').text();
        data.reply_count = el.find('.js_reply_count').text();
        if(win.$('.in').length > 0){
            data.star = (el.find('.in').attr('style').match(/\d+/))/20;
        }
        // data.comment = el.find('.js-content').text();
        data.comment = 'aa';

        var reg_checkin = /\d+年/;
        el.find('.js-checkin li').each(function(){
            var text =$(this).text();
            if(text){
                if(reg_checkin.test(text)){
                    data.checkin_time = text;
                }else{
                    data.checkin_reason = text;
                }
            }
        });
        data.from = el.find('.from').text();

        var next = false;
        $.getJSON('http://localhost/QunarSpider/demo/store_user.php?jsoncallback=?',data,function(result){
            console.log(result);
            count++;
            console.log(count);
            if(count == length){
                win.$('.js-pager').find('.ui-page ul li').each(function () {
                    if($(this).hasClass('next')) {
                        console.log('下一页');
                        next = true;
                        is_onload = true;
                        win.$(this).find('a').trigger('click');
                        setTimeout(_test(context,is_onload),500);
                    }
                });
                if(!next){
                    $("#qunarFrame").attr("src", url+(++hotel_id)+'/');
                }
            }else {
                console.log('nonono');
            }
        });
    });
}