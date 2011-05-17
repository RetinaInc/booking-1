<?php
class Youtube {

  /*
   * constructor
   */
  function Youtube() {
  }

  /*
   * @return
   * html to render youtube videos
   * @url
   * string url to video
   * @options
   * array containing video height, width, autoplay etc
   */
  function youtube_video_html(&$url, $options = array()) {
    // change http://www.youtube.com/watch?v=28G9aAnA2RI to http://www.youtube.com/v/28G9aAnA2RI
    preg_match("/v=([^(\&|$)]*)/", $url, $matches);
    $videocode=$matches[1];
    $url= "http://www.youtube.com/v/".$videocode;
    //$url = str_replace('watch?v=', 'v/', $url);
    $div_id = isset($options['div_id']) ? $options['div_id'] : 'youtube_video';
    $height = isset($options['height']) ? $options['height'] : '135';
    $width = isset($options['width']) ? $options['width'] : '224';
    $id = isset($options['id']) ? $options['id'] : 'youtube';
    $fullscreen_value = isset($options['fullscreen']) ? $options['fullscreen'] : "false" ;

    $output = <<<FLASH
        <div id="$div_id">
          <object width="$width" height="$height">
            <param name="movie" value="$url"></param>
            <param name="allowFullScreen" value="false"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed src="$url" type="application/x-shockwave-flash" allowscriptaccess="always" 
                allowfullscreen="false" width="$width" height="$height"></embed>
          </object>
      </div>


FLASH;
return $output;
}

function youtube_video_feed($url)
{
	preg_match("/v=([^(\&|$)]*)/", $url, $matches);
    $videocode1=$matches[1];
$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$videocode1;

$sxml = simplexml_load_file($feedURL);

//$feed = array('content' => $sxml->content,
//'author' => $sxml->author);

//'published' => $sxml->published,
//'updated' => $sxml-> updated);

$feed = "<img src= 'http://img.youtube.com/vi/".$videocode1."/2.jpg'>".$sxml->author->name."<br>".$sxml->content;
return $feed;
/*return array('content' => $sxml->content,
'author' => $sxml->author) ;
   // return $sxml->title;
   // return $sxml->content;
//return "<img src='http://img.youtube.com/vi/".$videocode."/2.jpg'>";
*/
}

    
  
}
