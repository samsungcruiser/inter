<?php


	@require_once('../../../../../wp-load.php');
		$eventid =  $_POST['eventid'];
		$action = "fetch";
		
		if($action=="fetch"){
			global $wpdb;
			$table_name = $wpdb->prefix."em_main";
			
			
			
			$results = $wpdb->get_results($wpdb->prepare("select * from ".$table_name." where em_id=%d",array($eventid)));	
				echo '<div class="event_title">'.$results[0]->em_title.'</div>
				<div class="event_description"><em>Description:</em> '.$results[0]->em_desc.'</div>
				<div class="event_venue"><em>Venue:</em> '.$results[0]->em_venue.'</div>
				<div class="event_time"><em>Time:</em> '.$results[0]->em_time.'</div>
				
				
				
				
				';
				
				//echo $qry;
			 	
		}

	


?>