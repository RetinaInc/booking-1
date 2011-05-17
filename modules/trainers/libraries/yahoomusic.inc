<?php
class yahoomusic{

  /*
   * constructor
   */
  function yahoomusic() {
  }

  /*
   * @return
   * html to render youtube videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function yahoomusic_video_html(&$url, $options = array()) {
	 $code1=explode('--',$url) ;
	 $code= $code1[1];
    
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'yahoomusic';
    $height = isset($options['height']) ? $options['height'] : '300';
    $width = isset($options['width']) ? $options['width'] : '350';
    $id = isset($options['id']) ? $options['id'] : 'yahoomusic';
    $fullscreen_value = isset($options['fullscreen']) ? $options['fullscreen'] : "false" ;

 
    

    $output = <<<FLASH
    <object width="400" height="255" id="uvp_fop" allowFullScreen="true">
              <param name="movie" value="http://d.yimg.com/m/up/fop/embedflv/swf/fop.swf"/>
              <param name="flashVars" value="id=v" .$code. "&amp;eID=1301797&amp;lang=us&amp;enableFullScreen=0&amp;shareEnable=1"/>
              <param name="wmode" value="transparent"/>
              <embed height="255" width="400" id="uvp_fop" allowFullScreen="true" src="http://d.yimg.com/m/up/fop/embedflv/swf/fop.swf" type="application/x-shockwave-flash" flashvars="id=v".$code."&amp;eID=1301797&amp;lang=us&amp;ympsc=4195329&amp;enableFullScreen=1&amp;shareEnable=1" /></object>
FLASH;





return $output;
}

function yahoomusic_video_feed($url)
{
	
$code1=explode('--',$url) ;
	 $code= $code1[1];
	 
	 
$thumbnail="http://d.yimg.com/img.music.yahoo.com/image/v1/video/".$code;

$feed ="<br>"."<img src = $thumbnail>";

return $feed;
}

   
   
    
  }
  
  
  
  
