<?php
class todou {

  /*
   * constructor
   */
  function todou() {
  }

  /*
   * @return
   * html to render guba videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function todou_html(&$url, $options = array()) {
    //http://www.tudou.com/programs/view/Z36IUvNCZ9o to http://www.tudou.com/player/outside/player_outside.swf?iid=31494340&default_skin=http://js.tudouui.com/bin/player2/outside/Skin_outside_17.swf&autostart=false&rurl=
    $url1=explode('/',$url);
    $url="http://www.tudou.com/player/outside/player_outside.swf?iid=".$url1[5]."&default_skin=http://js.tudouui.com/bin/player2/outside/Skin_outside_17.swf&autostart=false&rurl=";
    
  
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'todou';
    $height = isset($options['height']) ? $options['height'] : '300';
    $width = isset($options['width']) ? $options['width'] : '350';
    $id = isset($options['id']) ? $options['id'] : 'todou';
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
