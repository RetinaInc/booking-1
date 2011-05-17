<?php
class guba {

  /*
   * constructor
   */
  function guba() {
  }

  /*
   * @return
   * html to render guba videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function guba_html(&$url, $options = array()) {
    
  $url1=explode('/',$url);
  //http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/3000005670/addvideo.flv
  $url = "http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/".$url1[4]."/addvideo.flv";
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
