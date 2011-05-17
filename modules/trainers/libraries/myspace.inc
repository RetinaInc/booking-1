<?php
class myspace {

  /*
   * constructor
   */
  function myspace() {
  }

  /*
   * @return
   * html to render myspace videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function myspace_html(&$url, $options = array()) {
    // change http//vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=101432953 to
    //        http://mediaservices.myspace.com/services/media/embed.aspx/m=101432953
    //http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=64105959
    // http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=41666942
    
    //$url=explode('=', "$url");
    $url=explode("videoid=",$url);
    $url="http://mediaservices.myspace.com/services/media/embed.aspx/m=".$url[1];
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'myspace';
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
