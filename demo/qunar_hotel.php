<?php
ini_set("memory_limit", "1024M");
require dirname(__FILE__).'/../core/init.php';

/* Do NOT delete this comment */
/* 不要删除这段注释 */


// 测试页面元素抽取
//$html = requests::get("http://hotel.qunar.com/city/beijing_city/dt-159/");
//$data = selector::select($html, '//*[@id="js_commentsCount_nav"]');
//print_r($data);
//echo "sad";
//echo "\n";
//exit;

$configs = array(
    'name' => '去哪儿酒店爬虫',
    'tasknum' => 1,
    'save_running_state' => false,
    //'log_show' => true,
    'domains' => array(
        'hotel.qunar.com',
    ),
    'scan_urls' => array(
        "http://hotel.qunar.com/city/",
        //"http://list.jd.com/list.html?cat=1318,1463,12109", // JD http 和 https 都支持
    ),
    // 'list_url_regexes' => array(
    //     "http://list.jd.com/list.html\?cat=\d+,\d+,\d+",
    // ),
    'content_url_regexes' => array(
        "http://hotel.qunar.com/city/beijing_city/dt-\d+/",
    ),
    'export' => array(
        'type' => 'db',
        'table' => 'qunar_hotels',
        //'type' => 'csv',
        //'file' => PATH_DATA.'/jd_goods.csv',
    ),
    'fields' => array(
         //酒店ID
         array(
             'name' => "hotels_id",
             'selector' => '//a[@clstag="shangpin|keycount|product|guanzhushangpin_2"]/@data-id',
             'required' => false,
         ),
         //酒店名
        array(
            'name' => "hotels_name",
            'selector' => '//*[@id="detail_pageHeader"]/h2/span',
            'required' => true,
        ),
        // 酒店URL
        // array(
        //     'name' => "goods_url",
        //     'selector' => "//*[contains(@class,'sku-name')]",
        //     'required' => true,
        // ),
        // 酒店价格
        array(
            'name' => "hotels_price",
            'selector' => '//*[@id="toRoomtool"]/div/b',
            'required' => false,
        ),
        // 酒店优惠信息
        //array(
            //'name' => "goods_quan",
            //'selector' => "//*[contains(@class,'quan-item')]/span",
            //'required' => true,
        //),
        //酒店评价总数
        array(
            'name' => "comment_count",
            'selector' => '//*[@id="js_commentsCount_nav"]',
            'required' => false,
        ),
       // 酒店评价好评率
        array(
            'name' => "goods_rate",
            'selector' => '//*[@id="jd_comments"]/div/div[1]/div[1]/div[2]/div[3]/div[1]/div[2]/span',
            'required' => false,
        ),
        // 酒店好评数
        array(
            'name' => "goods_count",
            'selector' => '//*[@id="jd_comments"]/div/div[1]/div[3]/div[2]/form/dl[2]/dd[2]/label/span',
            'required' => false,
        ),
        // 酒店差评数
        array(
            'name' => "bads_count",
            'selector' => '//*[@id="jd_comments"]/div/div[1]/div[3]/div[2]/form/dl[2]/dd[4]/label/span',
            'required' => false,
        ),
        // 酒店中评数
        array(
            'name' => "mids_count",
            'selector' => '//*[@id="jd_comments"]/div/div[1]/div[3]/div[2]/form/dl[2]/dd[3]/label/span',
            'required' => false,
        ),
        // 酒店评论
        array(
            'name' => "comments",
            'selector' => '//*[@id="js_commentsCount_nav"]',
            'required' => false,
        ),
    ),
);

$spider = new phpspider($configs);

$spider->on_extract_field = function($fieldname, $data, $page)
{
    $url=rtrim(substr($page['url'],28),'/');
    $hotels_id = substr(substr(strstr($url,'/'),1),3);
    $a=explode('/',$url);
//    $city=substr($a[0],0,-5);
    $city=$a[0];
    $response = requests::get("http://review.qunar.com/api/h/".$city."_".$hotels_id."/v2/detail");
    $res = json_decode($response);

    if($fieldname =='hotels_id')
    {
        $data = $hotels_id;
    }
    elseif ($fieldname =='goods_rate')
    {
        $data = $res->data->hotelScore;
    }
    elseif ($fieldname == 'comment_count')
    {
        $data = $res->data->countStat->commCnt;
    }
    elseif ($fieldname == 'comments')
    {
        $data = json_encode($res->data->comments);
    }


    return $data;
};

$spider->start();


