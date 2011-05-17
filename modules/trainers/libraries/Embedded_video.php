<?php

/**
 * Super Class
 * @package Embedded Video
 * @author Sivaji
 * @link
 */

class Embedded_video {

  /*
   * constructor
   */
  function Embedded_video() {
    // do nothing
  }

  /*
   * @return
   * HTML tags to display video
   */
  function get_video($url, $options = array()) {
    $url_info = $this->get_url_info($url);
    if ($url_info === false) {
      return false;
    }
    return $this->get_video_html($url_info['provider'], $url, $options);
  }
  
  function get_feed($url){
	  $url_info = $this->get_url_info($url);
	  if ($url_info === false){
		  
		  return false ;
		  
	  }
	  
	  return $this->get_video_feed($url_info['provider'], $url);
	  
	  }
	  
	  
	  
	  function get_video_feed($provider,$url){
		  
		  $feed = '';
		  switch($provider){
			 case 'youtube' :
			  include_once('Youtube.inc');
			  $youtube = new Youtube();
			  $feed = $youtube->youtube_video_feed($url);
			  break;
			 case 'dailymotion':
	            include_once('dailymotion.inc');
	            $dailymotion=new Dailymotion();
	            $feed = $dailymotion->dailymotion_video_feed($url);
	            break; 
	            
	         case 'new':
		        include_once('yahoomusic.inc');
		        $yahoomusic=new yahoomusic();
		        $feed= $yahoomusic->yahoomusic_video_feed($url);
		        break;
			  }
			  
			 
			  return $feed;
		  
		  
		  
		  }

  /*
   * @function
   * include the provider handler function .inc file.
   */
  function get_video_html($provider, $url, $options = array()) {
    $output = '';
    switch ($provider) {
      case 'youtube':
        include_once('Youtube.inc');
        $youtube = new Youtube();
        $output = $youtube->youtube_video_html($url, $options);
        //$feed = $youtube->youtube_video_feed($url);
        break;
      case 'video':
        include_once('googlevideo.inc');
        $google = new Google();
        $output = $google->google_video_html($url,$options);
        break;
	case 'dailymotion':
	  include_once('dailymotion.inc');
	  $dailymotion=new Dailymotion();
	  $output = $dailymotion->dailymotion_html($url,$options);
	  break;
	case 'vids':
		include_once('myspace.inc');
		$myspace=new Myspace();
		$output = $myspace->myspace_html($url,$options);
		break;
		
	case 'guba':
		include_once('guba.inc');
		$guba=new guba();
		$output= $guba->guba_html($url,$options);
		break;
    case 'tudou':
		include_once('todou.inc');
		$todou=new todou();
		$output= $todou->todou_html($url,$options);
		break;
		
	case 'livevideo':
		include_once('livevideo.inc');
		$livevideo=new livevideo();
		$output= $livevideo->livevideo_html($url,$options);
		break;
	case 'in':
		include_once('sevenload.inc');
		$sevenload=new sevenload();
		$output=$sevenload->sevenload_html($url,$options);
		break;
	
	case 'new':
		include_once('yahoomusic.inc');
		$yahoomusic=new yahoomusic();
		$output= $yahoomusic->yahoomusic_video_html($url,$options);
		break;
		
	case 'vimeo':
        include_once('vimeo.inc');
        $vimeo = new Vimeo();
        $output = $vimeo->vimeo_video_html($url,$options);
        break; 

		
		
		
      default:
        show_error('Unsupported Video provider');
    }
    return $output;
  }

  /*
   * @function
   * validates, extracts components of the url
   * $url
   * string url
   * @return
   * array containing hostname, schema etc
   */
  function get_url_info($url) {
    $url_info = array();

    // checks for empty url
    if (empty($url)) {
      show_error('URL is empty !!');
      return false;
    }

    // generates array containing hostname, schema etc from url
    $url_info = parse_url($url);
    if (count($url_info) == 1) {
      show_error('Invalid URL');
      return false;
    }

    $host_name = explode('.', $url_info['host']);
    $url_info['provider'] = ($host_name[0] !== 'www') ? $host_name[0]: $host_name[1];
    return $url_info;
  }
}
