<?php
class dailymotion {

  /*
   * constructor
   */
  function dailymotion() {
  }

  /*
   * @return
   * html to render youtube videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function dailymotion_html(&$url, $options = array()) {
    // convert http://www.dailymotion.com/video/x7i25v_sanath-jayasuriya-125-v-india-final_sport to http://www.dailymotion.com/swf/x7i25v_sanath-jayasuriya-125-v-india-final_sport&related=1
    //$ur=str_replace('video','swf',$url);
    //$url=$ur."&related=1";
    $str1 = explode("video/", $url);
	$video_id = '';
	if(strstr($str1[1], "/"))
	{
		$str2 = explode("/", $str1[1]);
		$video_id = $str2[0];
	}
	else
		$video_id = $str1[1];
	
	
	
	$url="http://www.dailymotion.com/swf/".$video_id;
    
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'dailymotion';
    $height = isset($options['height']) ? $options['height'] : '300';
    $width = isset($options['width']) ? $options['width'] : '350';
    $id = isset($options['id']) ? $options['id'] : 'dailymotion';
    $fullscreen_value = isset($options['fullscreen']) ? $options['fullscreen'] : "false" ;

    $output = <<<FLASH
        <div id="$div_id">
          <object width="$width" height="$height">
            <param name="movie" value="$url"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed src="$url" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed>
          </object>
      </div>
FLASH;
    return $output;
  }
  
  function dailymotion_video_feed($url)
{
	
	$str1 = explode("video/", $url);
	$video_id = '';
	if(strstr($str1[1], "/"))
	{
		$str2 = explode("/", $str1[1]);
		$video_id = $str2[0];
	}
	else
		$video_id = $str1[1];

$feedurl="http://www.dailymotion.com/rss/video/".$video_id;

$curl = curl_init();

# CURL SETTINGS.
curl_setopt($curl, CURLOPT_URL, $feedurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

# GRAB THE XML FILE.
$xmlTwitter = curl_exec($curl);

curl_close($curl);

# SET UP XML OBJECT.
$xmlObjTwitter = simplexml_load_string( $xmlTwitter );



foreach ( $xmlObjTwitter -> channel -> item as $item )
{
        $title = $item -> title;
        // $item -> link;
        $media = $item->xpath('//media:title');
        // echo $media[0];
        $desc = $item->xpath('//media:thumbnail/@url');
        //echo "<img src =$desc[0]>";
        $summary = $item->xpath('//itunes:summary');
    }
  

$feed= "<img src =$desc[0]>"."<br>".$title."<br>".$summary[0];
return $feed;
	
	
	
/*	
$feedurl = "http://www.dailymotion.com/rss/video/".$video_id;


if(ini_get('allow_url_fopen') == 1)
	{
		$feed = @file($video_id);
		if($feed === false)
			$error = 1;
	}
	/*if( (ini_get('allow_url_fopen') == 1 && $error == 1) || ini_get('allow_url_fopen') == 0)
	{
		if(function_exists('curl_init'))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $feedurl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
			$feed = curl_exec($ch);
			$errormsg = curl_error($ch);
			curl_close($ch);
			
			if($errormsg != '')
			{
				echo $errormsg;
				return false;
			}
		}
	}
	if(!is_array($feed))
	{
		$feed = explode("\n", $feed);
	}
	
	//	cleanup
	$buff_arr = array();
	$i = 0;
	foreach($feed as $k => $v)
	{
		$v = trim($v, " \t\r\n");
		if($v != '')
			$buff_arr[$i++] = $v;
			print_r($buff_arr);
	}
	
print_r($feed);*/


}
  
}

