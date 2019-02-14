<?php
  	$json_str = file_get_contents('php://input'); //接收request的body
  	$json_obj = json_decode($json_str); //轉成json格式
  
  	$myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
  	//fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
  	$sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
  	$sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  	$sender_replyToken = $json_obj->events[0]->replyToken; //取得訊息的replyToken
  	$msg_json = '{
  "type": "bubble",
  "header": {
    "type": "box",
    "layout": "horizontal",
    "contents": [
      {
        "type": "text",
        "text": "NEWS DIGEST",
        "weight": "bold",
        "color": "#aaaaaa",
        "size": "sm"
      }
    ]
  },
  "hero": {
    "type": "image",
    "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_4_news.png",
    "size": "full",
    "aspectRatio": "20:13",
    "aspectMode": "cover",
    "action": {
      "type": "uri",
      "uri": "http://linecorp.com/"
    }
  },
  "body": {
    "type": "box",
    "layout": "horizontal",
    "spacing": "md",
    "contents": [
      {
        "type": "box",
        "layout": "vertical",
        "flex": 1,
        "contents": [
          {
            "type": "image",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/02_1_news_thumbnail_1.png",
            "aspectMode": "cover",
            "aspectRatio": "4:3",
            "size": "sm",
            "gravity": "bottom"
          },
          {
            "type": "image",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/02_1_news_thumbnail_2.png",
            "aspectMode": "cover",
            "aspectRatio": "4:3",
            "margin": "md",
            "size": "sm"
          }
        ]
      },
      {
        "type": "box",
        "layout": "vertical",
        "flex": 2,
        "contents": [
          {
            "type": "text",
            "text": "7 Things to Know for Today",
            "gravity": "top",
            "size": "xs",
            "flex": 1
          },
          {
            "type": "separator"
          },
          {
            "type": "text",
            "text": "Hay fever goes wild",
            "gravity": "center",
            "size": "xs",
            "flex": 2
          },
          {
            "type": "separator"
          },
          {
            "type": "text",
            "text": "LINE Pay Begins Barcode Payment Service",
            "gravity": "center",
            "size": "xs",
            "flex": 2
          },
          {
            "type": "separator"
          },
          {
            "type": "text",
            "text": "LINE Adds LINE Wallet",
            "gravity": "bottom",
            "size": "xs",
            "flex": 1
          }
        ]
      }
    ]
  },
  "footer": {
    "type": "box",
    "layout": "horizontal",
    "contents": [
      {
        "type": "button",
        "action": {
          "type": "uri",
          "label": "More",
          "uri": "https://linecorp.com"
        }
      }
    ]
  }
}';
  	$response = array (
		"replyToken" => $sender_replyToken,
		"messages" => array (
			array (
				"type" => "flex",
				"altText" => "This is a Flex Message",
				"contents" => json_decode($msg_json)
			)
		)
  	);
			
  	fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  	$header[] = "Content-Type: application/json";
  	$header[] = "Authorization: Bearer T0bbMQFl00OSe1xpqmecWQUV25JQOU/az38RsU0W53dE6tjYROpvAjHUlKgOKrdTdIjY2i+piDVkrFgqpOJfnegKWNaxnKmNyG1130g7wOkbnZfG99BX5TnLin4mDsaQ8exxVtuM9wt+AMmmbQBOzQdB04t89/1O/w1cDnyilFU=";
  	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
  	$result = curl_exec($ch);
  	curl_close($ch);
?>
