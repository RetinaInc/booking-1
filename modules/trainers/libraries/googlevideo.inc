<?php
class google {

  /*
   * constructor
   */
  function googlevideo() {
  }

  /*
   * @return
   * html to render youtube videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function google_video_html(&$url, $options = array()) {
    // change http://video.google.com/videoplay?docid=-2829745058296164658&hl=en to http://video.google.com/googleplayer.swf?docid=-2829745058296164658&h
    /*$ur=str_replace('videoplay','googleplayer.swf',$url);
    $url=rtrim($ur,"l=en");
    */
   preg_match("/docid=([^(\&|$)]*)/", $url, $matches);
   $videocode=$matches[1];
    
    $url="http://video.google.com/googleplayer.swf?docid=".$videocode;
    
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'google_video';
    $height = isset($options['height']) ? $options['height'] : '300';
    $width = isset($options['width']) ? $options['width'] : '350';
    $id = isset($options['id']) ? $options['id'] : 'google.video';
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

