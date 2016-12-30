<?php


require 'steamauth/steamauth.php';
require 'steamauth/userInfo.php';


    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
    	 case('getState'):
        	 if(file_exists('chat.txt')){
               $lines = file('chat.txt');
        	 }
             $log['state'] = count($lines); 
        	 break;	
    	
    	 case('update'):
        	$state = $_POST['state'];
        	if(file_exists('chat.txt')){
        	   $lines = file('chat.txt');
        	 }
        	 $count =  count($lines);
        	 if($state == $count){
        		 $log['state'] = $state;
        		 $log['text'] = false;
        		 
        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                         $text[] =  $line = str_replace("\n", "", $line);
        				   }
         
                        }
        			 $log['text'] = $text; 
        		 }
        	  
             break;
    	 
    	 case('send'):
		  $nickname = htmlentities(strip_tags($steamprofile['personaname']));
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_POST['message']));
		 if(($message) != "\n"){
        	
			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				} 
                         if($steamprofile['steamid'] == "76561198330715386" || $steamprofile['steamid'] == "76561198313288771")
						{
 									$message=addemotes($message,$admin,$premium,$steamid);

        	 fwrite(fopen('chat.txt', 'a'), "<h6 style=' color: #f44336;'><img src=".$steamprofile['avatar']."></img>    [Admin] "  . $nickname . "</h6> "  . $message = str_replace("\n", " ",  $message) . "\n"); 
                            
                        }
                        
                          else  if($steamprofile['steamid'] == "0" || $steamprofile['steamid'] == "0")
						{
 									$message=addemotes($message,$admin,$premium,$steamid);

        	 fwrite(fopen('chat.txt', 'a'), "<h6 style=' color: #9b59b6;'><img src=".$steamprofile['avatar']."></img>    [YT] "  . $nickname . "</h6> "  . $message = str_replace("\n", " ",  $message) . "\n"); 
                            
                        }
        	                      else
        	                      {
									$message=addemotes($message,$admin,$premium,$steamid);

        				         	 fwrite(fopen('chat.txt', 'a'), "<h6><img src=".$steamprofile['avatar']."></img> "  . $nickname . "</h6> "  . $message = str_replace("\n", " ",  $message) . "\n"); 
        	                      }

		 }
        	 break;
    	
    }

    
    echo json_encode($log);

function addemotes($message,$admin,$premium,$steamid)
{
	$emotes = array
	(
		/*
		Emote name
		Emote extension
		Type: 0=Public | 1=Premium | 2=Admin
		Preferred width
		*/
		
		array(":Kappa","png",0,25),
		array(":BibleThump","png",0,25),
		array(":PogChamp","png",0,25),
		array(":DonaldTrump","png",0,25),
	 );
	
	foreach($emotes as $e)
	{
	    			$width=$e[3];

		if($steamprofile['steamid'] == "")
		{
			$message=str_ireplace($e[0], "<img width='$width'src='/emotes/".$e[0].".".$e[1]."' title='".$e[0]."'>", $message);
			continue;
		}
	}
	return $message;
}
?>