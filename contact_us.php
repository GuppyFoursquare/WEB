<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
include("prepend.php");
//error_reporting(E_ALL);
$news_str = (isset($_GET['r']) ? $_GET['r'] : '');
//echo $news_str;die;
$formData = array();
$_SESSION['is_most_popular'] = 0;
$header_title = "YOUBAKU | Contact us";
function fetchNewsSpecials($obj,$news_str = '',$page = 0){
    
    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active,news_created_on ";
    $where = " news_is_active  = 1 AND news_is_delete = 0";
    if(!empty($news_str))
        $where = " news_is_active  = 1 AND news_is_delete = 0 AND news_page_url= '".$news_str."' ";
    
    $limit = 5;
    if($page > 0){
        $page = $page - 1;
        $page = $page * $limit;
    }
    //echo $page;die;
    $where .= " ORDER BY news_id DESC  LIMIT ".$page.",".$limit;
    
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $newsArr;
}

function countAllNewsSpecial($obj,$news_str = ''){
    
    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active,news_created_on ";
    $where = " news_is_active  = 1 AND news_is_delete = 0";
    if(!empty($news_str))
        $where = " news_is_active  = 1 AND news_is_delete = 0 AND news_page_url= '".$news_str."' ";
    
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return count($newsArr);
}


//$query = "SELECT faq_id,faq_question,faq_answer FROM yb_faq WHERE faq_is_active = 1 AND faq_is_delete = 0 ORDER BY faq_sequence ASC";
//$faqs = mysql_query($query);
//$rows = mysql_num_rows($faqs);


$pagingpagename = "news/".$news_str."/";
$noofrecords = countAllNewsSpecial($obj);
$page = 0;
$pagesize = 5;
 $CURR_URI = $_SERVER['REQUEST_URI'];
 $CURR_URI = explode('?', $CURR_URI);
 if(array_key_exists(1,$CURR_URI)){
     $CURR_URI = explode('=', $CURR_URI[1]);
     $page = $CURR_URI[1];
 }
$extra_parameters = "";

// news listing...
$newsS = fetchNewsSpecials($obj,'',$page);

// news details.

//include 'ajax.places.php';

if(!empty($_POST)){
    $name = isset($_POST['member_name']) ? $_POST['member_name'] : '';
    $email = isset($_POST['member_email']) ? $_POST['member_email'] : '';
    $phone = isset($_POST['member_phone']) ? $_POST['member_phone'] : '';
    $subject = isset($_POST['member_subject']) ? $_POST['member_subject'] : '';
    $message = isset($_POST['member_message']) ? $_POST['member_message'] : '';
    
    if($name != '' && $email != '' && $phone != '' && $subject != '' && $message != '')
    {
        //Mail to Youbaku admin.
        
        $to = "Youbaku admin <youbaku@hotmail.com>";
        $subject = $subject;
        $msg = "Hello admin,  <br/><br/> ".
                "The following user has posted an inquiry <br/>The details are as follows.<br/><br/>".
                "Name: ".$name."<br/>
                 Email: ".$email."<br/>
                 Phone: ".$phone."<br/>
                 Subject: ".$subject."<br/>
                 Message: ".$message."<br/>
                 <br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
        $headers = "MIME-Version: 1.0" . "\r\n".
                   "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                   "From: Youbaku".'<'.$email.'>'."\r\n" .
                   "Reply-To:".$name.'<'.$email.'>'.' \r\n'. 
                   "X-Mailer: PHP/" . phpversion();

        $mail_sent = mail($to,$subject,$msg,$headers);
        
        
        //Mail to the sender acknowledging confirmation.
        
        $to = $email;
        $subject = "Youbaku inquiry";
        $msg = "Hello ".$name.",  <br/><br/> Thank you for your valuable feedback. We will get back to you soon.<br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
        $headers = "MIME-Version: 1.0" . "\r\n".
                   "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                   "From: Youbaku <noreply@youbaku.az>" . "\r\n" .
                   "Reply-To: Youbaku admin <youbaku@hotmail.com>" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        $mail_sent = mail($to,$subject,$msg,$headers);
        
        if($mail_sent)
        {
            $_SESSION['sucess_message'] = "Your inquiry sent successfully.";
        }
        else
        {
            $_SESSION['error_message'] = "Cannot send mail. Server configuration error.";
        }
    }
    else
    {
        $_SESSION['error_message'] = 'Please enter all the mandatory fields.';
    }
    
}


include("template/contact_us.php");
?>
