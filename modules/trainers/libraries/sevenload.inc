<?php
class sevenload {

  /*
   * constructor
   */
  function sevenload() {
  }

  /*
   * @return
   * html to render guba videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function sevenload_html(&$url, $options = array()) {
	  //http://in.sevenload.com/videos/5TtIXUg-The-timelapse-alone
    //http://www.livevideo.com/video/9E77A4AC44DA41848E64A7949009C94E/flintoff-shows-off-his-koala-b.aspx
    //http://www.livevideo.com/flvplayer/embed/9E77A4AC44DA41848E64A7949009C94E"
    
    //$url="http://freevideocoding.com/flvplayer.swf?file=".$url;
    $url1=explode('-',$url);
    $url2=explode('/',$url1[0]);
    $videocode=$url2[4];
    $url="http://in.sevenload.com/pl/".$videocode."/500x314/0";
    //print_r($url1);
    //print_r($videocode);    
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'sevenload';
    $height = isset($options['height']) ? $options['height'] : '300';
    $width = isset($options['width']) ? $options['width'] : '350';
    $id = isset($options['id']) ? $options['id'] : 'youtube';
    $fullscreen_value = isset($options['fullscreen']) ? $options['fullscreen'] : "false" ;

    $output = <<<FLASH
        <div id="$div_id">
          <object width="$width" height="$height">
            <param name="movie" value="$url"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
                <script type="text/javascript" src= $url ></script><p>Link: <a href="http://in.sevenload.com/videos/".$videocode."-The-timelapse-alone"><img src="http://static.sevenload.net/img/sevenload.png" width="66" height="10" alt="The timelapse alone" /></a></p>
          </object>
      </div>
FLASH;
    
    return $output;
    
  
    
  }
}
