<?php
class Vimeo {

  /*
   * constructor
   */
  function Vimeo() {
  }

  /*
   * @return
   * html to render vimeo videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function vimeo_video_html(&$url, $options = array()) {
    
    // change http://www.vimeo.com/7043990
    // to http://vimeo.com/moogaloop.swf?clip_id=7043990&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=19a3ff&amp;fullscreen=1
    $url = str_replace('http://www.vimeo.com/','',$url);
    $url = "http://vimeo.com/moogaloop.swf?clip_id=$url&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=19a3ff&amp;fullscreen=1";

    $div_id = isset($options['div_id']) ? $options['div_id'] : 'vimeo_video';
    $height = isset($options['height']) ? $options['height'] : '300';
    $width = isset($options['width']) ? $options['width'] : '350';
    $id = isset($options['id']) ? $options['id'] : 'vimeo';
    $fullscreen_value = isset($options['fullscreen']) ? $options['fullscreen'] : "false" ;
    
    $output = <<<FLASH
        <div id="$div_id">
        <object width="$width" height="$height">
            <param name="allowfullscreen" value="$fullscreen_value" />
            <param name="allowscriptaccess" value="always" />
            <param name="movie" value="$url" />
            <embed
                src="$url"
                type="application/x-shockwave-flash"
                allowfullscreen="$fullscreen_value"
                allowscriptaccess="always"
                width="$width"
                height="$height">
            </embed>
        </object>
FLASH;
        
        
        
        return $output;
  }
}
