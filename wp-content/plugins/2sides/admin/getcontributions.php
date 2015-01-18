<?php 
function my_action() {
	global $wpdb;
	$page = $_POST["page"];
	$tid = $_POST["tid"];
	$limit = 5 ;
	$start = ($page-1)*$limit;
	$table_name = $wpdb->prefix . "2s_contributions";
	$dataReturn[1] = $wpdb->get_results("SELECT * FROM $table_name WHERE  /*cstatus =3  AND*/ tid =$tid AND type = 1 LIMIT $start,$limit");
    $dataReturn[0] = $wpdb->get_results("SELECT * FROM $table_name WHERE  /*cstatus =3 AND*/ tid =$tid AND type = 0 LIMIT $start,$limit");
	    
	$agree = '';
	$disagree = '';
	$agreecount = 0;
	$disagreecount = 0;

	foreach($dataReturn[1] as $key => $val )
	{
		$agreecount++;
		$userinfo = get_userdata($val->uid); 	
		$agree.='<div class="comment span well" id="'.$val->cid.'"><p>'.'<b>'.ucfirst($userinfo->data->user_nicename).'</b> : &nbsp;&nbsp;'.$val->contribution.'</p><span class="popularity"><b class="like_current" > Likes </b> <e class="like_count_'.$val->cid.'">'.$val->likes.' </e> <b class="dislike_current"> Dislike</b> <e class="dislike_count_'.$val->cid.'">'.$val->dislikes.'<e></span><span id="pub_date"> '.date("h:i a",strtotime($val->created_on)).' On '.date("<b> M-d </b>",strtotime($val->created_on)).'</span></div>';
	}

	foreach($dataReturn[0] as $key => $val )
	{
		$disagreecount++;
		$userinfo = get_userdata($val->uid);
		$disagree.='<div class="comment span well" id="'.$val->cid.'"><p>'.'<b>'.ucfirst($userinfo->data->user_nicename).'</b> : &nbsp;&nbsp;'.$val->contribution.'</p><span class="popularity"><b class="like_current" > Likes </b> <e class="like_count_'.$val->cid.'">'.$val->likes.' </e> <b class="dislike_current"> Dislike</b> <e class="dislike_count_'.$val->cid.'">'.$val->dislikes.'<e></span><span id="pub_date"> '.date("h:i a",strtotime($val->created_on)).' On '.date("<b> M-d </b>",strtotime($val->created_on)).'</span></div>';
	} ?>

	<?= $agree."!8@~!!@!" ?>

	<?= $disagree."!8@~!!@!".$agreecount."!8@~!!@!".$disagreecount ?>
		
	<?php
	die();
}

add_action('wp_ajax_my_action', 'my_action');
add_action('wp_ajax_nopriv_my_action', 'my_action');

?>