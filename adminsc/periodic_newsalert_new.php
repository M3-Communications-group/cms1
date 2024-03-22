<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "inc/functions_site.php";
require "inc/functions_cms.php";
require('inc/mysql_connect.php');
ini_set("display_errors", 1);
ini_set('max_execution_time', 180); //240 seconds = 4 minutes

require 'inc/PHPMailer6/src/Exception.php';
require 'inc/PHPMailer6/src/PHPMailer.php';
require 'inc/PHPMailer6/src/SMTP.php';

$sent_count = 0;
$error_count = 0;
$error_info = '';

// Ако някой скрипт е зациклил 
$query = "UPDATE `newsalert` SET status = 'idle', last_status_change =  now() "
        . "WHERE status = 'reading' AND last_status_change < date_sub(now(), interval 20 minute)"; // 20 minutes
$result = query($query);

// Има ли в опашката неизпратени мейли, които не се обработват в момента
$query_newsalert = "SELECT * FROM `newsalert` WHERE sent_mail = 0 AND status = 'idle' "
        . "ORDER BY id LIMIT 13";
$result_newsalert = query($query_newsalert);

// Маркиране като обработващи се
while ($arr_newsalert = mysqli_fetch_array($result_newsalert)) {
    $update_query_newsalert = "UPDATE `newsalert` SET status = 'reading', last_status_change =  now() "
        . "WHERE id = '" . $arr_newsalert["id"] . "'";
    $update_result_newsalert = query($update_query_newsalert);
}
mysqli_data_seek($result_newsalert,0);

while ($arr_newsalert = mysqli_fetch_array($result_newsalert)) {
   
    $content_html = "";
    $content_text = "";
    
    // Има ли активна новина с ID-то от опашката..... Ако новината се направи неактивна изпращането може да се спре?!?
    $news_query = 'SELECT *, date_format(date, "%a, %d %M %Y") AS mydate '
            . 'FROM m3site_news WHERE id="' . $arr_newsalert['news_id'] . '" AND active = 1';
    $news_result = query($news_query);
    
    if (mysqli_num_rows($news_result) > 0) {
      
        $arr_news = mysqli_fetch_array($news_result);
        $content_html .= '<font color="#1682A3" size="+1"><b>' . $arr_news["title"] . "</b></font><br><br>\n";
        $content_text .= ($arr_news["title"]) . "\n";
        if (!empty($arr_news["photo_small"])) {
            $content_html .= '<img src="http://www.statehouse.gov.sc/' . $arr_news["photo_small"] . '" alt="" border="0" style="display: block; float: left; width: 245px; margin: 0px 15px 3px 0px;">';
        }
        $big_photo_html = '';
        $big_photo_txt = '';
        if (!empty($arr_news["photo_big"])) {
            $big_photo_html = '<br>For higher resolution photo <a href="http://www.statehouse.gov.sc/' . $arr_news["photo_big"] . '" style="color: #000000; text-decoration: underline;">click here</a>';
            $big_photo_txt = '\nHigher resolution photo - http://www.statehouse.gov.sc/' . $arr_news["photo_big"];
        }

        $content_html .= $arr_news["mydate"] . "<br>\n";
        $content_html .= $arr_news["text"] . "<br><div style=\"clear: both;\"></div>\n";
        $content_text .= striphtml($arr_news["text"]) . "\n\n";

        $unsub_html = '<br><hr><FONT face="Verdana, Arial, Hevetica, sans-serif" size="1" style="font-size: 10px;" color="#000000">For media enquiries please contact Nadine Jack on <a href="mailto:n.jack@statehouse.gov.sc">n.jack@statehouse.gov.sc</a>' . $big_photo_html . '<br><br>This message is sent to you, because you are registered for news from www.statehouse.gov.sc<br>To unsubscribe, <a href="http://www.statehouse.gov.sc/newsalert/request-unsubscribe" target="_blank" style="color: #000000; text-decoration: underline;">click here</a>.</font>';
        $unsub_text = "\n\nFor media enquiries please contact Nadine Jack on n.jack@statehouse.gov.sc" . $big_photo_txt . "\n\nThis message is sent to you, because you are registered for news from www.statehouse.gov.sc\nTo unsubscribe, visit:\nhttp://www.statehouse.gov.sc/newsalert/request-unsubscribe\n\n";

        $new_content_html = implode("", file(__DIR__ . "../../../resources/email/newsalert_top.php")) . $content_html . $unsub_html . implode("", file(__DIR__ . "../../../resources/email/newsalert_bottom.php"));
        $new_content_text = $content_text . $unsub_text;
             
        $mail = new PHPMailer();
        
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();                //Tell PHPMailer to use SMTP
        $mail->SMTPDebug = 0;           //Enable SMTP debugging
                                        // 0 = off (for production use)
                                        // 1 = client messages
                                        // 2 = client and server messages
                                
        $mail->Host = '196.13.208.12'; //Set the hostname of the mail server
        $mail->Port = 25;               //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->SMTPAuth = false;        //Whether to use SMTP authentication
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;     //Username to use for SMTP authentication
       
        $mail->Username = 'newsalertsh@ad.gov.sc';
        $mail->Password = 'w3lc0m3';
        $mail->setFrom('newsalertsh@statehouse.gov.sc', 'State House Seychelles');
        $mail->addReplyTo('n.jack@statehouse.gov.sc', 'Nadine Jack');
        $mail->addAddress($arr_newsalert["email"]); //Set who the message is to be sent to
        $mail->Subject = "News Alert - " . remove_french_accents($arr_news["title"]);
        
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($new_content_html);
      
        //send the message, check for errors 
       
        if (!$mail->send()) {
            $error_info .= '<br>'. $mail->ErrorInfo;
            $error_count = $error_count + 1;
            
            $query = "UPDATE `newsalert` SET status = 'idle', "
                    . "last_status_change =  now() WHERE id='" . $arr_newsalert['id'] ."'";
            $result = query($query);
            
        } else {
            $sent_count = $sent_count + 1;
            $query = "UPDATE `newsalert` SET sent_mail = '1', sent_date = now(), "
                    . "status = 'idle', last_status_change =  now() WHERE id = '" . $arr_newsalert["id"] . "'";
            $result = query($query);
        }
    }
}

echo $sent_count .  " messages sent.<br>";
echo $error_count .  " not send.<br><br>";
if($error_info){
    echo 'Error info: ' . $error_info . '<br>';
}