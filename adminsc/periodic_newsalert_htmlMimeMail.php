<?php 

require "inc/functions_site.php";
require "inc/functions_cms.php";
require('inc/mysql_connect.php');
ini_set("display_errors", 1);

require_once('inc/htmlMimeMail-2.5.1/htmlMimeMail.php');

$query = "select * from `newsalert` where sent_mail = 0 order by id desc limit 150";
//$query = "select * from `newsalert` where sent_mail = 0 and email = 'martin@m3bg.com' order by id desc limit 1";

$result = query($query);
$sent_count = 0;

while($arr = mysqli_fetch_array($result)) {

		$content_html = "";
		$content_text = "";
		$q2 = 'select *, date_format(date, "%a, %d %M %Y") as mydate from m3site_news where id="'.$arr['news_id'].'" and active = 1';
		$r2 = query($q2);        

		if(mysqli_num_rows($r2) > 0){
                    
                     
			$arr2 = mysqli_fetch_array($r2);
			$content_html .= '<font color="#1682A3" size="+1"><b>' . $arr2["title"] . "</b></font><br><br>\n";
			$content_text .= ($arr2["title"]) . "\n";
			if(!empty($arr2["photo_small"])) {
				$content_html .= '<img src="' . SITE_URL . $arr2["photo_small"] . '" alt="" border="0" style="display: block; float: left; width: 245px; margin: 0px 15px 3px 0px;">';
			}
			$big_photo_html = '';
			$big_photo_txt = '';
			if(!empty($arr2["photo_big"])) {
				$big_photo_html = '<br>For higher resolution photo <a href="'.SITE_URL . $arr2["photo_big"].'" style="color: #000000; text-decoration: underline;">click here</a>';
				$big_photo_txt = '\nHigher resolution photo - ' . SITE_URL . $arr2["photo_big"];
			}
			
			$content_html .= $arr2["mydate"] . "<br>\n";
			$content_html .= $arr2["text"] . "<br><div style=\"clear: both;\"></div>\n";
			$content_text .= striphtml($arr2["text"]) . "\n\n";

			$unsub_html = '<br><hr><FONT face="Verdana, Arial, Hevetica, sans-serif" size="1" style="font-size: 10px;" color="#000000">For media enquiries please contact Nadine Jack on <a href="mailto:n.jack@statehouse.gov.sc">n.jack@statehouse.gov.sc</a>'.$big_photo_html.'<br><br>This message is sent to you, because you are registered for news from www.statehouse.gov.sc<br>To unsubscribe, <a href="http://www.statehouse.gov.sc/newsalert/request-unsubscribe" target="_blank" style="color: #000000; text-decoration: underline;">click here</a>.</font>';
			$unsub_text = "\n\nFor media enquiries please contact Nadine Jack on n.jack@statehouse.gov.sc".$big_photo_txt."\n\nThis message is sent to you, because you are registered for news from www.statehouse.gov.sc\nTo unsubscribe, visit:\nhttp://www.statehouse.gov.sc/newsalert/request-unsubscribe\n\n";
			
			
                        
                        $new_content_html = implode("", file(__DIR__ . "../../../resources/email/newsalert_top.php")) . $content_html . $unsub_html . implode("", file(__DIR__ . "../../../resources/email/newsalert_bottom.php"));
			$new_content_text = $content_text . $unsub_text;
			
                        //echo $new_content_html;
			
			$mail = new htmlMimeMail();
			$mail->setHtml($new_content_html, $new_content_text);
			
			
									
			$mail->setFrom('"State House Seychelles" <newsalertsh@statehouse.gov.sc>');
			$mail->setSubject("News Alert - " . $arr2["title"]);
			$mail->setHeader("Return-Path", "n.jack@statehouse.gov.sc");
			$mail->setHeader("Reply-To", "n.jack@statehouse.gov.sc");
			
			$mail->setSMTPParams('mail.egov.sc',25,'www.statehouse.gov.sc',true,'newsalertsh@statehouse.gov.sc','w3lc0m3');
			
//			$mailresult = $mail->send(array($arr["email"]));
//	
//			
//			if($mailresult){
//				$myquery = "update `newsalert` set sent_mail = '1', sent_date = now() where id = '" . $arr["id"] . "'";
//				$MySecResult = query($myquery);
//			}
			
		}
}

echo "<br><br>End";


?>