<?php
class livevideo {

  /*
   * constructor
   */
  function livevideo() {
  }

  /*
   * @return
   * html to render guba videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function livevideo_html(&$url, $options = array()) {
    //http://www.livevideo.com/video/9E77A4AC44DA41848E64A7949009C94E/flintoff-shows-off-his-koala-b.aspx
    //http://www.livevideo.com/flvplayer/embed/9E77A4AC44DA41848E64A7949009C94E"
    
    $url1=explode('/', $url);
    $url= "http://livevideo.com/flvplayer/embed/".$url1[4];
    
    
  
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'guba';
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
            <embed src="$url" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed>
          </object>
      </div>
FLASH;
    return $output;
  }
}
