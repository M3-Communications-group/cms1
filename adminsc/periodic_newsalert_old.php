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


$query = "select * from `newsalert` where sent_mail = 0 order by id limit 13";

$result = query($query);
$sent_count = 0;
$error_count = 0;
$error_info = '';

while ($arr = mysqli_fetch_array($result)) {

    $content_html = "";
    $content_text = "";
    $q2 = 'select *, date_format(date, "%a, %d %M %Y") as mydate from m3site_news where id="' . $arr['news_id'] . '" and active = 1';
    $r2 = query($q2);
    
    if (mysqli_num_rows($r2) > 0) {


        $arr2 = mysqli_fetch_array($r2);
        $content_html .= '<font color="#1682A3" size="+1"><b>' . $arr2["title"] . "</b></font><br><br>\n";
        $content_text .= ($arr2["title"]) . "\n";
        if (!empty($arr2["photo_small"])) {
            $content_html .= '<img src="http://www.statehouse.gov.sc/' . $arr2["photo_small"] . '" alt="" border="0" style="display: block; float: left; width: 245px; margin: 0px 15px 3px 0px;">';
        }
        $big_photo_html = '';
        $big_photo_txt = '';
        if (!empty($arr2["photo_big"])) {
            $big_photo_html = '<br>For higher resolution photo <a href="http://www.statehouse.gov.sc/' . $arr2["photo_big"] . '" style="color: #000000; text-decoration: underline;">click here</a>';
            $big_photo_txt = '\nHigher resolution photo - http://www.statehouse.gov.sc/' . $arr2["photo_big"];
        }

        $content_html .= $arr2["mydate"] . "<br>\n";
        $content_html .= $arr2["text"] . "<br><div style=\"clear: both;\"></div>\n";
        $content_text .= striphtml($arr2["text"]) . "\n\n";

        $unsub_html = '<br><hr><FONT face="Verdana, Arial, Hevetica, sans-serif" size="1" style="font-size: 10px;" color="#000000">For media enquiries please contact Nadine Jack on <a href="mailto:n.jack@statehouse.gov.sc">n.jack@statehouse.gov.sc</a>' . $big_photo_html . '<br><br>This message is sent to you, because you are registered for news from www.statehouse.gov.sc<br>To unsubscribe, <a href="http://www.statehouse.gov.sc/newsalert/request-unsubscribe" target="_blank" style="color: #000000; text-decoration: underline;">click here</a>.</font>';
        $unsub_text = "\n\nFor media enquiries please contact Nadine Jack on n.jack@statehouse.gov.sc" . $big_photo_txt . "\n\nThis message is sent to you, because you are registered for news from www.statehouse.gov.sc\nTo unsubscribe, visit:\nhttp://www.statehouse.gov.sc/newsalert/request-unsubscribe\n\n";

        $new_content_html = implode("", file(__DIR__ . "../../../resources/email/newsalert_top.php")) . $content_html . $unsub_html . implode("", file(__DIR__ . "../../../resources/email/newsalert_bottom.php"));
        $new_content_text = $content_text . $unsub_text;
             
        $mail = new PHPMailer();
        
        $mail->CharSet = 'utf-8';

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Set the hostname of the mail server
        $mail->Host = '196.13.208.12';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 25;
        //Whether to use SMTP authenticatio
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
        //Username to use for SMTP authentication
        $mail->Username = 'newsalertsh@ad.gov.sc';
        //Password to use for SMTP authentication
        $mail->Password = 'w3lc0m3';
        //Set who the message is to be sent from
        $mail->setFrom('newsalertsh@statehouse.gov.sc', 'State House Seychelles');
        //Set an alternative reply-to address
        $mail->addReplyTo('n.jack@statehouse.gov.sc', 'Nadine Jack');
        //Set who the message is to be sent to
        $mail->addAddress($arr["email"]);
        
        //echo $arr["email"] . '<br>';
        
        //Set the subject line
        $mail->Subject = "News Alert - " . remove_french_accents($arr2["title"]);
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($new_content_html);
        //Replace the plain text body with one created manually
        //$mail->AltBody = $new_content_text;
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        
        if (!$mail->send()) {
            $error_info .= $mail->ErrorInfo;
            $error_count = $error_count + 1;
        } else {
            $sent_count = $sent_count + 1;

            $myquery = "update `newsalert` set sent_mail = '1', sent_date = now() where id = '" . $arr["id"] . "'";
            $MySecResult = query($myquery);
        }
    }
}

echo $sent_count .  " messages sent.<br>";
echo $error_count .  " not send.";
if($error_info){
    echo 'Error info: ' . $error_info . '<br>';
}