<?php
function getSongsDetails($link,$albumId,$limits) {
  $getSongs = "select * from song where album_id='$albumId' order by album_track_nr asc limit $limits";
  $result3 = mysqli_query($link, $getSongs);
  while($gotS = mysqli_fetch_assoc($result3)) {
    $songPosition = $gotS['album_track_nr'];
    $songLink = $gotS['song_link'];
    $playlistDetails = strtolower($gotS['playlist_details']);
    $playlistDetails2 = strtolower($gotS['playlist_details_2']);
    array_push($songTitles, $gotS['song_title']);
    array_push($songDurations, $gotS['song_duration']);
    array_push($songLyrics, $gotS['song_lyrics']);
    array_push($songFiles, $gotS['song_file']);
    echo "        <li><a id='pl".$songPosition."' href='".$pathName.$songLink."'>".$songPosition.". ".$gotS['song_title']." <span>".$gotS['song_duration']."</span></a>
    <p class='playlist-detail'>".$playlistDetails."<span class='playlist-detail-2'><br />".$playlistDetails2."</span></p></li>
  ";
  }
}

$band = "natch";
$album = "consolations";
$year = "2015";
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path = parse_url($url, PHP_URL_PATH);
$pathFragments = explode("/", $path);
$song = end($pathFragments);
$songLinks = array();
$songLyrics = array();
$songDurations = array();
$songTitles = array();
$songFiles = array();
include "../../dbconfig_natch.inc.php";
$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("Error " . mysqli_error($link));

$getAlbum = "select * from album where band_name='$band' and album_name='$album';";
$resAlbum = mysqli_query($link, $getAlbum);

while($gotAlbum = mysqli_fetch_assoc($resAlbum)) {
  $albumId = $gotAlbum['id'];
  $defaultSong = $gotAlbum['default_song'];
  $fileName = $gotAlbum['file_name'];
  $mediaDirectory = $gotAlbum['media_directory'];
  $pathName = $gotAlbum['url_path'];
  $fontFile = $gotAlbum['font_file'];
  $coverBgImage = $gotAlbum['cover_bg_image'];
  $flipBgImage = $gotAlbum['flip_bg_image'];
  $coverInfoCopy = $gotAlbum['cover_info_copy'];
  $coverInfoCopyright = $gotAlbum['cover_info_copyright'];
  $flipCopy = $gotAlbum['flip_copy'];
  $flipCopyTopMargin = $gotAlbum['flip_copy_top_margin'];
  $lyricsColor =  $gotAlbum['lyrics_color'];
  $lyricsHoverColor =  $gotAlbum['lyrics_hover_color'];
  $linkColor =  $gotAlbum['link_color'];
  $linkHoverColor =  $gotAlbum['link_hover_color'];
  $linkShadowColor =  $gotAlbum['link_shadow_color'];
}

$getSongLinks = "select song_link from song where album_id='$albumId';";
$resSongLinks = mysqli_query($link, $getSongLinks);
while($gotSongLinks = mysqli_fetch_assoc($resSongLinks)) {
  $songLinks[] = $gotSongLinks["song_link"];
}
if(($song == "")||($song == "index.php")) { $song = $defaultSong;}
if(in_array($song,$songLinks)) {
  $getSong = "select * from song where album_id='$albumId' and song_link='$song'";
  $resSong = mysqli_query($link, $getSong);
} else {
  header("HTTP/1.1 404 Not Found");
  include("../404.php");
  exit;
}
while($gotSong = mysqli_fetch_assoc($resSong)) {
  $songFile = $gotSong['song_file'];
  $songLyric = trim($gotSong['song_lyrics']);
  $songTitle = $gotSong['song_title'];
  $pageDescription = $gotSong['song_title'];
}

$pageTitle = $band."::".$album."::".$songTitle;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $pageTitle; ?></title>
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<style type="text/css">
@font-face {
  font-family: 'Libre Baskerville';
  font-style: normal;
  font-weight: 400;
  src: url('./fonts/libre-baskerville-v4-latin-regular.eot'); /* IE9 Compat Modes */
  src: local('Libre Baskerville'), local('LibreBaskerville-Regular'),
    url('./fonts/libre-baskerville-v4-latin-regular.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
    url('./fonts/libre-baskerville-v4-latin-regular.woff2') format('woff2'), /* Super Modern Browsers */
    url('./fonts/libre-baskerville-v4-latin-regular.woff') format('woff'), /* Modern Browsers */
    url('./fonts/libre-baskerville-v4-latin-regular.ttf') format('truetype'), /* Safari, Android, iOS */
    url('./fonts/libre-baskerville-v4-latin-regular.svg#LibreBaskerville') format('svg'); /* Legacy iOS */
}
@font-face{
  font-family:'OpenIcon';
  font-style:normal;
  font-weight:normal;
  src:url('./fonts/openicon-min.eot');
  src: local('OpenIcon'),
    url('./fonts/openicon-min.eot') format('embedded-opentype'),
    url('./fonts/openicon-min.woff') format('woff'),
    url('./fonts/openicon-min.ttf') format('truetype'),
    url('./fonts/openicon-min.svg') format('svg');
}
.fa{display:inline-block;font:normal normal normal 14px/1 OpenIcon;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
.fa-lg{font-size:1.33333333em;line-height:.75em;vertical-align:-15%}
.fa-2x{font-size:2em}
.fa-3x{font-size:3em}
.fa-4x{font-size:4em}
.fa-5x{font-size:5em}
.fa.fa-pull-left{margin-right:.3em}
.fa.fa-pull-right{margin-left:.3em}
.fa-step-backward:before{content:"\e802"}
.fa-play:before{content:"\e801"}
.fa-pause:before{content:"\e800"}
.fa-step-forward:before{content:"\e803"}
.fa-bars:before{content:"\e804"}

#page {
  position:absolute; padding: 0; margin: 0; width: 100%; min-height: 100%; font-family: 'Libre Baskerville', sans-serif; font-weight: 300;
    background-image:radial-gradient(circle at center 30rem , #677084, #4b2543, #c50707, rgba(3, 28, 45,  0) 680px);
}

body {
  padding: 0; margin: 0; min-height: 100%; font-family: 'Libre Baskerville', sans-serif; font-weight: 300; background-image: url("images/stars-black.jpg");
}

/* Basic */
*, *:before, *:after { box-sizing: border-box; }
html { padding: 0; margin: 0; height: 100%;}
a { color: <?php echo $linkColor;?>; text-decoration: none; text-shadow: 1px 1px 1px #fff;  }
a:hover { color: <?php echo $linkHoverColor;?>; text-shadow: 1px 1px 2px #fff;}
p { margin: 0; }
.credits { position: absolute; left: 20px; bottom: 20px; color: #ccc; font-size: 14px; }
.credits a  { color: #F70240; }

/* Centering */
#container, #progress, #player, .cover, .playlist {
  position: absolute;
  margin: auto;
  top: 20px;
  left: 0;
  right: 0;
  box-sizing:border-box;
}

#container {
  perspective: 80%;
  -webkit-perspective: 80%;
  transform-style: preserve-3d;
  -webkit-transform-style: preserve-3d;
  max-height:890px;
  min-width: 320px;
  overflow: hidden;
}

#player {
  max-width: 870px;
  max-height: 870px;
  min-width: 320px;
  border-radius: 50%;
  border: 4px solid #AEAEAE;
  overflow: hidden;
  box-shadow: 2px 2px 20px 0 rgba(0,0,0,.3);
  z-index: 300;
  position: relative;
  margin: auto;
  top: -0.7rem;
  left: 0;
  right: 0;
  box-sizing:border-box;
}

#progress {
  z-index: 250;
  filter: blur(1px);
  -webkit-filter: blur(1px);
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
  top: 10px;
  width: 895px;
  height: 895px;
}

#flip-back, #flip2, #flip3 {
  position: absolute;
  margin: auto;
  left: 0;
  right: 0;
  box-sizing:border-box;
  text-align: center;
  top: 1.1rem;
  width: 870px;
  height: 870px;
  min-width:320px;
  border: 4px solid #AEAEAE;
  border-radius: 50%;
  overflow: hidden;
  box-shadow: inset 0 -10px 10px -5px rgba(0,0,0,.3), 2px 2px 20px 0 rgba(0,0,0,.3); /* inner + outer*/
  transform: rotateY(-180deg);
  -webkit-transform: rotateY(-180deg);
}

audio::-webkit-media-controls-panel {
  background: <?php echo $linkColor;?>;
  min-width: 13rem;
}

#audio {
  position: absolute;
  left:34%;
  top:38%;
  width: 30%;
  display: block;
  -moz-animation-name: dropHeader;
  -moz-animation-iteration-count: 1;
  -moz-animation-timing-function: ease-in;
  -moz-animation-duration: 8s;

  -webkit-animation-name: dropHeader;
  -webkit-animation-iteration-count: 1;
  -webkit-animation-timing-function: ease-in;
  -webkit-animation-duration: 8s;

  animation-name: dropHeader;
  animation-iteration-count: 1;
  animation-timing-function: ease-in;
  animation-duration: 8s;
}
@-moz-keyframes dropHeader {
  0% { -moz-transform: translateY(0px); opacity: 0; }
  80% { -moz-transform: translateY(0px); opacity: 0; }
  100% { -moz-transform: translateY(0px); opacity: 1; }
}
@-webkit-keyframes dropHeader {
    0% { -webkit-transform: translateY(0px); opacity: 0; }
    80% { -webkit-transform: translateY(0px); opacity: 0; }
    100% { -webkit-transform: translateY(0px); opacity: 1; }
}
@keyframes dropHeader {
    0% { transform: translateY(0px); opacity: 0; }
    80% { transform: translateY(0px); opacity: 0; }
    100% { transform: translateY(0px); opacity: 1; }
}
/* Album Cover */
img {
  width: 100%;
  height: 100%;
  opacity: .95;
  transition: .3s all ease-in-out;
  -webkit-transition: .3s all ease-in-out;
}

.cover {
  padding-top: 180px;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
}

.cover span {
  font-size:5em;
  text-shadow: 1px 1px 2px #8cb8bb;
  font-weight: 900;
  color: #de2550;
}

/* Fade */
#container:hover .cover,
#container:hover .to-lyrics-label,
#container:hover .to-back-label {
  opacity: .9;
}

.cover,
.to-lyrics-label,
.to-back-label {
  opacity: .3;
  transition: all .3s ease-in-out;
  -webkit-transition: all .3s ease-in-out;
}

/* Player Buttons */
#controls {
  position: relative;
  width: 80%;
  color: #fff;
  text-align: center;
  height: 8rem;
  z-index: 400;
  visibility: hidden;
}

button {
  margin: 0;
  color: <?php echo $linkColor;?>;
  background: transparent;
  border: 0;
  outline: 0;
  cursor: pointer;
  text-align: center;
  text-shadow: 1px 1px 3px #000;
  transition: all .3s ease-in-out;
  -webkit-transition: all .3s ease-in-out;
}

button:hover {
  color: <?php echo $linkHoverColor;?>;
}

#play-pause {
  height: 46px;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
	}
#back {
  visibility: hidden;
}

#forward {
  visibility: hidden;
}

/* Song Info */
.titling {
  font-size: 2rem;
  color: #E0C5BE;
  position: relative;
  width: 100%;
  text-align: center;
  text-shadow: 1px 1px 3px #666;
  margin: 0;
  padding: 0 1.5rem 1rem 1.5rem;
    transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
}
.info {
  position: relative;
  margin-top: 2.5rem;
  padding: 5px 0;
  bottom: 10px;
  color: #24464D;
  text-align: center;
  text-shadow: 1px 1px 3px #fff;
  font-size: 1rem;
  font-weight: 900;
  line-height: 1.8rem;
  background: rgba(255,255,255,0.6);
}

.song {
  font-size: 1rem;
  font-weight: 900;
  line-height: 1.2rem;
}

.song a{
  color: red;
}

.author {
  font-size: 14px;
  margin-bottom: -8px;
}

/* ... */
.song,
.author,
.playlist a {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Volume */

#volume {
  margin-top: 3rem;
  visibility: hidden;
}

input[type='range'],
input[type='range']::-webkit-slider-runnable-track,
input[type='range']::-webkit-slider-thumb {
  -webkit-appearance: none;
  -moz-appearance: none;
  width: 0;
  height: 0;
}

input[type='range'] {
  display: block;
  color: #cccccc;
  background: transparent;
  border: 0;
  margin: 2.5rem auto;
  width: 10rem;
  outline: 0;
  cursor: pointer;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
}

input[type='range']::-ms-fill-lower { background: #b2002b; }
input[type='range']::-ms-fill-upper { background: #330134; }
input[type='range']::-ms-thumb { height: 20px; width: 20px; margin: 10px 0; background: #fff; }
input[type='range']::-ms-thumb:hover {background: #F70240;}
input[type='range']::-ms-ticks-after { display: none; color: #b2002b; }
input[type='range']::-ms-ticks-before { display: none; color: #330134; }
input[type='range']::-ms-track {   height: 20px; width: 100%; }
input[type='range']::-ms-tooltip { display: none; }

input[type=range]::-webkit-slider-runnable-track {
  width: 300px;
  height: 5px;
  background: #666;
  border: none;
  border-radius: 3px;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  border: 3px solid #330134;
  height: 26px;
  width: 26px;
  border-radius: 50%;
  background: #335657;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
  margin-top: -11px;
  box-shadow: 1;
}

input[type=range]::-moz-range-track {
  height: 3px;
  background: #ddd;
  border: none;
  border-radius: 3px;
}

input[type=range]::-moz-range-thumb {
  border: 3px solid <?php echo $linkColor;?>;
  height: 26px;
  width: 26px;
  border-radius: 50%;
  background: #335657;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
}

/*hide the outline behind the border*/
input[type=range]:-moz-focusring{
  outline: 1px solid white;
  outline-offset: -1px;
}

input[type=range]:focus::-moz-range-track {
  background: #ccc;
}

input[type=range]:hover::-webkit-slider-thumb {
  border: 1px solid #ffffff;
  background: <?php echo $linkHoverColor;?>;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
}

input[type=range]:active::-webkit-slider-thumb {
  border: 1px solid #0940fd;
  box-shadow: 0 0 0 2px #6fb5f1;
}

input[type=range]:hover::-moz-range-thumb {
  border: 1px solid #fffff;
  background: <?php echo $linkHoverColor;?>;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
}

input[type=range]:active::-moz-range-thumb {
  border: 1px solid #0940fd;
  box-shadow: 0 0 0 2px #6fb5f1;
}

/* Checkboxes */
input[type=radio] {
  position: absolute;
  top: -9999px;
  left: -9999px;
}

label {
  text-shadow: 1px 1px 3px #000;
}

.to-back-label:hover,
.to-lyrics-label:hover {
  color: <?php echo $linkHoverColor;?>;
}

label:active,
label:focus {
  top: 0;
  opacity: 0;
}

label.to-back-label {
  position: relative;
  top: 40px;
  width: 30px;
  height: 30px;
  color: <?php echo $linkColor;?>;
  text-align: center;
  cursor: pointer;
  z-index: 500;
}

label.to-lyrics-label {
  position: absolute;
  top: 276px;
  left: 50%;
  width: 20px;
  height: 20px;
  margin-left: -5px;
  color: #fff;
  cursor: pointer;
  z-index: 500;
}

/* Flip Back */
#player, #flip-back, #flip2, #flip3 {
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  transition: transform .5s ease-in-out;
  -webkit-transition: -webkit-transform .5s ease-in-out;
}

#to-back1-l { display: inline-block; }
#to-back2-l { display: none; }
#to-back3-l { display: none; }
#to-back4-l { display:none; }

#to-back1:checked ~ #to-back1-l { display: none; }
#to-back1:checked ~ #to-back2-l { display: inline-block; }
#to-back1:checked ~ #to-back3-l { display: none; }
#to-back1:checked ~ #to-back4-l { display: none; }

#to-back1:checked ~ #flip-back { z-index: 400; transform: rotateY(0deg); -webkit-transform: rotateY(0deg); }
#to-back1:checked ~ #flip2 { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back1:checked ~ #flip3 { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back1:checked ~ #player { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }

#to-back2:checked ~ #to-back1-l { display: none; }
#to-back2:checked ~ #to-back2-l { display: none; }
#to-back2:checked ~ #to-back3-l { display: inline-block; }
#to-back2:checked ~ #to-back4-l { display: none; }

#to-back2:checked ~ #flip-back { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back2:checked ~ #flip2 { z-index: 400; transform: rotateY(0deg); -webkit-transform: rotateY(0deg); }
#to-back2:checked ~ #flip3 { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back2:checked ~ #player { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }

#to-back3:checked ~ #to-back1-l { display: none; }
#to-back3:checked ~ #to-back2-l { display: none; }
#to-back3:checked ~ #to-back3-l { display: none; }
#to-back3:checked ~ #to-back4-l { display: inline-block; }

#to-back3:checked ~ #flip-back { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back3:checked ~ #flip2 { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back3:checked ~ #flip3 { z-index: 400; transform: rotateY(0deg); -webkit-transform: rotateY(0deg); }
#to-back3:checked ~ #player { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }

#to-back4:checked ~ #to-back1-l { display: inline-block; }
#to-back4:checked ~ #to-back2-l { display: none; }
#to-back4:checked ~ #to-back3-l { display: none; }
#to-back4:checked ~ #to-back4-l { display: none; }

#to-back4:checked ~ #flip-back { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back4:checked ~ #flip2 { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back4:checked ~ #flip3 { z-index: -1; transform: rotateY(180deg); -webkit-transform: rotateY(180deg); }
#to-back4:checked ~ #player { z-index: 400; transform: rotateY(0deg); -webkit-transform: rotateY(0deg); }

#to-back1:checked ~ #progress { opacity: 1; transform: rotate(0); -webkit-transform: rotate(0); }

#to-back1:checked ~ #flip-back .playlist { transform: translateY(0); -webkit-transform: translateY(0); }
#to-back2:checked ~ #flip2 .playlist { transform: translateY(0); -webkit-transform: translateY(0); }
#to-back3:checked ~ #flip3 .playlist { transform: translateY(0); -webkit-transform: translateY(0); }

#fbcont, #fbcont2, #fbcont3 { position:absolute;text-align: center; width: 100%; }
/* Lyrics */
.lyrics {
  display: block;
  width: 100%;
  height: 286px;
  max-height: 266px;
  margin-top: 0px;
  padding: 4px 24px;
  color: <?php echo $lyricsColor;?>;
  background: rgba(255,255,255,.3);
  font-size: 1.5rem;
  font-weight: 300;
  text-align: center;
  overflow-y: scroll;
  transition: all .5s ease-in-out;
  -webkit-transition: all .5s ease-in-out;
  z-index: 200;
}

.lyrics:hover {
  background: rgba(255,255,255,.7);
  color: <?php echo $lyricsHoverColor;?>;
}

#lyric {
  padding: 1rem 0;
}

#canlyr {
  width: 750px;
  height:200px;
}
.scroll {
  color: #fff;
  text-align: center;
  font-size: 9px;
  font-weight: bold;
  text-shadow: 1px 1px 3px #000;
}

#to-lyrics:checked ~ .cover {
  padding-top: 40px;
}

#to-lyrics:checked ~ .cover .lyrics {
  margin-top: 0px;
}

#to-lyrics:checked ~ .cover button {
  margin: 4px;
}

/* Playlist */
.playlist {
  margin: 8rem 0 0 8rem;
  padding: 1rem 2rem 1rem 3rem;
  font-size: 1.5rem;
  list-style: none;
  overflow-y: auto;
  overflow-x: hidden;
  text-align: left;
  line-height: 2rem;
  transform: translateY(300px);
  -webkit-transform: translateY(300px);
  transition: transform .5s ease-in-out .3s;
  -webkit-transition: -webkit-transform .5s ease-in-out .3s;
}

#flip-back h3, #flip2 h3, #flip3 h3 {
  padding: 1rem 2rem;
  font-size: 2rem;
  color: #DE2550;
}

#flip-back span, #flip2 span, #flip3 span {
  position: relative;
  line-height:1.2rem;
  text-align: center;
  padding: 0;
  margin: 0;
  font-size: 0.9rem;
  font-weight: 900;
}

.copy {
  font-size: 0.8rem;
  position: relative;
  top: 36rem;
  display: block;
  color: #24464d;
}

.playlist h3 {
  color: #335657;
}

.playlist li {
  display: table;
  padding: 0.24rem 0;
  color: #24464d;
  text-decoration: none;
}

/*.playlist li:hover {
  color: #F70240;
}
*/
.playlist li:nth-child(0) {
  padding: 0 24px;
}

.playlist::-webkit-scrollbar {
  display: none;
}

.playlist-detail {
  background: rgba(255,255,255,0.5);
  padding: 0 1rem;
  margin: 0.5rem 0 0 2rem;
  width: 100rem;
  font-size: 1rem;
  -webkit-border-radius: 1rem;
  -moz-border-radius: 1rem;
  border-radius: 1rem;
}

#loading {
  display: block;
  position: absolute;
  top: -4.4rem;
  left: 25rem;
  width: 13rem;
  height: 20px;
  background-color: rgba(192, 192, 192, 0);
  background-repeat: no-repeat;
  background-position: 50% 25%;
  text-align: left;
}

#progressBar {
  border:.2rem solid <?php echo $linkColor;?>;
  background-color: rgba(255,255,255,0.2);
  width: 10rem;
  height: 1.2rem;
  text-align: left;
  box-shadow: 1px 1px 3px #000;
  display: inline-block;
  visibility: hidden;
}

#progressBarItself {
  position: relative;
  top: -0.8rem;
  background-color: #de2550;
  height: 100%;
  display: block;
  font-size: 0.8rem;
  width: 0rem;
}

#bufferBar {
  background-color: #c70c0c;
  height: 100%;
  display: block;
  font-size: 0.8rem;
  width: 0rem;
}

.copyspan {
  width: 40rem;
  background: #ffffff;
}
/* Media Queries */
@media all and (max-width: 900px) {
  button { margin: 4px; }
  html { height:100%; }
  img { position: relative; display: flex; height:95%; }
  label.to-back-label { top: 30px; }
  input[type='range'], input[type='range']::-webkit-slider-runnable-track, input[type=range]::-moz-range-track, input[type='range']::-ms-track { width: 10rem; max-width:10rem; }
  .author { font-size: 10px; }
  .controls {height: 7rem; }
  .copy { top: 80vw; font-size: 0.65rem; }
  .cover { padding-top: 19%; }
  .lyrics { height: 27vw; }
  .playlist { margin: 13vw 0 0 13vw; overflow-y: hidden;}
  /*.playlist h3 { color: <?php echo $linkHoverColor;?>; }
  .playlist li { line-height: 1.2rem; font-size: 1.2rem; }
  .playlist li a { color: <?php echo $linkHoverColor;?>; } */
  .song { font-size: 12px; }
  .titling { font-size: 1.8rem;}
  #flip-back, #flip2, #flip3 { max-height: 97%; max-width: 100%; width: auto; background: #682339; }
  #flip-back h3, #flip2 h3, #flip3 h3 { font-size: 1.5rem; margin: 1rem 0 0; color: #<?php echo $linkHoverColor;?>;}
  #page { background-image:radial-gradient(circle at center 50vw , #677084, #4b2543, #be1c1c, #031c2c 680px); }
  #progress { padding-top: 5%; display: none; width: 100%; height: auto; margin-top: -5px; margin-left: -5px; }
  #volume {	margin-top: 1.5rem; width: 10rem; }
}

@media all and (max-width: 767px) {
  .copy { top: 75vw; }
  .info {  top: 5vw; }
  .lyrics { height: 20vw; }
  .playlist-detail { font-size: 0.85rem; }
  .playlist-detail-2 { display: none; }
  .titling { font-size: 1.5rem;}
}

@media all and (max-width: 700px) {
  .info { top: 0vw;
}
@media all and (max-width: 640px) {
  audio::-webkit-media-controls-panel { margin-left: -5vw; }
  .info { font-size: 0.85rem; line-height: 1.5rem; }
  .lyrics { height: 10vw; visibility: hidden; }
  .playlist-detail { font-size: 0.75rem; }
  .titling { font-size: 1.1rem;line-height: 3rem;}
}

@media all and (max-width: 560px) {
  .copy { top: 65vw; }
  .info { top: -10vw; }
  .lyrics {  height: 5vw;}
  .playlist-detail { visibility: hidden; height: 2vw; }

@media all and (max-width: 480px) {
  .controls { top:-1.5rem; }
  .info { font-size: 0.7rem; line-height: 1.2rem; }
  .lyrics {  height: 2vw;}
  .playlist { line-height: 1.2rem; top: 12vw; }
  .titling { font-size: 0.9rem; line-height:2rem; }
  #flip-back, #flip2, #flip3 { max-height: 95%; }
}

@media all and (max-width: 480px) {
  audio::-webkit-media-controls-panel { margin-left: -10vw; }
  .copy { top: 60vw; }
  .playlist { font-size: 1.2rem; }
  .playlist-detail { height: 1vw; }
}

@media all and (max-width: 400px) {
  audio::-webkit-media-controls-panel { margin-left: -15vw; }
  .copy { top: 58vw; }
  .info { top: -22vw; }
}

@media all and (max-width: 340px) {
  audio::-webkit-media-controls-panel { margin-left: -20vw; }
  .controls { top:-2rem; }
  .copy { top: 55vw; }
  .info { font-size: 0.6rem; top:-28vw; }
  .lyrics {  display: none;}
  .playlist { margin: 20vw 0 0 13vw; }
  .playlist li { padding: 0; }
  .titling { top: -1rem;}
}
</style>
</head>

<body>
<center>
<div id="page">
  <div id="container">
    <input type="radio" name="to-back" id="to-back4" checked>
    <input type="radio" name="to-back" id="to-back3">
    <input type="radio" name="to-back" id="to-back2">
    <input type="radio" name="to-back" id="to-back1">
    <label class="to-back-label" for="to-back1" id="to-back1-l" onClick="init()"><i class="fa fa-bars fa-lg"></i></label>
    <label class="to-back-label" for="to-back2" id="to-back2-l" onClick="init2()"><i class="fa fa-bars fa-lg"></i></label>
    <label class="to-back-label" for="to-back3" id="to-back3-l" onClick="init3()"><i class="fa fa-bars fa-lg"></i></label>
    <label class="to-back-label" for="to-back4" id="to-back4-l"><i class="fa fa-bars fa-lg"></i></label>
    <!-- playlist toggle -->
    <canvas id="progress" width="895px" height="895px"></canvas><!-- progress bar -->
    <div id="player">
      <audio id="audio" controls="controls" style="z-index:999999;">
      	<source src="<?php echo $pathName.$mediaDirectory.$songFile; ?>" type="audio/mpeg" codecs="mp3" />
          Your browser does not support the audio element.
      </audio>
      <img src="<?php echo $coverBgImage; ?>" width="862px" height="862px" style="border-radius: 50%;" /><!-- album cover -->
      <div class="cover">
        <div id="loader"></div>
        <div class="titling">
          <h2 id="songtitle" style="margin:0; padding:0;"><?php echo $songTitle; ?></h2>
          <div id="progressBar"><span id="bufferBar"></span><span id="progressBarItself"></span></div>
        </div>
        <div class="controls" id="controls">
          <button id="back" title="Previous" onclick="resetPlayer('back','clickstart')"><i class="fa fa-step-backward fa-2x"></i></button>
          <button id="play-pause" title="Play" onclick="togglePlayPause()"><i class="fa fa-play fa-3x"></i></button>
          <button id="forward" title="Next" onclick="resetPlayer('forward','clickstart')"><i class="fa fa-step-forward fa-2x"></i></button>
          <input id="volume" name="volume" min="0" max="1" step="any" type="range" onchange="setVolume()" class='range-input' />
        </div><!-- #controls -->
        <div class="lyrics">
          <p id="lyric">
            <?php echo $songLyric; ?>
          </p>
        </div><!-- #lyrics -->
        <div class="info">
          <p class="infodetail">
            <?php echo $coverInfoCopy; ?>
          </p>
          <p class="infodetail" style="font-weight:300;">
            <?php echo $coverInfoCopyright; ?>
          </p>
        </div><!-- #info -->
      </div><!-- #cover -->
    </div>
    <div id="flip-back">
      <div id="fbcont" style="  $limits strval ( $limits );
" itemscope itemtype="http://schema.org/MusicPlaylist">
        <h3><?php echo $album."<br />".$band."&nbsp;::&nbsp;".$year; ?></h3>
        <ul class="playlist">
  <?php
getSongsDetails($link,$albumId,'5');
  ?>
        </ul>
        <p class="copy">
          <?php echo $flipCopy; ?>
        </p>
      </div>
    </div>
    <div id="flip2" class="flip">
      <div id="fbcont2" style="position:absolute;text-align: center; width: 100%;" itemscope itemtype="http://schema.org/MusicPlaylist">
        <h3><?php echo $album."<br />".$band."&nbsp;::&nbsp;".$year; ?></h3>
        <ul class="playlist">
<?php
getSongsDetails($link,$albumId,"5, 5");
?>
        </ul>
        <p class="copy">
          <?php echo $flipCopy; ?>
        </p>
      </div>
    </div>
    <div id="flip3" class="flip">
      <div id="fbcont3" style="position:absolute;text-align: center; width: 100%;" itemscope itemtype="http://schema.org/MusicPlaylist">
        <h3><?php echo $album."<br />".$band."&nbsp;::&nbsp;".$year; ?></h3>
        <ul class="playlist">
<?php
getSongsDetails($link,$albumId,'10, 5');
?>
        </ul>
        <p class="copy">
          <?php echo $flipCopy; ?>
        </p>
      </div>
    </div><!-- #flip-back -->
  </div><!-- #container -->
</div><!-- #page -->
</center>
</body>

<script type="text/javascript">
var audio = document.getElementById('audio');
var volHolder = audio.volume;
var controls = document.getElementById('controls');
var playpause = document.getElementById('play-pause');
var volume = document.getElementById('volume');
var songtitle = document.getElementById('songtitle');
var canvas = document.getElementById('progress');
var outside = document.getElementById('progressBar');
var inside = document.getElementById('progressBarItself');
var under = document.getElementById('bufferBar');
var context = canvas.getContext('2d');
var centerX = canvas.width / 2;
var centerY = canvas.height / 2;
var radius = 440;
var circ = Math.PI * 2;
var quart = Math.PI / 2;
var duration = audio.duration;
var clockradius = 455;
context.lineWidth = 10;
context.strokeStyle = '<?php echo $linkShadowColor;?>';
context.fillStyle = '<?php echo $linkHoverColor;?>';
context.shadowOffsetX = 0;
context.shadowOffsetY = 0;
context.shadowBlur = 1;
context.shadowColor = '<?php echo $linkColor;?>';
var endPercent = 100;
var styleMe = '<i class="fa fa-play" style="margin-right:4px;"></i>';

<?php
$count = count($songLyrics);
//echo $count;
for ($i = 1; $i <= $count; $i++) {
  $j = $i-1;
  echo 'var lyric'.$i.' = "'.$songLyrics[$j].'";
';
}
?>

window.onresize = function(event) {
//document.getElementById('mainb').setAttribute('style', 'padding: 0; margin: 0; min-height: 100%; font-family: "Libre Baskerville", sans-serif; font-weight: 300; background-image:radial-gradient(circle at center 30rem , #677084, #4b2543, #be1c1c, #031c2c 680px);');

if(window.innerWidth < 870) {
var newTopLengthA = Math.floor( window.innerWidth / 2 );
var newTopLengthB = Math.floor( window.innerWidth / 20 );
if(window.innerWidth < 670) {
var newTopLengthB = 0;
  }
var newTopLength = newTopLengthA + newTopLengthB;
//document.getElementById('mainb').setAttribute('style', 'padding: 0; margin: 0; min-height: 100%; font-family: "Libre Baskerville", sans-serif; font-weight: 300; background-image: radial-gradient(circle at center ' + newTopLength + 'px, #677084, #4b2543, #be1c1c, #031c2c 680px);');
console.log(newTopLength);
  }
};

  window.onload = function(event) {
  document.getElementById('audio').setAttribute('style', 'height: 0; visibility: hidden;');
  document.getElementById('controls').setAttribute('style', 'visibility: visible;');
  document.getElementById('play-pause').setAttribute('style', 'visibility: visible;');
  document.getElementById('volume').setAttribute('style', 'visibility: visible;');
  document.getElementById('progressBar').setAttribute('style', 'visibility: visible;');
  console.log(window.innerWidth);
  //document.getElementById("timer").innerHTML = window.innerWidth;
  if(window.innerWidth < 870) {
  var newTopLengthA = Math.floor( window.innerWidth / 2 );
  var newTopLengthB = Math.floor( window.innerWidth / 20 );
  if(window.innerWidth < 670) {
  var newTopLengthB = 0;
    }
  var newTopLength = newTopLengthA + newTopLengthB;
  //document.getElementById('mainb').setAttribute('style', 'padding: 0; margin: 0; min-height: 100%; font-family: "Libre Baskerville", sans-serif; font-weight: 300; background-image: radial-gradient(circle at center ' + newTopLength + 'px, #677084, #4B2543, #be1c1c, #031c2c 380px);');
  console.log(newTopLength);
    }
  };

  (function() {
    var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
    window.requestAnimationFrame = requestAnimationFrame;
  })();

  outside.addEventListener('click', function(e) {
    xpos = e.offsetX==undefined?e.layerX-100:e.offsetX;
    ypos = e.offsetY==undefined?e.layerY:e.offsetY;
    var pct = Math.ceil((xpos / outside.offsetWidth) * 100);
    audio.currentTime = audio.duration * pct / 100;
    context.clearRect(0, 0, canvas.width, canvas.height);
  }, false);

  loadedInfo = function () {
    var dur = Math.ceil(audio.duration);
    var cur = Math.ceil(audio.currentTime);
    if(audio.buffered.length>0) {
      var bfck = Math.ceil(Math.max(1,audio.buffered.end(0)));
    } else {
      var bfck = dur;
    }
    if(bfck===(cur)) {
      window.clearInterval(intervalRequestedId);
      }
    }

  loadInfo = function () {
    var dur = Math.ceil(audio.duration);
    var cur = Math.ceil(audio.currentTime);
    if(audio.buffered.length>0) {
      bufchckkk = Math.ceil(Math.max(1,audio.buffered.end(0)));
  } else {
      bufchckkk += 0.75;
  }
    if(bufchckkk>40) {
      window.clearInterval(intervalRequestId);
      intervalRequestedId = setInterval('loadedInfo()', 500);
      loaded = true;
      context.clearRect(0, 0, canvas.width, canvas.height);
      playpause.innerHTML = '<i class="fa fa-pause fa-3x"></i>';
      document.getElementById('back').setAttribute('style', 'visibility: visible;');
      document.getElementById('forward').setAttribute('style', 'visibility: visible;');
      loader.innerHTML = '';
      controls.setAttribute('style', 'opacity: 1;');
      audio.volume = volHolder;
      audio.currentTime = 0;
      audio.play();
      audio.addEventListener("timeupdate", function () {
      updateProgressB();
      updateBufferB();
}, false);
//      audio.addEventListener("bufferupdate", updateBufferB, false);
      requestAnimationFrame(function () {
           animate();
      }, 300);
    }
  }
  clearControls = function () {
  controls.setAttribute('style', 'opacity: 0;');
  loader.setAttribute('style', 'display:block;position:relative;top:-16vh;');
  loader.innerHTML = '<img src="images/loading.svg" width="80px" height="110px" />';
  }

  function updateProgressB() {
     var progressBI = document.getElementById("progressBarItself");
     var value = 0;
     if (audio.currentTime > 0) {
        value = Math.floor((100 / audio.duration) * audio.currentTime);
     }
     progressBI.style.width = value + "%";
  }

  function updateBufferB() {
     var bufferB = document.getElementById("bufferBar");
     var value = 0;
     //console.log(audio.buffered.end(0));
     console.log(audio.duration);
     if (audio.buffered.end(0) > 0) {
        value = Math.floor((100 / audio.duration) * audio.buffered.end(0));
     }
     bufferB.style.width = value + "%";
  }

  function togglePlayPause() {
      if (audio.paused || audio.ended) {
          playpause.title = 'Pause';
          audio.controls = false;
          var gotCurrentSong = audio.currentSrc;

          switch (gotCurrentSong) {
          <?php
          for ($i = 1; $i <= $count; $i++) {
            $j = $i - 1;
          echo "case '".$pathName.$mediaDirectory.$songFiles[$j]."':";
          echo "document.getElementById('pl".$i."').setAttribute('style', 'color:#de2550;');";
          echo 'document.getElementById("pl'.$i.'").innerHTML = styleMe + "'.$i.'. '.$songTitles[$j].' <span>'.$songDurations[$j].'</span>";';
          echo 'var songTitle = "'.$songTitles[$j].'" + " " + Math.floor(audio.currentTime) + " seconds";';
          echo ' _gaq.push(["_trackEvent", "player", "clickstart play", songTitle, 1, false]);';
          echo "
          break;
          ";
          }
          echo "default:
          ";
          echo "document.getElementById('pl1').setAttribute('style', 'color:#8cb8bb;');";
          echo 'document.getElementById("pl1").innerHTML = styleMe + "1. '.$songTitles[0].' <span>'.$songDurations[0].'</span>";';
          echo 'var songTitle = "'.$songTitles[0].'" + " " + Math.floor(audio.currentTime) + " seconds";';
          echo ' _gaq.push(["_trackEvent", "player", "clickstart play", songTitle, 1, false]);';
          ?>
          }

          if(audio.currentTime<1) {
            if(audio.buffered.length>0) {
              if(audio.buffered.end(0)>40) {
                audio.play();
                audio.addEventListener("timeupdate", function () {
                updateProgressB();
                updateBufferB();
          }, false);
                //audio.addEventListener("timeupdate", updateProgressB, false);
                //audio.addEventListener("bufferupdate", updateBufferB, false);
                playpause.innerHTML = '<i class="fa fa-pause fa-3x"></i>';
                document.getElementById('back').setAttribute('style', 'visibility: visible;');
                document.getElementById('forward').setAttribute('style', 'visibility: visible;');
                requestAnimationFrame(function () {
                  animate();
                  }, 300);
                }
                else {
                  audio.volume = 0;
                  audio.play();
                  clearControls();
                  intervalRequestId = setInterval('loadInfo()', 100);
                }
              }
              else {
                bufchckkk = 0;
                audio.volume = 0;
                audio.play();
                clearControls();
                intervalRequestId = setInterval('loadInfo()', 100);
            }
          }
          else {
            audio.play();
            audio.addEventListener("timeupdate", function () {
            updateProgressB();
            updateBufferB();
      }, false);
            //audio.addEventListener("timeupdate", updateProgressB, false);
            //audio.addEventListener("bufferupdate", updateBufferB, false);
            playpause.innerHTML = '<i class="fa fa-pause fa-3x"></i>';
            document.getElementById('back').setAttribute('style', 'visibility: visible;');
            document.getElementById('forward').setAttribute('style', 'visibility: visible;');
            requestAnimationFrame(function () {
              animate();
              }, 300);
            }
          }
      else {
          playpause.title = 'Play';
          playpause.innerHTML = '<i class="fa fa-play fa-3x"></i>';
          audio.pause();
          var gaDetail = audio.currentSrc + ' ' + Math.floor(audio.currentTime) + ' seconds';
          _gaq.push(["_trackEvent", "player", "pause", gaDetail, 1, false]);
         }
       }

  function setVolume() {
      audio.volume = volume.value;
       }

  function animate(current) {
    var realPercent = 100 / audio.duration * audio.currentTime;
    var decPercent = realPercent.toPrecision(4);
    context.beginPath();
    context.arc(centerX, centerY, radius, -(quart), ((circ) * current) - quart, false);
    context.stroke();
    if (decPercent>=100) {
        return resetPlayer('forward','autostart');
        }
    if (decPercent < endPercent) {
        requestAnimationFrame(function () {
            animate(decPercent / 100)
          });
      }
  }

  function resetPlayer(direction, calledBy) {
  var direction = direction;
  var calledBy = calledBy;
  var gaStart = calledBy + ' ' + direction;
  var getCurrentSong = audio.currentSrc;
  var prevSong = '';
  var nextSong = '';
  var nextSongTitle = '';
  var nextSongFlip = '';
  var thisSongFlip = '';
  var thisSongFlipLink = '';
  var oldSongFlip = '';
  var oldSongFlipLink = '';
  var thisLyric = '';

  switch (getCurrentSong) {
    <?php
    //$count = $count + 1;
    for ($i = 1; $i <= $count; $i++) {
      $j = $i - 1;
    if($i == $count) {
      $prev = $count-1;
      $aprev = $count-2;
      $nexts = 1;
      $anexts = 0;}
    elseif($i == 1) {
      $prev = $count;
      $aprev = $count - 1;
      $nexts = 2;
      $anexts = 1;}
    else {
      $prev = $j;
      $aprev = $j - 1;
      $nexts = $i + 1;
      $anexts = $i;}

    echo "case '".$pathName.$mediaDirectory.$songFiles[$j]."':";
    echo "prevSong = '".$pathName.$mediaDirectory.$songFiles[$aprev]."';";
    echo 'prevSongTitle = "'.$songTitles[$aprev].'";';
    echo "nextSong = '".$pathName.$mediaDirectory.$songFiles[$anexts]."';";
    echo 'nextSongTitle = "'.$songTitles[$anexts].'";';
    echo "oldSongFlip = 'pl".$i."';";
    echo 'oldSongFlipLink = "'.$i.'. '.$songTitles[$j].' <span>'.$songDurations[$j].'</span>";';
    echo "if (direction === 'back') {";
    echo "thisSongFlip = document.getElementById('pl".$prev."');";
    echo 'thisSongFlipLink = styleMe + "'.$prev.'. '.$songTitles[$aprev].' <span>'.$songDurations[$aprev].'</span>";';
    echo "thisLyric = lyric".$prev.";";
    echo ' _gaq.push(["_trackEvent", "player", gaStart, "'.$songTitles[$aprev].'", 1, false]);';
    echo "} else {";
    echo "thisSongFlip = document.getElementById('pl".$nexts."');";
    echo 'thisSongFlipLink = styleMe + "'.$nexts.'. '.$songTitles[$anexts].' <span>'.$songDurations[$anexts].'</span>";';
    echo "thisLyric = lyric".$nexts.";";
    echo ' _gaq.push(["_trackEvent", "player", gaStart, "'.$songTitles[$anexts].'", 1, false]);';
    echo "}";
    echo "
    break;
    ";
    }
    $acount = $count - 1;
    echo "default:";
    echo "prevSong = '".$pathName.$mediaDirectory.$songFiles[$acount]."';";
    echo 'prevSongTitle = "'.$songTitles[$acount].'";';
    echo "nextSong = '".$pathName.$mediaDirectory.$songFiles[1]."';";
    echo 'nextSongTitle = "'.$songTitles[1].'";';
    echo "oldSongFlip = 'pl1';";
    echo 'oldSongFlipLink = "1. '.$songTitles[0].' <span>'.$songDurations[0].'</span>";';
    echo "if (direction === 'back') {";
    echo "thisSongFlip = document.getElementById('pl".$count."');";
    echo 'thisSongFlipLink = styleMe + "'.$count.'. '.$songTitles[$acount].' <span>'.$songDurations[$acount].'</span>";';
    echo "thisLyric = lyric".$count.";";
    echo "} else {";
    echo "thisSongFlip = document.getElementById('pl2');";
    echo 'thisSongFlipLink = styleMe + "2. '.$songTitles[1].' <span>'.$songDurations[1].'</span>";';
    echo "thisLyric = lyric2;";
    echo "}";
    echo ' _gaq.push(["_trackEvent", "player", gaStart, "'.$songTitles[0].'", 1, false])';
    echo "
    }";
    ?>

    context.clearRect(0, 0, canvas.width, canvas.height);
    playpause.title = 'Pause';
    playpause.innerHTML = '<i class="fa fa-pause fa-3x"></i>';
    songtitle.innerHTML = nextSongTitle;
    thisSongFlip.innerHTML = thisSongFlipLink;
    thisSongFlip.setAttribute('style', 'color:#8cb8bb;');
    document.getElementById(oldSongFlip).setAttribute('style', '');
    document.getElementById(oldSongFlip).innerHTML = oldSongFlipLink;
    document.getElementById('lyric').innerHTML = thisLyric;
    if(direction === 'back')	{
      audio.setAttribute('src', prevSong);
      songtitle.innerHTML = prevSongTitle;
      document.title = '<?php echo $band; ?>::<?php echo $album; ?>::' + prevSongTitle;
    }
    else {
      audio.setAttribute('src', nextSong);
      songtitle.innerHTML = nextSongTitle;
      document.title = '<?php echo $band; ?>::<?php echo $album; ?>::' + nextSongTitle;
    }
    var bufchckkk = 0;
    audio.volume = 0;
    audio.play();
    clearControls();
    intervalRequestId = setInterval('loadInfo()', 100);

    audio.addEventListener('error' , function()
    {
      alert('oops -- there was an error loading the audio\nmaybe try using the hamburger icons at the top?');
    }, false);
  }
</script>

<script type="text/javascript">
function init() {
document.getElementById('flip-back').setAttribute('style', 'background:url("<?php echo $flipBgImage; ?>") no-repeat;background-position:center;background-size:cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;');
}
function init2() {
document.getElementById('flip2').setAttribute('style', 'background:url("<?php echo $flipBgImage; ?>") no-repeat;background-position:center;background-size:cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;');
}
function init3() {
document.getElementById('flip3').setAttribute('style', 'background:url("<?php echo $flipBgImage; ?>") no-repeat;background-position:center;background-size:cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;');
}
</script>

<script type="text/javascript">
(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.ProgressBar=f()}})(function(){var define,module,exports;return(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){;(function(root){if(typeof SHIFTY_DEBUG_NOW==='undefined'){SHIFTY_DEBUG_NOW=function(){return+new Date();};}
var Tweenable=(function(){'use strict';var formula;var DEFAULT_SCHEDULE_FUNCTION;var DEFAULT_EASING='linear';var DEFAULT_DURATION=500;var UPDATE_TIME=1000/60;var _now=Date.now?Date.now:function(){return+new Date();};var now=SHIFTY_DEBUG_NOW?SHIFTY_DEBUG_NOW:_now;if(typeof window!=='undefined'){DEFAULT_SCHEDULE_FUNCTION=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||(window.mozCancelRequestAnimationFrame&&window.mozRequestAnimationFrame)||setTimeout;}else{DEFAULT_SCHEDULE_FUNCTION=setTimeout;}
function noop(){}
function each(obj,fn){var key;for(key in obj){if(Object.hasOwnProperty.call(obj,key)){fn(key);}}}
function shallowCopy(targetObj,srcObj){each(srcObj,function(prop){targetObj[prop]=srcObj[prop];});return targetObj;}
function defaults(target,src){each(src,function(prop){if(typeof target[prop]==='undefined'){target[prop]=src[prop];}});}
function tweenProps(forPosition,currentState,originalState,targetState,duration,timestamp,easing){var normalizedPosition=(forPosition-timestamp)/duration;var prop;for(prop in currentState){if(currentState.hasOwnProperty(prop)){currentState[prop]=tweenProp(originalState[prop],targetState[prop],formula[easing[prop]],normalizedPosition);}}
return currentState;}
function tweenProp(start,end,easingFunc,position){return start+(end-start)*easingFunc(position);}
function applyFilter(tweenable,filterName){var filters=Tweenable.prototype.filter;var args=tweenable._filterArgs;each(filters,function(name){if(typeof filters[name][filterName]!=='undefined'){filters[name][filterName].apply(tweenable,args);}});}
var timeoutHandler_endTime;var timeoutHandler_currentTime;var timeoutHandler_isEnded;function timeoutHandler(tweenable,timestamp,duration,currentState,originalState,targetState,easing,step,schedule){timeoutHandler_endTime=timestamp+duration;timeoutHandler_currentTime=Math.min(now(),timeoutHandler_endTime);timeoutHandler_isEnded=timeoutHandler_currentTime>=timeoutHandler_endTime;if(tweenable.isPlaying()&&!timeoutHandler_isEnded){schedule(tweenable._timeoutHandler,UPDATE_TIME);applyFilter(tweenable,'beforeTween');tweenProps(timeoutHandler_currentTime,currentState,originalState,targetState,duration,timestamp,easing);applyFilter(tweenable,'afterTween');step(currentState);}else if(timeoutHandler_isEnded){step(targetState);tweenable.stop(true);}}
function composeEasingObject(fromTweenParams,easing){var composedEasing={};if(typeof easing==='string'){each(fromTweenParams,function(prop){composedEasing[prop]=easing;});}else{each(fromTweenParams,function(prop){if(!composedEasing[prop]){composedEasing[prop]=easing[prop]||DEFAULT_EASING;}});}
return composedEasing;}
function Tweenable(opt_initialState,opt_config){this._currentState=opt_initialState||{};this._configured=false;this._scheduleFunction=DEFAULT_SCHEDULE_FUNCTION;if(typeof opt_config!=='undefined'){this.setConfig(opt_config);}}
Tweenable.prototype.tween=function(opt_config){if(this._isTweening){return this;}
if(opt_config!==undefined||!this._configured){this.setConfig(opt_config);}
this._start(this.get());return this.resume();};Tweenable.prototype.setConfig=function(config){config=config||{};this._configured=true;this._pausedAtTime=null;this._start=config.start||noop;this._step=config.step||noop;this._finish=config.finish||noop;this._duration=config.duration||DEFAULT_DURATION;this._currentState=config.from||this.get();this._originalState=this.get();this._targetState=config.to||this.get();this._timestamp=now();var currentState=this._currentState;var targetState=this._targetState;defaults(targetState,currentState);this._easing=composeEasingObject(currentState,config.easing||DEFAULT_EASING);this._filterArgs=[currentState,this._originalState,targetState,this._easing];applyFilter(this,'tweenCreated');return this;};Tweenable.prototype.get=function(){return shallowCopy({},this._currentState);};Tweenable.prototype.set=function(state){this._currentState=state;};Tweenable.prototype.pause=function(){this._pausedAtTime=now();this._isPaused=true;return this;};Tweenable.prototype.resume=function(){if(this._isPaused){this._timestamp+=now()-this._pausedAtTime;}
this._isPaused=false;this._isTweening=true;var self=this;this._timeoutHandler=function(){timeoutHandler(self,self._timestamp,self._duration,self._currentState,self._originalState,self._targetState,self._easing,self._step,self._scheduleFunction);};this._timeoutHandler();return this;};Tweenable.prototype.stop=function(gotoEnd){this._isTweening=false;this._isPaused=false;this._timeoutHandler=noop;if(gotoEnd){shallowCopy(this._currentState,this._targetState);applyFilter(this,'afterTweenEnd');this._finish.call(this,this._currentState);}
return this;};Tweenable.prototype.isPlaying=function(){return this._isTweening&&!this._isPaused;};Tweenable.prototype.setScheduleFunction=function(scheduleFunction){this._scheduleFunction=scheduleFunction;};Tweenable.prototype.dispose=function(){var prop;for(prop in this){if(this.hasOwnProperty(prop)){delete this[prop];}}};Tweenable.prototype.filter={};Tweenable.prototype.formula={linear:function(pos){return pos;}};formula=Tweenable.prototype.formula;shallowCopy(Tweenable,{'now':now,'each':each,'tweenProps':tweenProps,'tweenProp':tweenProp,'applyFilter':applyFilter,'shallowCopy':shallowCopy,'defaults':defaults,'composeEasingObject':composeEasingObject});if(typeof SHIFTY_DEBUG_NOW==='function'){root.timeoutHandler=timeoutHandler;}
if(typeof exports==='object'){module.exports=Tweenable;}else if(typeof define==='function'&&define.amd){define(function(){return Tweenable;});}else if(typeof root.Tweenable==='undefined'){root.Tweenable=Tweenable;}
return Tweenable;}());;(function(){Tweenable.shallowCopy(Tweenable.prototype.formula,{easeInQuad:function(pos){return Math.pow(pos,2);},easeOutQuad:function(pos){return-(Math.pow((pos-1),2)-1);},easeInOutQuad:function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,2);}
return-0.5*((pos-=2)*pos-2);},easeInCubic:function(pos){return Math.pow(pos,3);},easeOutCubic:function(pos){return(Math.pow((pos-1),3)+1);},easeInOutCubic:function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,3);}
return 0.5*(Math.pow((pos-2),3)+2);},easeInQuart:function(pos){return Math.pow(pos,4);},easeOutQuart:function(pos){return-(Math.pow((pos-1),4)-1);},easeInOutQuart:function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,4);}
return-0.5*((pos-=2)*Math.pow(pos,3)-2);},easeInQuint:function(pos){return Math.pow(pos,5);},easeOutQuint:function(pos){return(Math.pow((pos-1),5)+1);},easeInOutQuint:function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,5);}
return 0.5*(Math.pow((pos-2),5)+2);},easeInSine:function(pos){return-Math.cos(pos*(Math.PI/2))+1;},easeOutSine:function(pos){return Math.sin(pos*(Math.PI/2));},easeInOutSine:function(pos){return(-0.5*(Math.cos(Math.PI*pos)-1));},easeInExpo:function(pos){return(pos===0)?0:Math.pow(2,10*(pos-1));},easeOutExpo:function(pos){return(pos===1)?1:-Math.pow(2,-10*pos)+1;},easeInOutExpo:function(pos){if(pos===0){return 0;}
if(pos===1){return 1;}
if((pos/=0.5)<1){return 0.5*Math.pow(2,10*(pos-1));}
return 0.5*(-Math.pow(2,-10*--pos)+2);},easeInCirc:function(pos){return-(Math.sqrt(1-(pos*pos))-1);},easeOutCirc:function(pos){return Math.sqrt(1-Math.pow((pos-1),2));},easeInOutCirc:function(pos){if((pos/=0.5)<1){return-0.5*(Math.sqrt(1-pos*pos)-1);}
return 0.5*(Math.sqrt(1-(pos-=2)*pos)+1);},easeOutBounce:function(pos){if((pos)<(1/2.75)){return(7.5625*pos*pos);}else if(pos<(2/2.75)){return(7.5625*(pos-=(1.5/2.75))*pos+0.75);}else if(pos<(2.5/2.75)){return(7.5625*(pos-=(2.25/2.75))*pos+0.9375);}else{return(7.5625*(pos-=(2.625/2.75))*pos+0.984375);}},easeInBack:function(pos){var s=1.70158;return(pos)*pos*((s+1)*pos-s);},easeOutBack:function(pos){var s=1.70158;return(pos=pos-1)*pos*((s+1)*pos+s)+1;},easeInOutBack:function(pos){var s=1.70158;if((pos/=0.5)<1){return 0.5*(pos*pos*(((s*=(1.525))+1)*pos-s));}
return 0.5*((pos-=2)*pos*(((s*=(1.525))+1)*pos+s)+2);},elastic:function(pos){return-1*Math.pow(4,-8*pos)*Math.sin((pos*6-1)*(2*Math.PI)/2)+1;},swingFromTo:function(pos){var s=1.70158;return((pos/=0.5)<1)?0.5*(pos*pos*(((s*=(1.525))+1)*pos-s)):0.5*((pos-=2)*pos*(((s*=(1.525))+1)*pos+s)+2);},swingFrom:function(pos){var s=1.70158;return pos*pos*((s+1)*pos-s);},swingTo:function(pos){var s=1.70158;return(pos-=1)*pos*((s+1)*pos+s)+1;},bounce:function(pos){if(pos<(1/2.75)){return(7.5625*pos*pos);}else if(pos<(2/2.75)){return(7.5625*(pos-=(1.5/2.75))*pos+0.75);}else if(pos<(2.5/2.75)){return(7.5625*(pos-=(2.25/2.75))*pos+0.9375);}else{return(7.5625*(pos-=(2.625/2.75))*pos+0.984375);}},bouncePast:function(pos){if(pos<(1/2.75)){return(7.5625*pos*pos);}else if(pos<(2/2.75)){return 2-(7.5625*(pos-=(1.5/2.75))*pos+0.75);}else if(pos<(2.5/2.75)){return 2-(7.5625*(pos-=(2.25/2.75))*pos+0.9375);}else{return 2-(7.5625*(pos-=(2.625/2.75))*pos+0.984375);}},easeFromTo:function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,4);}
return-0.5*((pos-=2)*Math.pow(pos,3)-2);},easeFrom:function(pos){return Math.pow(pos,4);},easeTo:function(pos){return Math.pow(pos,0.25);}});}());;(function(){function cubicBezierAtTime(t,p1x,p1y,p2x,p2y,duration){var ax=0,bx=0,cx=0,ay=0,by=0,cy=0;function sampleCurveX(t){return((ax*t+bx)*t+cx)*t;}
function sampleCurveY(t){return((ay*t+by)*t+cy)*t;}
function sampleCurveDerivativeX(t){return(3.0*ax*t+2.0*bx)*t+cx;}
function solveEpsilon(duration){return 1.0/(200.0*duration);}
function solve(x,epsilon){return sampleCurveY(solveCurveX(x,epsilon));}
function fabs(n){if(n>=0){return n;}else{return 0-n;}}
function solveCurveX(x,epsilon){var t0,t1,t2,x2,d2,i;for(t2=x,i=0;i<8;i++){x2=sampleCurveX(t2)-x;if(fabs(x2)<epsilon){return t2;}d2=sampleCurveDerivativeX(t2);if(fabs(d2)<1e-6){break;}t2=t2-x2/d2;}
t0=0.0;t1=1.0;t2=x;if(t2<t0){return t0;}if(t2>t1){return t1;}
while(t0<t1){x2=sampleCurveX(t2);if(fabs(x2-x)<epsilon){return t2;}if(x>x2){t0=t2;}else{t1=t2;}t2=(t1-t0)*0.5+t0;}
return t2;}
cx=3.0*p1x;bx=3.0*(p2x-p1x)-cx;ax=1.0-cx-bx;cy=3.0*p1y;by=3.0*(p2y-p1y)-cy;ay=1.0-cy-by;return solve(t,solveEpsilon(duration));}
function getCubicBezierTransition(x1,y1,x2,y2){return function(pos){return cubicBezierAtTime(pos,x1,y1,x2,y2,1);};}
Tweenable.setBezierFunction=function(name,x1,y1,x2,y2){var cubicBezierTransition=getCubicBezierTransition(x1,y1,x2,y2);cubicBezierTransition.x1=x1;cubicBezierTransition.y1=y1;cubicBezierTransition.x2=x2;cubicBezierTransition.y2=y2;return Tweenable.prototype.formula[name]=cubicBezierTransition;};Tweenable.unsetBezierFunction=function(name){delete Tweenable.prototype.formula[name];};})();;(function(){function getInterpolatedValues(from,current,targetState,position,easing){return Tweenable.tweenProps(position,current,from,targetState,1,0,easing);}
var mockTweenable=new Tweenable();mockTweenable._filterArgs=[];Tweenable.interpolate=function(from,targetState,position,easing){var current=Tweenable.shallowCopy({},from);var easingObject=Tweenable.composeEasingObject(from,easing||'linear');mockTweenable.set({});var filterArgs=mockTweenable._filterArgs;filterArgs.length=0;filterArgs[0]=current;filterArgs[1]=from;filterArgs[2]=targetState;filterArgs[3]=easingObject;Tweenable.applyFilter(mockTweenable,'tweenCreated');Tweenable.applyFilter(mockTweenable,'beforeTween');var interpolatedValues=getInterpolatedValues(from,current,targetState,position,easingObject);Tweenable.applyFilter(mockTweenable,'afterTween');return interpolatedValues;};}());function token(){};(function(Tweenable){var formatManifest;var R_NUMBER_COMPONENT=/(\d|\-|\.)/;var R_FORMAT_CHUNKS=/([^\-0-9\.]+)/g;var R_UNFORMATTED_VALUES=/[0-9.\-]+/g;var R_RGB=new RegExp('rgb\\('+R_UNFORMATTED_VALUES.source+(/,\s*/.source)+R_UNFORMATTED_VALUES.source+(/,\s*/.source)+R_UNFORMATTED_VALUES.source+'\\)','g');var R_RGB_PREFIX=/^.*\(/;var R_HEX=/#([0-9]|[a-f]){3,6}/gi;var VALUE_PLACEHOLDER='VAL';var getFormatChunksFrom_accumulator=[];function getFormatChunksFrom(rawValues,prefix){getFormatChunksFrom_accumulator.length=0;var rawValuesLength=rawValues.length;var i;for(i=0;i<rawValuesLength;i++){getFormatChunksFrom_accumulator.push('_'+prefix+'_'+i);}
return getFormatChunksFrom_accumulator;}
function getFormatStringFrom(formattedString){var chunks=formattedString.match(R_FORMAT_CHUNKS);if(!chunks){chunks=['',''];}else if(chunks.length===1||formattedString[0].match(R_NUMBER_COMPONENT)){chunks.unshift('');}
return chunks.join(VALUE_PLACEHOLDER);}
function sanitizeObjectForHexProps(stateObject){Tweenable.each(stateObject,function(prop){var currentProp=stateObject[prop];if(typeof currentProp==='string'&&currentProp.match(R_HEX)){stateObject[prop]=sanitizeHexChunksToRGB(currentProp);}});}
function sanitizeHexChunksToRGB(str){return filterStringChunks(R_HEX,str,convertHexToRGB);}
function convertHexToRGB(hexString){var rgbArr=hexToRGBArray(hexString);return'rgb('+rgbArr[0]+','+rgbArr[1]+','+rgbArr[2]+')';}
var hexToRGBArray_returnArray=[];function hexToRGBArray(hex){hex=hex.replace(/#/,'');if(hex.length===3){hex=hex.split('');hex=hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];}
hexToRGBArray_returnArray[0]=hexToDec(hex.substr(0,2));hexToRGBArray_returnArray[1]=hexToDec(hex.substr(2,2));hexToRGBArray_returnArray[2]=hexToDec(hex.substr(4,2));return hexToRGBArray_returnArray;}
function hexToDec(hex){return parseInt(hex,16);}
function filterStringChunks(pattern,unfilteredString,filter){var pattenMatches=unfilteredString.match(pattern);var filteredString=unfilteredString.replace(pattern,VALUE_PLACEHOLDER);if(pattenMatches){var pattenMatchesLength=pattenMatches.length;var currentChunk;for(var i=0;i<pattenMatchesLength;i++){currentChunk=pattenMatches.shift();filteredString=filteredString.replace(VALUE_PLACEHOLDER,filter(currentChunk));}}
return filteredString;}
function sanitizeRGBChunks(formattedString){return filterStringChunks(R_RGB,formattedString,sanitizeRGBChunk);}
function sanitizeRGBChunk(rgbChunk){var numbers=rgbChunk.match(R_UNFORMATTED_VALUES);var numbersLength=numbers.length;var sanitizedString=rgbChunk.match(R_RGB_PREFIX)[0];for(var i=0;i<numbersLength;i++){sanitizedString+=parseInt(numbers[i],10)+',';}
sanitizedString=sanitizedString.slice(0,-1)+')';return sanitizedString;}
function getFormatManifests(stateObject){var manifestAccumulator={};Tweenable.each(stateObject,function(prop){var currentProp=stateObject[prop];if(typeof currentProp==='string'){var rawValues=getValuesFrom(currentProp);manifestAccumulator[prop]={'formatString':getFormatStringFrom(currentProp),'chunkNames':getFormatChunksFrom(rawValues,prop)};}});return manifestAccumulator;}
function expandFormattedProperties(stateObject,formatManifests){Tweenable.each(formatManifests,function(prop){var currentProp=stateObject[prop];var rawValues=getValuesFrom(currentProp);var rawValuesLength=rawValues.length;for(var i=0;i<rawValuesLength;i++){stateObject[formatManifests[prop].chunkNames[i]]=+rawValues[i];}
delete stateObject[prop];});}
function collapseFormattedProperties(stateObject,formatManifests){Tweenable.each(formatManifests,function(prop){var currentProp=stateObject[prop];var formatChunks=extractPropertyChunks(stateObject,formatManifests[prop].chunkNames);var valuesList=getValuesList(formatChunks,formatManifests[prop].chunkNames);currentProp=getFormattedValues(formatManifests[prop].formatString,valuesList);stateObject[prop]=sanitizeRGBChunks(currentProp);});}
function extractPropertyChunks(stateObject,chunkNames){var extractedValues={};var currentChunkName,chunkNamesLength=chunkNames.length;for(var i=0;i<chunkNamesLength;i++){currentChunkName=chunkNames[i];extractedValues[currentChunkName]=stateObject[currentChunkName];delete stateObject[currentChunkName];}
return extractedValues;}
var getValuesList_accumulator=[];function getValuesList(stateObject,chunkNames){getValuesList_accumulator.length=0;var chunkNamesLength=chunkNames.length;for(var i=0;i<chunkNamesLength;i++){getValuesList_accumulator.push(stateObject[chunkNames[i]]);}
return getValuesList_accumulator;}
function getFormattedValues(formatString,rawValues){var formattedValueString=formatString;var rawValuesLength=rawValues.length;for(var i=0;i<rawValuesLength;i++){formattedValueString=formattedValueString.replace(VALUE_PLACEHOLDER,+rawValues[i].toFixed(4));}
return formattedValueString;}
function getValuesFrom(formattedString){return formattedString.match(R_UNFORMATTED_VALUES);}
function expandEasingObject(easingObject,tokenData){Tweenable.each(tokenData,function(prop){var currentProp=tokenData[prop];var chunkNames=currentProp.chunkNames;var chunkLength=chunkNames.length;var easingChunks=easingObject[prop].split(' ');var lastEasingChunk=easingChunks[easingChunks.length-1];for(var i=0;i<chunkLength;i++){easingObject[chunkNames[i]]=easingChunks[i]||lastEasingChunk;}
delete easingObject[prop];});}
function collapseEasingObject(easingObject,tokenData){Tweenable.each(tokenData,function(prop){var currentProp=tokenData[prop];var chunkNames=currentProp.chunkNames;var chunkLength=chunkNames.length;var composedEasingString='';for(var i=0;i<chunkLength;i++){composedEasingString+=' '+easingObject[chunkNames[i]];delete easingObject[chunkNames[i]];}
easingObject[prop]=composedEasingString.substr(1);});}
Tweenable.prototype.filter.token={'tweenCreated':function(currentState,fromState,toState,easingObject){sanitizeObjectForHexProps(currentState);sanitizeObjectForHexProps(fromState);sanitizeObjectForHexProps(toState);this._tokenData=getFormatManifests(currentState);},'beforeTween':function(currentState,fromState,toState,easingObject){expandEasingObject(easingObject,this._tokenData);expandFormattedProperties(currentState,this._tokenData);expandFormattedProperties(fromState,this._tokenData);expandFormattedProperties(toState,this._tokenData);},'afterTween':function(currentState,fromState,toState,easingObject){collapseFormattedProperties(currentState,this._tokenData);collapseFormattedProperties(fromState,this._tokenData);collapseFormattedProperties(toState,this._tokenData);collapseEasingObject(easingObject,this._tokenData);}};}(Tweenable));}(this));},{}],2:[function(require,module,exports){var Shape=require('./shape');var utils=require('./utils');var Circle=function Circle(container,options){this._pathTemplate='M 50,50 m 0,-{radius}'+' a {radius},{radius} 0 1 1 0,{2radius}'+' a {radius},{radius} 0 1 1 0,-{2radius}';Shape.apply(this,arguments);};Circle.prototype=new Shape();Circle.prototype.constructor=Circle;Circle.prototype._pathString=function _pathString(opts){var widthOfWider=opts.strokeWidth;if(opts.trailWidth&&opts.trailWidth>opts.strokeWidth){widthOfWider=opts.trailWidth;}
var r=50-widthOfWider/2;return utils.render(this._pathTemplate,{radius:r,'2radius':r*2});};Circle.prototype._trailString=function _trailString(opts){return this._pathString(opts);};module.exports=Circle;},{"./shape":6,"./utils":8}],3:[function(require,module,exports){var Shape=require('./shape');var utils=require('./utils');var Line=function Line(container,options){this._pathTemplate='M 0,{center} L 100,{center}';Shape.apply(this,arguments);};Line.prototype=new Shape();Line.prototype.constructor=Line;Line.prototype._initializeSvg=function _initializeSvg(svg,opts){svg.setAttribute('viewBox','0 0 100 '+opts.strokeWidth);svg.setAttribute('preserveAspectRatio','none');};Line.prototype._pathString=function _pathString(opts){return utils.render(this._pathTemplate,{center:opts.strokeWidth/2});};Line.prototype._trailString=function _trailString(opts){return this._pathString(opts);};module.exports=Line;},{"./shape":6,"./utils":8}],4:[function(require,module,exports){var Line=require('./line');var Circle=require('./circle');var Square=require('./square');var Path=require('./path');module.exports={Line:Line,Circle:Circle,Square:Square,Path:Path};},{"./circle":2,"./line":3,"./path":5,"./square":7}],5:[function(require,module,exports){var Tweenable=require('shifty');var utils=require('./utils');var EASING_ALIASES={easeIn:'easeInCubic',easeOut:'easeOutCubic',easeInOut:'easeInOutCubic'};var Path=function Path(path,opts){opts=utils.extend({duration:800,easing:'linear',from:{},to:{},step:function(){}},opts);var element;if(utils.isString(path)){element=document.querySelector(path);}else{element=path;}
this.path=element;this._opts=opts;this._tweenable=null;var length=this.path.getTotalLength();this.path.style.strokeDasharray=length+' '+length;this.set(0);};Path.prototype.value=function value(){var offset=this._getComputedDashOffset();var length=this.path.getTotalLength();var progress=1-offset/length;return parseFloat(progress.toFixed(6),10);};Path.prototype.set=function set(progress){this.stop();this.path.style.strokeDashoffset=this._progressToOffset(progress);var step=this._opts.step;if(utils.isFunction(step)){var easing=this._easing(this._opts.easing);var values=this._calculateTo(progress,easing);step(values,this._opts.shape||this,this._opts.attachment);}};Path.prototype.stop=function stop(){this._stopTween();this.path.style.strokeDashoffset=this._getComputedDashOffset();};Path.prototype.animate=function animate(progress,opts,cb){opts=opts||{};if(utils.isFunction(opts)){cb=opts;opts={};}
var passedOpts=utils.extend({},opts);var defaultOpts=utils.extend({},this._opts);opts=utils.extend(defaultOpts,opts);var shiftyEasing=this._easing(opts.easing);var values=this._resolveFromAndTo(progress,shiftyEasing,passedOpts);this.stop();this.path.getBoundingClientRect();var offset=this._getComputedDashOffset();var newOffset=this._progressToOffset(progress);var self=this;this._tweenable=new Tweenable();this._tweenable.tween({from:utils.extend({offset:offset},values.from),to:utils.extend({offset:newOffset},values.to),duration:opts.duration,easing:shiftyEasing,step:function(state){self.path.style.strokeDashoffset=state.offset;opts.step(state,opts.shape||self,opts.attachment);},finish:function(state){if(utils.isFunction(cb)){cb();}}});};Path.prototype._getComputedDashOffset=function _getComputedDashOffset(){var computedStyle=window.getComputedStyle(this.path,null);return parseFloat(computedStyle.getPropertyValue('stroke-dashoffset'),10);};Path.prototype._progressToOffset=function _progressToOffset(progress){var length=this.path.getTotalLength();return length-progress*length;};Path.prototype._resolveFromAndTo=function _resolveFromAndTo(progress,easing,opts){if(opts.from&&opts.to){return{from:opts.from,to:opts.to};}
return{from:this._calculateFrom(easing),to:this._calculateTo(progress,easing)};};Path.prototype._calculateFrom=function _calculateFrom(easing){return Tweenable.interpolate(this._opts.from,this._opts.to,this.value(),easing);};Path.prototype._calculateTo=function _calculateTo(progress,easing){return Tweenable.interpolate(this._opts.from,this._opts.to,progress,easing);};Path.prototype._stopTween=function _stopTween(){if(this._tweenable!==null){this._tweenable.stop();this._tweenable.dispose();this._tweenable=null;}};Path.prototype._easing=function _easing(easing){if(EASING_ALIASES.hasOwnProperty(easing)){return EASING_ALIASES[easing];}
return easing;};module.exports=Path;},{"./utils":8,"shifty":1}],6:[function(require,module,exports){var Path=require('./path');var utils=require('./utils');var DESTROYED_ERROR='Object is destroyed';var Shape=function Shape(container,opts){if(!(this instanceof Shape)){throw new Error('Constructor was called without new keyword');}
if(arguments.length===0)return;this._opts=utils.extend({color:'#555',strokeWidth:1.0,trailColor:null,trailWidth:null,fill:null,text:{autoStyle:true,color:null,value:'',className:'progressbar-text'}},opts,true);var svgView=this._createSvgView(this._opts);var element;if(utils.isString(container)){element=document.querySelector(container);}else{element=container;}
if(!element){throw new Error('Container does not exist: '+container);}
this._container=element;this._container.appendChild(svgView.svg);this.text=null;if(this._opts.text.value){this.text=this._createTextElement(this._opts,this._container);this._container.appendChild(this.text);}
this.svg=svgView.svg;this.path=svgView.path;this.trail=svgView.trail;var newOpts=utils.extend({attachment:undefined,shape:this},this._opts);this._progressPath=new Path(svgView.path,newOpts);};Shape.prototype.animate=function animate(progress,opts,cb){if(this._progressPath===null)throw new Error(DESTROYED_ERROR);this._progressPath.animate(progress,opts,cb);};Shape.prototype.stop=function stop(){if(this._progressPath===null)throw new Error(DESTROYED_ERROR);if(this._progressPath===undefined)return;this._progressPath.stop();};Shape.prototype.destroy=function destroy(){if(this._progressPath===null)throw new Error(DESTROYED_ERROR);this.stop();this.svg.parentNode.removeChild(this.svg);this.svg=null;this.path=null;this.trail=null;this._progressPath=null;if(this.text!==null){this.text.parentNode.removeChild(this.text);this.text=null;}};Shape.prototype.set=function set(progress){if(this._progressPath===null)throw new Error(DESTROYED_ERROR);this._progressPath.set(progress);};Shape.prototype.value=function value(){if(this._progressPath===null)throw new Error(DESTROYED_ERROR);if(this._progressPath===undefined)return 0;return this._progressPath.value();};Shape.prototype.setText=function setText(text){if(this._progressPath===null)throw new Error(DESTROYED_ERROR);if(this.text===null){this.text=this._createTextElement(this._opts,this._container);this._container.appendChild(this.text);}
this.text.removeChild(this.text.firstChild);this.text.appendChild(document.createTextNode(text));};Shape.prototype._createSvgView=function _createSvgView(opts){var svg=document.createElementNS('http://www.w3.org/2000/svg','svg');this._initializeSvg(svg,opts);var trailPath=null;if(opts.trailColor||opts.trailWidth){trailPath=this._createTrail(opts);svg.appendChild(trailPath);}
var path=this._createPath(opts);svg.appendChild(path);return{svg:svg,path:path,trail:trailPath};};Shape.prototype._initializeSvg=function _initializeSvg(svg,opts){svg.setAttribute('viewBox','0 0 100 100');};Shape.prototype._createPath=function _createPath(opts){var pathString=this._pathString(opts);return this._createPathElement(pathString,opts);};Shape.prototype._createTrail=function _createTrail(opts){var pathString=this._trailString(opts);var newOpts=utils.extend({},opts);if(!newOpts.trailColor)newOpts.trailColor='#eee';if(!newOpts.trailWidth)newOpts.trailWidth=newOpts.strokeWidth;newOpts.color=newOpts.trailColor;newOpts.strokeWidth=newOpts.trailWidth;newOpts.fill=null;return this._createPathElement(pathString,newOpts);};Shape.prototype._createPathElement=function _createPathElement(pathString,opts){var path=document.createElementNS('http://www.w3.org/2000/svg','path');path.setAttribute('d',pathString);path.setAttribute('stroke',opts.color);path.setAttribute('stroke-width',opts.strokeWidth);if(opts.fill){path.setAttribute('fill',opts.fill);}else{path.setAttribute('fill-opacity','0');}
return path;};Shape.prototype._createTextElement=function _createTextElement(opts,container){var element=document.createElement('p');element.appendChild(document.createTextNode(opts.text.value));if(opts.text.autoStyle){container.style.position='relative';element.style.position='absolute';element.style.top='50%';element.style.left='50%';element.style.padding=0;element.style.margin=0;utils.setStyle(element,'transform','translate(-50%, -50%)');if(opts.text.color){element.style.color=opts.text.color;}else{element.style.color=opts.color;}}
element.className=opts.text.className;return element;};Shape.prototype._pathString=function _pathString(opts){throw new Error('Override this function for each progress bar');};Shape.prototype._trailString=function _trailString(opts){throw new Error('Override this function for each progress bar');};module.exports=Shape;},{"./path":5,"./utils":8}],7:[function(require,module,exports){var Shape=require('./shape');var utils=require('./utils');var Square=function Square(container,options){this._pathTemplate='M 0,{halfOfStrokeWidth}'+' L {width},{halfOfStrokeWidth}'+' L {width},{width}'+' L {halfOfStrokeWidth},{width}'+' L {halfOfStrokeWidth},{strokeWidth}';this._trailTemplate='M {startMargin},{halfOfStrokeWidth}'+' L {width},{halfOfStrokeWidth}'+' L {width},{width}'+' L {halfOfStrokeWidth},{width}'+' L {halfOfStrokeWidth},{halfOfStrokeWidth}';Shape.apply(this,arguments);};Square.prototype=new Shape();Square.prototype.constructor=Square;Square.prototype._pathString=function _pathString(opts){var w=100-opts.strokeWidth/2;return utils.render(this._pathTemplate,{width:w,strokeWidth:opts.strokeWidth,halfOfStrokeWidth:opts.strokeWidth/2});};Square.prototype._trailString=function _trailString(opts){var w=100-opts.strokeWidth/2;return utils.render(this._trailTemplate,{width:w,strokeWidth:opts.strokeWidth,halfOfStrokeWidth:opts.strokeWidth/2,startMargin:(opts.strokeWidth/2)-(opts.trailWidth/2)});};module.exports=Square;},{"./shape":6,"./utils":8}],8:[function(require,module,exports){var PREFIXES='Webkit Moz O ms'.split(' ');function extend(destination,source,recursive){destination=destination||{};source=source||{};recursive=recursive||false;for(var attrName in source){if(source.hasOwnProperty(attrName)){var destVal=destination[attrName];var sourceVal=source[attrName];if(recursive&&isObject(destVal)&&isObject(sourceVal)){destination[attrName]=extend(destVal,sourceVal,recursive);}else{destination[attrName]=sourceVal;}}}
return destination;}
function render(template,vars){var rendered=template;for(var key in vars){if(vars.hasOwnProperty(key)){var val=vars[key];var regExpString='\\{'+key+'\\}';var regExp=new RegExp(regExpString,'g');rendered=rendered.replace(regExp,val);}}
return rendered;}
function setStyle(element,style,value){for(var i=0;i<PREFIXES.length;++i){var prefix=PREFIXES[i];element.style[prefix+capitalize(style)]=value;}
element.style[style]=value;}
function capitalize(text){return text.charAt(0).toUpperCase()+text.slice(1);}
function isString(obj){return typeof obj==='string'||obj instanceof String;}
function isFunction(obj){return typeof obj==='function';}
function isArray(obj){return Object.prototype.toString.call(obj)==='[object Array]';}
function isObject(obj){if(isArray(obj))return false;var type=typeof obj;return type==='object'&&!!obj;}
module.exports={extend:extend,render:render,setStyle:setStyle,capitalize:capitalize,isString:isString,isFunction:isFunction,isObject:isObject};},{}]},{},[4])(4)});
</script>
<script type="text/javascript">
/*! jQuery v1.11.0 | (c) 2005, 2014 jQuery Foundation, Inc. | jquery.org/license */
!function(a,b){"object"==typeof module&&"object"==typeof module.exports?module.exports=a.document?b(a,!0):function(a){if(!a.document)throw new Error("jQuery requires a window with a document");return b(a)}:b(a)}("undefined"!=typeof window?window:this,function(a,b){var c=[],d=c.slice,e=c.concat,f=c.push,g=c.indexOf,h={},i=h.toString,j=h.hasOwnProperty,k="".trim,l={},m="1.11.0",n=function(a,b){return new n.fn.init(a,b)},o=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,p=/^-ms-/,q=/-([\da-z])/gi,r=function(a,b){return b.toUpperCase()};n.fn=n.prototype={jquery:m,constructor:n,selector:"",length:0,toArray:function(){return d.call(this)},get:function(a){return null!=a?0>a?this[a+this.length]:this[a]:d.call(this)},pushStack:function(a){var b=n.merge(this.constructor(),a);return b.prevObject=this,b.context=this.context,b},each:function(a,b){return n.each(this,a,b)},map:function(a){return this.pushStack(n.map(this,function(b,c){return a.call(b,c,b)}))},slice:function(){return this.pushStack(d.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(a){var b=this.length,c=+a+(0>a?b:0);return this.pushStack(c>=0&&b>c?[this[c]]:[])},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:c.sort,splice:c.splice},n.extend=n.fn.extend=function(){var a,b,c,d,e,f,g=arguments[0]||{},h=1,i=arguments.length,j=!1;for("boolean"==typeof g&&(j=g,g=arguments[h]||{},h++),"object"==typeof g||n.isFunction(g)||(g={}),h===i&&(g=this,h--);i>h;h++)if(null!=(e=arguments[h]))for(d in e)a=g[d],c=e[d],g!==c&&(j&&c&&(n.isPlainObject(c)||(b=n.isArray(c)))?(b?(b=!1,f=a&&n.isArray(a)?a:[]):f=a&&n.isPlainObject(a)?a:{},g[d]=n.extend(j,f,c)):void 0!==c&&(g[d]=c));return g},n.extend({expando:"jQuery"+(m+Math.random()).replace(/\D/g,""),isReady:!0,error:function(a){throw new Error(a)},noop:function(){},isFunction:function(a){return"function"===n.type(a)},isArray:Array.isArray||function(a){return"array"===n.type(a)},isWindow:function(a){return null!=a&&a==a.window},isNumeric:function(a){return a-parseFloat(a)>=0},isEmptyObject:function(a){var b;for(b in a)return!1;return!0},isPlainObject:function(a){var b;if(!a||"object"!==n.type(a)||a.nodeType||n.isWindow(a))return!1;try{if(a.constructor&&!j.call(a,"constructor")&&!j.call(a.constructor.prototype,"isPrototypeOf"))return!1}catch(c){return!1}if(l.ownLast)for(b in a)return j.call(a,b);for(b in a);return void 0===b||j.call(a,b)},type:function(a){return null==a?a+"":"object"==typeof a||"function"==typeof a?h[i.call(a)]||"object":typeof a},globalEval:function(b){b&&n.trim(b)&&(a.execScript||function(b){a.eval.call(a,b)})(b)},camelCase:function(a){return a.replace(p,"ms-").replace(q,r)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toLowerCase()===b.toLowerCase()},each:function(a,b,c){var d,e=0,f=a.length,g=s(a);if(c){if(g){for(;f>e;e++)if(d=b.apply(a[e],c),d===!1)break}else for(e in a)if(d=b.apply(a[e],c),d===!1)break}else if(g){for(;f>e;e++)if(d=b.call(a[e],e,a[e]),d===!1)break}else for(e in a)if(d=b.call(a[e],e,a[e]),d===!1)break;return a},trim:k&&!k.call("\ufeff\xa0")?function(a){return null==a?"":k.call(a)}:function(a){return null==a?"":(a+"").replace(o,"")},makeArray:function(a,b){var c=b||[];return null!=a&&(s(Object(a))?n.merge(c,"string"==typeof a?[a]:a):f.call(c,a)),c},inArray:function(a,b,c){var d;if(b){if(g)return g.call(b,a,c);for(d=b.length,c=c?0>c?Math.max(0,d+c):c:0;d>c;c++)if(c in b&&b[c]===a)return c}return-1},merge:function(a,b){var c=+b.length,d=0,e=a.length;while(c>d)a[e++]=b[d++];if(c!==c)while(void 0!==b[d])a[e++]=b[d++];return a.length=e,a},grep:function(a,b,c){for(var d,e=[],f=0,g=a.length,h=!c;g>f;f++)d=!b(a[f],f),d!==h&&e.push(a[f]);return e},map:function(a,b,c){var d,f=0,g=a.length,h=s(a),i=[];if(h)for(;g>f;f++)d=b(a[f],f,c),null!=d&&i.push(d);else for(f in a)d=b(a[f],f,c),null!=d&&i.push(d);return e.apply([],i)},guid:1,proxy:function(a,b){var c,e,f;return"string"==typeof b&&(f=a[b],b=a,a=f),n.isFunction(a)?(c=d.call(arguments,2),e=function(){return a.apply(b||this,c.concat(d.call(arguments)))},e.guid=a.guid=a.guid||n.guid++,e):void 0},now:function(){return+new Date},support:l}),n.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),function(a,b){h["[object "+b+"]"]=b.toLowerCase()});function s(a){var b=a.length,c=n.type(a);return"function"===c||n.isWindow(a)?!1:1===a.nodeType&&b?!0:"array"===c||0===b||"number"==typeof b&&b>0&&b-1 in a}var t=function(a){var b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s="sizzle"+-new Date,t=a.document,u=0,v=0,w=eb(),x=eb(),y=eb(),z=function(a,b){return a===b&&(j=!0),0},A="undefined",B=1<<31,C={}.hasOwnProperty,D=[],E=D.pop,F=D.push,G=D.push,H=D.slice,I=D.indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(this[b]===a)return b;return-1},J="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",K="[\\x20\\t\\r\\n\\f]",L="(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",M=L.replace("w","w#"),N="\\["+K+"*("+L+")"+K+"*(?:([*^$|!~]?=)"+K+"*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|("+M+")|)|)"+K+"*\\]",O=":("+L+")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|"+N.replace(3,8)+")*)|.*)\\)|)",P=new RegExp("^"+K+"+|((?:^|[^\\\\])(?:\\\\.)*)"+K+"+$","g"),Q=new RegExp("^"+K+"*,"+K+"*"),R=new RegExp("^"+K+"*([>+~]|"+K+")"+K+"*"),S=new RegExp("="+K+"*([^\\]'\"]*?)"+K+"*\\]","g"),T=new RegExp(O),U=new RegExp("^"+M+"$"),V={ID:new RegExp("^#("+L+")"),CLASS:new RegExp("^\\.("+L+")"),TAG:new RegExp("^("+L.replace("w","w*")+")"),ATTR:new RegExp("^"+N),PSEUDO:new RegExp("^"+O),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+K+"*(even|odd|(([+-]|)(\\d*)n|)"+K+"*(?:([+-]|)"+K+"*(\\d+)|))"+K+"*\\)|)","i"),bool:new RegExp("^(?:"+J+")$","i"),needsContext:new RegExp("^"+K+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+K+"*((?:-\\d)?\\d*)"+K+"*\\)|)(?=[^-]|$)","i")},W=/^(?:input|select|textarea|button)$/i,X=/^h\d$/i,Y=/^[^{]+\{\s*\[native \w/,Z=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,$=/[+~]/,_=/'|\\/g,ab=new RegExp("\\\\([\\da-f]{1,6}"+K+"?|("+K+")|.)","ig"),bb=function(a,b,c){var d="0x"+b-65536;return d!==d||c?b:0>d?String.fromCharCode(d+65536):String.fromCharCode(d>>10|55296,1023&d|56320)};try{G.apply(D=H.call(t.childNodes),t.childNodes),D[t.childNodes.length].nodeType}catch(cb){G={apply:D.length?function(a,b){F.apply(a,H.call(b))}:function(a,b){var c=a.length,d=0;while(a[c++]=b[d++]);a.length=c-1}}}function db(a,b,d,e){var f,g,h,i,j,m,p,q,u,v;if((b?b.ownerDocument||b:t)!==l&&k(b),b=b||l,d=d||[],!a||"string"!=typeof a)return d;if(1!==(i=b.nodeType)&&9!==i)return[];if(n&&!e){if(f=Z.exec(a))if(h=f[1]){if(9===i){if(g=b.getElementById(h),!g||!g.parentNode)return d;if(g.id===h)return d.push(g),d}else if(b.ownerDocument&&(g=b.ownerDocument.getElementById(h))&&r(b,g)&&g.id===h)return d.push(g),d}else{if(f[2])return G.apply(d,b.getElementsByTagName(a)),d;if((h=f[3])&&c.getElementsByClassName&&b.getElementsByClassName)return G.apply(d,b.getElementsByClassName(h)),d}if(c.qsa&&(!o||!o.test(a))){if(q=p=s,u=b,v=9===i&&a,1===i&&"object"!==b.nodeName.toLowerCase()){m=ob(a),(p=b.getAttribute("id"))?q=p.replace(_,"\\$&"):b.setAttribute("id",q),q="[id='"+q+"'] ",j=m.length;while(j--)m[j]=q+pb(m[j]);u=$.test(a)&&mb(b.parentNode)||b,v=m.join(",")}if(v)try{return G.apply(d,u.querySelectorAll(v)),d}catch(w){}finally{p||b.removeAttribute("id")}}}return xb(a.replace(P,"$1"),b,d,e)}function eb(){var a=[];function b(c,e){return a.push(c+" ")>d.cacheLength&&delete b[a.shift()],b[c+" "]=e}return b}function fb(a){return a[s]=!0,a}function gb(a){var b=l.createElement("div");try{return!!a(b)}catch(c){return!1}finally{b.parentNode&&b.parentNode.removeChild(b),b=null}}function hb(a,b){var c=a.split("|"),e=a.length;while(e--)d.attrHandle[c[e]]=b}function ib(a,b){var c=b&&a,d=c&&1===a.nodeType&&1===b.nodeType&&(~b.sourceIndex||B)-(~a.sourceIndex||B);if(d)return d;if(c)while(c=c.nextSibling)if(c===b)return-1;return a?1:-1}function jb(a){return function(b){var c=b.nodeName.toLowerCase();return"input"===c&&b.type===a}}function kb(a){return function(b){var c=b.nodeName.toLowerCase();return("input"===c||"button"===c)&&b.type===a}}function lb(a){return fb(function(b){return b=+b,fb(function(c,d){var e,f=a([],c.length,b),g=f.length;while(g--)c[e=f[g]]&&(c[e]=!(d[e]=c[e]))})})}function mb(a){return a&&typeof a.getElementsByTagName!==A&&a}c=db.support={},f=db.isXML=function(a){var b=a&&(a.ownerDocument||a).documentElement;return b?"HTML"!==b.nodeName:!1},k=db.setDocument=function(a){var b,e=a?a.ownerDocument||a:t,g=e.defaultView;return e!==l&&9===e.nodeType&&e.documentElement?(l=e,m=e.documentElement,n=!f(e),g&&g!==g.top&&(g.addEventListener?g.addEventListener("unload",function(){k()},!1):g.attachEvent&&g.attachEvent("onunload",function(){k()})),c.attributes=gb(function(a){return a.className="i",!a.getAttribute("className")}),c.getElementsByTagName=gb(function(a){return a.appendChild(e.createComment("")),!a.getElementsByTagName("*").length}),c.getElementsByClassName=Y.test(e.getElementsByClassName)&&gb(function(a){return a.innerHTML="<div class='a'></div><div class='a i'></div>",a.firstChild.className="i",2===a.getElementsByClassName("i").length}),c.getById=gb(function(a){return m.appendChild(a).id=s,!e.getElementsByName||!e.getElementsByName(s).length}),c.getById?(d.find.ID=function(a,b){if(typeof b.getElementById!==A&&n){var c=b.getElementById(a);return c&&c.parentNode?[c]:[]}},d.filter.ID=function(a){var b=a.replace(ab,bb);return function(a){return a.getAttribute("id")===b}}):(delete d.find.ID,d.filter.ID=function(a){var b=a.replace(ab,bb);return function(a){var c=typeof a.getAttributeNode!==A&&a.getAttributeNode("id");return c&&c.value===b}}),d.find.TAG=c.getElementsByTagName?function(a,b){return typeof b.getElementsByTagName!==A?b.getElementsByTagName(a):void 0}:function(a,b){var c,d=[],e=0,f=b.getElementsByTagName(a);if("*"===a){while(c=f[e++])1===c.nodeType&&d.push(c);return d}return f},d.find.CLASS=c.getElementsByClassName&&function(a,b){return typeof b.getElementsByClassName!==A&&n?b.getElementsByClassName(a):void 0},p=[],o=[],(c.qsa=Y.test(e.querySelectorAll))&&(gb(function(a){a.innerHTML="<select t=''><option selected=''></option></select>",a.querySelectorAll("[t^='']").length&&o.push("[*^$]="+K+"*(?:''|\"\")"),a.querySelectorAll("[selected]").length||o.push("\\["+K+"*(?:value|"+J+")"),a.querySelectorAll(":checked").length||o.push(":checked")}),gb(function(a){var b=e.createElement("input");b.setAttribute("type","hidden"),a.appendChild(b).setAttribute("name","D"),a.querySelectorAll("[name=d]").length&&o.push("name"+K+"*[*^$|!~]?="),a.querySelectorAll(":enabled").length||o.push(":enabled",":disabled"),a.querySelectorAll("*,:x"),o.push(",.*:")})),(c.matchesSelector=Y.test(q=m.webkitMatchesSelector||m.mozMatchesSelector||m.oMatchesSelector||m.msMatchesSelector))&&gb(function(a){c.disconnectedMatch=q.call(a,"div"),q.call(a,"[s!='']:x"),p.push("!=",O)}),o=o.length&&new RegExp(o.join("|")),p=p.length&&new RegExp(p.join("|")),b=Y.test(m.compareDocumentPosition),r=b||Y.test(m.contains)?function(a,b){var c=9===a.nodeType?a.documentElement:a,d=b&&b.parentNode;return a===d||!(!d||1!==d.nodeType||!(c.contains?c.contains(d):a.compareDocumentPosition&&16&a.compareDocumentPosition(d)))}:function(a,b){if(b)while(b=b.parentNode)if(b===a)return!0;return!1},z=b?function(a,b){if(a===b)return j=!0,0;var d=!a.compareDocumentPosition-!b.compareDocumentPosition;return d?d:(d=(a.ownerDocument||a)===(b.ownerDocument||b)?a.compareDocumentPosition(b):1,1&d||!c.sortDetached&&b.compareDocumentPosition(a)===d?a===e||a.ownerDocument===t&&r(t,a)?-1:b===e||b.ownerDocument===t&&r(t,b)?1:i?I.call(i,a)-I.call(i,b):0:4&d?-1:1)}:function(a,b){if(a===b)return j=!0,0;var c,d=0,f=a.parentNode,g=b.parentNode,h=[a],k=[b];if(!f||!g)return a===e?-1:b===e?1:f?-1:g?1:i?I.call(i,a)-I.call(i,b):0;if(f===g)return ib(a,b);c=a;while(c=c.parentNode)h.unshift(c);c=b;while(c=c.parentNode)k.unshift(c);while(h[d]===k[d])d++;return d?ib(h[d],k[d]):h[d]===t?-1:k[d]===t?1:0},e):l},db.matches=function(a,b){return db(a,null,null,b)},db.matchesSelector=function(a,b){if((a.ownerDocument||a)!==l&&k(a),b=b.replace(S,"='$1']"),!(!c.matchesSelector||!n||p&&p.test(b)||o&&o.test(b)))try{var d=q.call(a,b);if(d||c.disconnectedMatch||a.document&&11!==a.document.nodeType)return d}catch(e){}return db(b,l,null,[a]).length>0},db.contains=function(a,b){return(a.ownerDocument||a)!==l&&k(a),r(a,b)},db.attr=function(a,b){(a.ownerDocument||a)!==l&&k(a);var e=d.attrHandle[b.toLowerCase()],f=e&&C.call(d.attrHandle,b.toLowerCase())?e(a,b,!n):void 0;return void 0!==f?f:c.attributes||!n?a.getAttribute(b):(f=a.getAttributeNode(b))&&f.specified?f.value:null},db.error=function(a){throw new Error("Syntax error, unrecognized expression: "+a)},db.uniqueSort=function(a){var b,d=[],e=0,f=0;if(j=!c.detectDuplicates,i=!c.sortStable&&a.slice(0),a.sort(z),j){while(b=a[f++])b===a[f]&&(e=d.push(f));while(e--)a.splice(d[e],1)}return i=null,a},e=db.getText=function(a){var b,c="",d=0,f=a.nodeType;if(f){if(1===f||9===f||11===f){if("string"==typeof a.textContent)return a.textContent;for(a=a.firstChild;a;a=a.nextSibling)c+=e(a)}else if(3===f||4===f)return a.nodeValue}else while(b=a[d++])c+=e(b);return c},d=db.selectors={cacheLength:50,createPseudo:fb,match:V,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(a){return a[1]=a[1].replace(ab,bb),a[3]=(a[4]||a[5]||"").replace(ab,bb),"~="===a[2]&&(a[3]=" "+a[3]+" "),a.slice(0,4)},CHILD:function(a){return a[1]=a[1].toLowerCase(),"nth"===a[1].slice(0,3)?(a[3]||db.error(a[0]),a[4]=+(a[4]?a[5]+(a[6]||1):2*("even"===a[3]||"odd"===a[3])),a[5]=+(a[7]+a[8]||"odd"===a[3])):a[3]&&db.error(a[0]),a},PSEUDO:function(a){var b,c=!a[5]&&a[2];return V.CHILD.test(a[0])?null:(a[3]&&void 0!==a[4]?a[2]=a[4]:c&&T.test(c)&&(b=ob(c,!0))&&(b=c.indexOf(")",c.length-b)-c.length)&&(a[0]=a[0].slice(0,b),a[2]=c.slice(0,b)),a.slice(0,3))}},filter:{TAG:function(a){var b=a.replace(ab,bb).toLowerCase();return"*"===a?function(){return!0}:function(a){return a.nodeName&&a.nodeName.toLowerCase()===b}},CLASS:function(a){var b=w[a+" "];return b||(b=new RegExp("(^|"+K+")"+a+"("+K+"|$)"))&&w(a,function(a){return b.test("string"==typeof a.className&&a.className||typeof a.getAttribute!==A&&a.getAttribute("class")||"")})},ATTR:function(a,b,c){return function(d){var e=db.attr(d,a);return null==e?"!="===b:b?(e+="","="===b?e===c:"!="===b?e!==c:"^="===b?c&&0===e.indexOf(c):"*="===b?c&&e.indexOf(c)>-1:"$="===b?c&&e.slice(-c.length)===c:"~="===b?(" "+e+" ").indexOf(c)>-1:"|="===b?e===c||e.slice(0,c.length+1)===c+"-":!1):!0}},CHILD:function(a,b,c,d,e){var f="nth"!==a.slice(0,3),g="last"!==a.slice(-4),h="of-type"===b;return 1===d&&0===e?function(a){return!!a.parentNode}:function(b,c,i){var j,k,l,m,n,o,p=f!==g?"nextSibling":"previousSibling",q=b.parentNode,r=h&&b.nodeName.toLowerCase(),t=!i&&!h;if(q){if(f){while(p){l=b;while(l=l[p])if(h?l.nodeName.toLowerCase()===r:1===l.nodeType)return!1;o=p="only"===a&&!o&&"nextSibling"}return!0}if(o=[g?q.firstChild:q.lastChild],g&&t){k=q[s]||(q[s]={}),j=k[a]||[],n=j[0]===u&&j[1],m=j[0]===u&&j[2],l=n&&q.childNodes[n];while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if(1===l.nodeType&&++m&&l===b){k[a]=[u,n,m];break}}else if(t&&(j=(b[s]||(b[s]={}))[a])&&j[0]===u)m=j[1];else while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if((h?l.nodeName.toLowerCase()===r:1===l.nodeType)&&++m&&(t&&((l[s]||(l[s]={}))[a]=[u,m]),l===b))break;return m-=e,m===d||m%d===0&&m/d>=0}}},PSEUDO:function(a,b){var c,e=d.pseudos[a]||d.setFilters[a.toLowerCase()]||db.error("unsupported pseudo: "+a);return e[s]?e(b):e.length>1?(c=[a,a,"",b],d.setFilters.hasOwnProperty(a.toLowerCase())?fb(function(a,c){var d,f=e(a,b),g=f.length;while(g--)d=I.call(a,f[g]),a[d]=!(c[d]=f[g])}):function(a){return e(a,0,c)}):e}},pseudos:{not:fb(function(a){var b=[],c=[],d=g(a.replace(P,"$1"));return d[s]?fb(function(a,b,c,e){var f,g=d(a,null,e,[]),h=a.length;while(h--)(f=g[h])&&(a[h]=!(b[h]=f))}):function(a,e,f){return b[0]=a,d(b,null,f,c),!c.pop()}}),has:fb(function(a){return function(b){return db(a,b).length>0}}),contains:fb(function(a){return function(b){return(b.textContent||b.innerText||e(b)).indexOf(a)>-1}}),lang:fb(function(a){return U.test(a||"")||db.error("unsupported lang: "+a),a=a.replace(ab,bb).toLowerCase(),function(b){var c;do if(c=n?b.lang:b.getAttribute("xml:lang")||b.getAttribute("lang"))return c=c.toLowerCase(),c===a||0===c.indexOf(a+"-");while((b=b.parentNode)&&1===b.nodeType);return!1}}),target:function(b){var c=a.location&&a.location.hash;return c&&c.slice(1)===b.id},root:function(a){return a===m},focus:function(a){return a===l.activeElement&&(!l.hasFocus||l.hasFocus())&&!!(a.type||a.href||~a.tabIndex)},enabled:function(a){return a.disabled===!1},disabled:function(a){return a.disabled===!0},checked:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&!!a.checked||"option"===b&&!!a.selected},selected:function(a){return a.parentNode&&a.parentNode.selectedIndex,a.selected===!0},empty:function(a){for(a=a.firstChild;a;a=a.nextSibling)if(a.nodeType<6)return!1;return!0},parent:function(a){return!d.pseudos.empty(a)},header:function(a){return X.test(a.nodeName)},input:function(a){return W.test(a.nodeName)},button:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&"button"===a.type||"button"===b},text:function(a){var b;return"input"===a.nodeName.toLowerCase()&&"text"===a.type&&(null==(b=a.getAttribute("type"))||"text"===b.toLowerCase())},first:lb(function(){return[0]}),last:lb(function(a,b){return[b-1]}),eq:lb(function(a,b,c){return[0>c?c+b:c]}),even:lb(function(a,b){for(var c=0;b>c;c+=2)a.push(c);return a}),odd:lb(function(a,b){for(var c=1;b>c;c+=2)a.push(c);return a}),lt:lb(function(a,b,c){for(var d=0>c?c+b:c;--d>=0;)a.push(d);return a}),gt:lb(function(a,b,c){for(var d=0>c?c+b:c;++d<b;)a.push(d);return a})}},d.pseudos.nth=d.pseudos.eq;for(b in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})d.pseudos[b]=jb(b);for(b in{submit:!0,reset:!0})d.pseudos[b]=kb(b);function nb(){}nb.prototype=d.filters=d.pseudos,d.setFilters=new nb;function ob(a,b){var c,e,f,g,h,i,j,k=x[a+" "];if(k)return b?0:k.slice(0);h=a,i=[],j=d.preFilter;while(h){(!c||(e=Q.exec(h)))&&(e&&(h=h.slice(e[0].length)||h),i.push(f=[])),c=!1,(e=R.exec(h))&&(c=e.shift(),f.push({value:c,type:e[0].replace(P," ")}),h=h.slice(c.length));for(g in d.filter)!(e=V[g].exec(h))||j[g]&&!(e=j[g](e))||(c=e.shift(),f.push({value:c,type:g,matches:e}),h=h.slice(c.length));if(!c)break}return b?h.length:h?db.error(a):x(a,i).slice(0)}function pb(a){for(var b=0,c=a.length,d="";c>b;b++)d+=a[b].value;return d}function qb(a,b,c){var d=b.dir,e=c&&"parentNode"===d,f=v++;return b.first?function(b,c,f){while(b=b[d])if(1===b.nodeType||e)return a(b,c,f)}:function(b,c,g){var h,i,j=[u,f];if(g){while(b=b[d])if((1===b.nodeType||e)&&a(b,c,g))return!0}else while(b=b[d])if(1===b.nodeType||e){if(i=b[s]||(b[s]={}),(h=i[d])&&h[0]===u&&h[1]===f)return j[2]=h[2];if(i[d]=j,j[2]=a(b,c,g))return!0}}}function rb(a){return a.length>1?function(b,c,d){var e=a.length;while(e--)if(!a[e](b,c,d))return!1;return!0}:a[0]}function sb(a,b,c,d,e){for(var f,g=[],h=0,i=a.length,j=null!=b;i>h;h++)(f=a[h])&&(!c||c(f,d,e))&&(g.push(f),j&&b.push(h));return g}function tb(a,b,c,d,e,f){return d&&!d[s]&&(d=tb(d)),e&&!e[s]&&(e=tb(e,f)),fb(function(f,g,h,i){var j,k,l,m=[],n=[],o=g.length,p=f||wb(b||"*",h.nodeType?[h]:h,[]),q=!a||!f&&b?p:sb(p,m,a,h,i),r=c?e||(f?a:o||d)?[]:g:q;if(c&&c(q,r,h,i),d){j=sb(r,n),d(j,[],h,i),k=j.length;while(k--)(l=j[k])&&(r[n[k]]=!(q[n[k]]=l))}if(f){if(e||a){if(e){j=[],k=r.length;while(k--)(l=r[k])&&j.push(q[k]=l);e(null,r=[],j,i)}k=r.length;while(k--)(l=r[k])&&(j=e?I.call(f,l):m[k])>-1&&(f[j]=!(g[j]=l))}}else r=sb(r===g?r.splice(o,r.length):r),e?e(null,g,r,i):G.apply(g,r)})}function ub(a){for(var b,c,e,f=a.length,g=d.relative[a[0].type],i=g||d.relative[" "],j=g?1:0,k=qb(function(a){return a===b},i,!0),l=qb(function(a){return I.call(b,a)>-1},i,!0),m=[function(a,c,d){return!g&&(d||c!==h)||((b=c).nodeType?k(a,c,d):l(a,c,d))}];f>j;j++)if(c=d.relative[a[j].type])m=[qb(rb(m),c)];else{if(c=d.filter[a[j].type].apply(null,a[j].matches),c[s]){for(e=++j;f>e;e++)if(d.relative[a[e].type])break;return tb(j>1&&rb(m),j>1&&pb(a.slice(0,j-1).concat({value:" "===a[j-2].type?"*":""})).replace(P,"$1"),c,e>j&&ub(a.slice(j,e)),f>e&&ub(a=a.slice(e)),f>e&&pb(a))}m.push(c)}return rb(m)}function vb(a,b){var c=b.length>0,e=a.length>0,f=function(f,g,i,j,k){var m,n,o,p=0,q="0",r=f&&[],s=[],t=h,v=f||e&&d.find.TAG("*",k),w=u+=null==t?1:Math.random()||.1,x=v.length;for(k&&(h=g!==l&&g);q!==x&&null!=(m=v[q]);q++){if(e&&m){n=0;while(o=a[n++])if(o(m,g,i)){j.push(m);break}k&&(u=w)}c&&((m=!o&&m)&&p--,f&&r.push(m))}if(p+=q,c&&q!==p){n=0;while(o=b[n++])o(r,s,g,i);if(f){if(p>0)while(q--)r[q]||s[q]||(s[q]=E.call(j));s=sb(s)}G.apply(j,s),k&&!f&&s.length>0&&p+b.length>1&&db.uniqueSort(j)}return k&&(u=w,h=t),r};return c?fb(f):f}g=db.compile=function(a,b){var c,d=[],e=[],f=y[a+" "];if(!f){b||(b=ob(a)),c=b.length;while(c--)f=ub(b[c]),f[s]?d.push(f):e.push(f);f=y(a,vb(e,d))}return f};function wb(a,b,c){for(var d=0,e=b.length;e>d;d++)db(a,b[d],c);return c}function xb(a,b,e,f){var h,i,j,k,l,m=ob(a);if(!f&&1===m.length){if(i=m[0]=m[0].slice(0),i.length>2&&"ID"===(j=i[0]).type&&c.getById&&9===b.nodeType&&n&&d.relative[i[1].type]){if(b=(d.find.ID(j.matches[0].replace(ab,bb),b)||[])[0],!b)return e;a=a.slice(i.shift().value.length)}h=V.needsContext.test(a)?0:i.length;while(h--){if(j=i[h],d.relative[k=j.type])break;if((l=d.find[k])&&(f=l(j.matches[0].replace(ab,bb),$.test(i[0].type)&&mb(b.parentNode)||b))){if(i.splice(h,1),a=f.length&&pb(i),!a)return G.apply(e,f),e;break}}}return g(a,m)(f,b,!n,e,$.test(a)&&mb(b.parentNode)||b),e}return c.sortStable=s.split("").sort(z).join("")===s,c.detectDuplicates=!!j,k(),c.sortDetached=gb(function(a){return 1&a.compareDocumentPosition(l.createElement("div"))}),gb(function(a){return a.innerHTML="<a href='#'></a>","#"===a.firstChild.getAttribute("href")})||hb("type|href|height|width",function(a,b,c){return c?void 0:a.getAttribute(b,"type"===b.toLowerCase()?1:2)}),c.attributes&&gb(function(a){return a.innerHTML="<input/>",a.firstChild.setAttribute("value",""),""===a.firstChild.getAttribute("value")})||hb("value",function(a,b,c){return c||"input"!==a.nodeName.toLowerCase()?void 0:a.defaultValue}),gb(function(a){return null==a.getAttribute("disabled")})||hb(J,function(a,b,c){var d;return c?void 0:a[b]===!0?b.toLowerCase():(d=a.getAttributeNode(b))&&d.specified?d.value:null}),db}(a);n.find=t,n.expr=t.selectors,n.expr[":"]=n.expr.pseudos,n.unique=t.uniqueSort,n.text=t.getText,n.isXMLDoc=t.isXML,n.contains=t.contains;var u=n.expr.match.needsContext,v=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,w=/^.[^:#\[\.,]*$/;function x(a,b,c){if(n.isFunction(b))return n.grep(a,function(a,d){return!!b.call(a,d,a)!==c});if(b.nodeType)return n.grep(a,function(a){return a===b!==c});if("string"==typeof b){if(w.test(b))return n.filter(b,a,c);b=n.filter(b,a)}return n.grep(a,function(a){return n.inArray(a,b)>=0!==c})}n.filter=function(a,b,c){var d=b[0];return c&&(a=":not("+a+")"),1===b.length&&1===d.nodeType?n.find.matchesSelector(d,a)?[d]:[]:n.find.matches(a,n.grep(b,function(a){return 1===a.nodeType}))},n.fn.extend({find:function(a){var b,c=[],d=this,e=d.length;if("string"!=typeof a)return this.pushStack(n(a).filter(function(){for(b=0;e>b;b++)if(n.contains(d[b],this))return!0}));for(b=0;e>b;b++)n.find(a,d[b],c);return c=this.pushStack(e>1?n.unique(c):c),c.selector=this.selector?this.selector+" "+a:a,c},filter:function(a){return this.pushStack(x(this,a||[],!1))},not:function(a){return this.pushStack(x(this,a||[],!0))},is:function(a){return!!x(this,"string"==typeof a&&u.test(a)?n(a):a||[],!1).length}});var y,z=a.document,A=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,B=n.fn.init=function(a,b){var c,d;if(!a)return this;if("string"==typeof a){if(c="<"===a.charAt(0)&&">"===a.charAt(a.length-1)&&a.length>=3?[null,a,null]:A.exec(a),!c||!c[1]&&b)return!b||b.jquery?(b||y).find(a):this.constructor(b).find(a);if(c[1]){if(b=b instanceof n?b[0]:b,n.merge(this,n.parseHTML(c[1],b&&b.nodeType?b.ownerDocument||b:z,!0)),v.test(c[1])&&n.isPlainObject(b))for(c in b)n.isFunction(this[c])?this[c](b[c]):this.attr(c,b[c]);return this}if(d=z.getElementById(c[2]),d&&d.parentNode){if(d.id!==c[2])return y.find(a);this.length=1,this[0]=d}return this.context=z,this.selector=a,this}return a.nodeType?(this.context=this[0]=a,this.length=1,this):n.isFunction(a)?"undefined"!=typeof y.ready?y.ready(a):a(n):(void 0!==a.selector&&(this.selector=a.selector,this.context=a.context),n.makeArray(a,this))};B.prototype=n.fn,y=n(z);var C=/^(?:parents|prev(?:Until|All))/,D={children:!0,contents:!0,next:!0,prev:!0};n.extend({dir:function(a,b,c){var d=[],e=a[b];while(e&&9!==e.nodeType&&(void 0===c||1!==e.nodeType||!n(e).is(c)))1===e.nodeType&&d.push(e),e=e[b];return d},sibling:function(a,b){for(var c=[];a;a=a.nextSibling)1===a.nodeType&&a!==b&&c.push(a);return c}}),n.fn.extend({has:function(a){var b,c=n(a,this),d=c.length;return this.filter(function(){for(b=0;d>b;b++)if(n.contains(this,c[b]))return!0})},closest:function(a,b){for(var c,d=0,e=this.length,f=[],g=u.test(a)||"string"!=typeof a?n(a,b||this.context):0;e>d;d++)for(c=this[d];c&&c!==b;c=c.parentNode)if(c.nodeType<11&&(g?g.index(c)>-1:1===c.nodeType&&n.find.matchesSelector(c,a))){f.push(c);break}return this.pushStack(f.length>1?n.unique(f):f)},index:function(a){return a?"string"==typeof a?n.inArray(this[0],n(a)):n.inArray(a.jquery?a[0]:a,this):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(a,b){return this.pushStack(n.unique(n.merge(this.get(),n(a,b))))},addBack:function(a){return this.add(null==a?this.prevObject:this.prevObject.filter(a))}});function E(a,b){do a=a[b];while(a&&1!==a.nodeType);return a}n.each({parent:function(a){var b=a.parentNode;return b&&11!==b.nodeType?b:null},parents:function(a){return n.dir(a,"parentNode")},parentsUntil:function(a,b,c){return n.dir(a,"parentNode",c)},next:function(a){return E(a,"nextSibling")},prev:function(a){return E(a,"previousSibling")},nextAll:function(a){return n.dir(a,"nextSibling")},prevAll:function(a){return n.dir(a,"previousSibling")},nextUntil:function(a,b,c){return n.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return n.dir(a,"previousSibling",c)},siblings:function(a){return n.sibling((a.parentNode||{}).firstChild,a)},children:function(a){return n.sibling(a.firstChild)},contents:function(a){return n.nodeName(a,"iframe")?a.contentDocument||a.contentWindow.document:n.merge([],a.childNodes)}},function(a,b){n.fn[a]=function(c,d){var e=n.map(this,b,c);return"Until"!==a.slice(-5)&&(d=c),d&&"string"==typeof d&&(e=n.filter(d,e)),this.length>1&&(D[a]||(e=n.unique(e)),C.test(a)&&(e=e.reverse())),this.pushStack(e)}});var F=/\S+/g,G={};function H(a){var b=G[a]={};return n.each(a.match(F)||[],function(a,c){b[c]=!0}),b}n.Callbacks=function(a){a="string"==typeof a?G[a]||H(a):n.extend({},a);var b,c,d,e,f,g,h=[],i=!a.once&&[],j=function(l){for(c=a.memory&&l,d=!0,f=g||0,g=0,e=h.length,b=!0;h&&e>f;f++)if(h[f].apply(l[0],l[1])===!1&&a.stopOnFalse){c=!1;break}b=!1,h&&(i?i.length&&j(i.shift()):c?h=[]:k.disable())},k={add:function(){if(h){var d=h.length;!function f(b){n.each(b,function(b,c){var d=n.type(c);"function"===d?a.unique&&k.has(c)||h.push(c):c&&c.length&&"string"!==d&&f(c)})}(arguments),b?e=h.length:c&&(g=d,j(c))}return this},remove:function(){return h&&n.each(arguments,function(a,c){var d;while((d=n.inArray(c,h,d))>-1)h.splice(d,1),b&&(e>=d&&e--,f>=d&&f--)}),this},has:function(a){return a?n.inArray(a,h)>-1:!(!h||!h.length)},empty:function(){return h=[],e=0,this},disable:function(){return h=i=c=void 0,this},disabled:function(){return!h},lock:function(){return i=void 0,c||k.disable(),this},locked:function(){return!i},fireWith:function(a,c){return!h||d&&!i||(c=c||[],c=[a,c.slice?c.slice():c],b?i.push(c):j(c)),this},fire:function(){return k.fireWith(this,arguments),this},fired:function(){return!!d}};return k},n.extend({Deferred:function(a){var b=[["resolve","done",n.Callbacks("once memory"),"resolved"],["reject","fail",n.Callbacks("once memory"),"rejected"],["notify","progress",n.Callbacks("memory")]],c="pending",d={state:function(){return c},always:function(){return e.done(arguments).fail(arguments),this},then:function(){var a=arguments;return n.Deferred(function(c){n.each(b,function(b,f){var g=n.isFunction(a[b])&&a[b];e[f[1]](function(){var a=g&&g.apply(this,arguments);a&&n.isFunction(a.promise)?a.promise().done(c.resolve).fail(c.reject).progress(c.notify):c[f[0]+"With"](this===d?c.promise():this,g?[a]:arguments)})}),a=null}).promise()},promise:function(a){return null!=a?n.extend(a,d):d}},e={};return d.pipe=d.then,n.each(b,function(a,f){var g=f[2],h=f[3];d[f[1]]=g.add,h&&g.add(function(){c=h},b[1^a][2].disable,b[2][2].lock),e[f[0]]=function(){return e[f[0]+"With"](this===e?d:this,arguments),this},e[f[0]+"With"]=g.fireWith}),d.promise(e),a&&a.call(e,e),e},when:function(a){var b=0,c=d.call(arguments),e=c.length,f=1!==e||a&&n.isFunction(a.promise)?e:0,g=1===f?a:n.Deferred(),h=function(a,b,c){return function(e){b[a]=this,c[a]=arguments.length>1?d.call(arguments):e,c===i?g.notifyWith(b,c):--f||g.resolveWith(b,c)}},i,j,k;if(e>1)for(i=new Array(e),j=new Array(e),k=new Array(e);e>b;b++)c[b]&&n.isFunction(c[b].promise)?c[b].promise().done(h(b,k,c)).fail(g.reject).progress(h(b,j,i)):--f;return f||g.resolveWith(k,c),g.promise()}});var I;n.fn.ready=function(a){return n.ready.promise().done(a),this},n.extend({isReady:!1,readyWait:1,holdReady:function(a){a?n.readyWait++:n.ready(!0)},ready:function(a){if(a===!0?!--n.readyWait:!n.isReady){if(!z.body)return setTimeout(n.ready);n.isReady=!0,a!==!0&&--n.readyWait>0||(I.resolveWith(z,[n]),n.fn.trigger&&n(z).trigger("ready").off("ready"))}}});function J(){z.addEventListener?(z.removeEventListener("DOMContentLoaded",K,!1),a.removeEventListener("load",K,!1)):(z.detachEvent("onreadystatechange",K),a.detachEvent("onload",K))}function K(){(z.addEventListener||"load"===event.type||"complete"===z.readyState)&&(J(),n.ready())}n.ready.promise=function(b){if(!I)if(I=n.Deferred(),"complete"===z.readyState)setTimeout(n.ready);else if(z.addEventListener)z.addEventListener("DOMContentLoaded",K,!1),a.addEventListener("load",K,!1);else{z.attachEvent("onreadystatechange",K),a.attachEvent("onload",K);var c=!1;try{c=null==a.frameElement&&z.documentElement}catch(d){}c&&c.doScroll&&!function e(){if(!n.isReady){try{c.doScroll("left")}catch(a){return setTimeout(e,50)}J(),n.ready()}}()}return I.promise(b)};var L="undefined",M;for(M in n(l))break;l.ownLast="0"!==M,l.inlineBlockNeedsLayout=!1,n(function(){var a,b,c=z.getElementsByTagName("body")[0];c&&(a=z.createElement("div"),a.style.cssText="border:0;width:0;height:0;position:absolute;top:0;left:-9999px;margin-top:1px",b=z.createElement("div"),c.appendChild(a).appendChild(b),typeof b.style.zoom!==L&&(b.style.cssText="border:0;margin:0;width:1px;padding:1px;display:inline;zoom:1",(l.inlineBlockNeedsLayout=3===b.offsetWidth)&&(c.style.zoom=1)),c.removeChild(a),a=b=null)}),function(){var a=z.createElement("div");if(null==l.deleteExpando){l.deleteExpando=!0;try{delete a.test}catch(b){l.deleteExpando=!1}}a=null}(),n.acceptData=function(a){var b=n.noData[(a.nodeName+" ").toLowerCase()],c=+a.nodeType||1;return 1!==c&&9!==c?!1:!b||b!==!0&&a.getAttribute("classid")===b};var N=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,O=/([A-Z])/g;function P(a,b,c){if(void 0===c&&1===a.nodeType){var d="data-"+b.replace(O,"-$1").toLowerCase();if(c=a.getAttribute(d),"string"==typeof c){try{c="true"===c?!0:"false"===c?!1:"null"===c?null:+c+""===c?+c:N.test(c)?n.parseJSON(c):c}catch(e){}n.data(a,b,c)}else c=void 0}return c}function Q(a){var b;for(b in a)if(("data"!==b||!n.isEmptyObject(a[b]))&&"toJSON"!==b)return!1;return!0}function R(a,b,d,e){if(n.acceptData(a)){var f,g,h=n.expando,i=a.nodeType,j=i?n.cache:a,k=i?a[h]:a[h]&&h;if(k&&j[k]&&(e||j[k].data)||void 0!==d||"string"!=typeof b)return k||(k=i?a[h]=c.pop()||n.guid++:h),j[k]||(j[k]=i?{}:{toJSON:n.noop}),("object"==typeof b||"function"==typeof b)&&(e?j[k]=n.extend(j[k],b):j[k].data=n.extend(j[k].data,b)),g=j[k],e||(g.data||(g.data={}),g=g.data),void 0!==d&&(g[n.camelCase(b)]=d),"string"==typeof b?(f=g[b],null==f&&(f=g[n.camelCase(b)])):f=g,f
}}function S(a,b,c){if(n.acceptData(a)){var d,e,f=a.nodeType,g=f?n.cache:a,h=f?a[n.expando]:n.expando;if(g[h]){if(b&&(d=c?g[h]:g[h].data)){n.isArray(b)?b=b.concat(n.map(b,n.camelCase)):b in d?b=[b]:(b=n.camelCase(b),b=b in d?[b]:b.split(" ")),e=b.length;while(e--)delete d[b[e]];if(c?!Q(d):!n.isEmptyObject(d))return}(c||(delete g[h].data,Q(g[h])))&&(f?n.cleanData([a],!0):l.deleteExpando||g!=g.window?delete g[h]:g[h]=null)}}}n.extend({cache:{},noData:{"applet ":!0,"embed ":!0,"object ":"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"},hasData:function(a){return a=a.nodeType?n.cache[a[n.expando]]:a[n.expando],!!a&&!Q(a)},data:function(a,b,c){return R(a,b,c)},removeData:function(a,b){return S(a,b)},_data:function(a,b,c){return R(a,b,c,!0)},_removeData:function(a,b){return S(a,b,!0)}}),n.fn.extend({data:function(a,b){var c,d,e,f=this[0],g=f&&f.attributes;if(void 0===a){if(this.length&&(e=n.data(f),1===f.nodeType&&!n._data(f,"parsedAttrs"))){c=g.length;while(c--)d=g[c].name,0===d.indexOf("data-")&&(d=n.camelCase(d.slice(5)),P(f,d,e[d]));n._data(f,"parsedAttrs",!0)}return e}return"object"==typeof a?this.each(function(){n.data(this,a)}):arguments.length>1?this.each(function(){n.data(this,a,b)}):f?P(f,a,n.data(f,a)):void 0},removeData:function(a){return this.each(function(){n.removeData(this,a)})}}),n.extend({queue:function(a,b,c){var d;return a?(b=(b||"fx")+"queue",d=n._data(a,b),c&&(!d||n.isArray(c)?d=n._data(a,b,n.makeArray(c)):d.push(c)),d||[]):void 0},dequeue:function(a,b){b=b||"fx";var c=n.queue(a,b),d=c.length,e=c.shift(),f=n._queueHooks(a,b),g=function(){n.dequeue(a,b)};"inprogress"===e&&(e=c.shift(),d--),e&&("fx"===b&&c.unshift("inprogress"),delete f.stop,e.call(a,g,f)),!d&&f&&f.empty.fire()},_queueHooks:function(a,b){var c=b+"queueHooks";return n._data(a,c)||n._data(a,c,{empty:n.Callbacks("once memory").add(function(){n._removeData(a,b+"queue"),n._removeData(a,c)})})}}),n.fn.extend({queue:function(a,b){var c=2;return"string"!=typeof a&&(b=a,a="fx",c--),arguments.length<c?n.queue(this[0],a):void 0===b?this:this.each(function(){var c=n.queue(this,a,b);n._queueHooks(this,a),"fx"===a&&"inprogress"!==c[0]&&n.dequeue(this,a)})},dequeue:function(a){return this.each(function(){n.dequeue(this,a)})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,b){var c,d=1,e=n.Deferred(),f=this,g=this.length,h=function(){--d||e.resolveWith(f,[f])};"string"!=typeof a&&(b=a,a=void 0),a=a||"fx";while(g--)c=n._data(f[g],a+"queueHooks"),c&&c.empty&&(d++,c.empty.add(h));return h(),e.promise(b)}});var T=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,U=["Top","Right","Bottom","Left"],V=function(a,b){return a=b||a,"none"===n.css(a,"display")||!n.contains(a.ownerDocument,a)},W=n.access=function(a,b,c,d,e,f,g){var h=0,i=a.length,j=null==c;if("object"===n.type(c)){e=!0;for(h in c)n.access(a,b,h,c[h],!0,f,g)}else if(void 0!==d&&(e=!0,n.isFunction(d)||(g=!0),j&&(g?(b.call(a,d),b=null):(j=b,b=function(a,b,c){return j.call(n(a),c)})),b))for(;i>h;h++)b(a[h],c,g?d:d.call(a[h],h,b(a[h],c)));return e?a:j?b.call(a):i?b(a[0],c):f},X=/^(?:checkbox|radio)$/i;!function(){var a=z.createDocumentFragment(),b=z.createElement("div"),c=z.createElement("input");if(b.setAttribute("className","t"),b.innerHTML="  <link/><table></table><a href='/a'>a</a>",l.leadingWhitespace=3===b.firstChild.nodeType,l.tbody=!b.getElementsByTagName("tbody").length,l.htmlSerialize=!!b.getElementsByTagName("link").length,l.html5Clone="<:nav></:nav>"!==z.createElement("nav").cloneNode(!0).outerHTML,c.type="checkbox",c.checked=!0,a.appendChild(c),l.appendChecked=c.checked,b.innerHTML="<textarea>x</textarea>",l.noCloneChecked=!!b.cloneNode(!0).lastChild.defaultValue,a.appendChild(b),b.innerHTML="<input type='radio' checked='checked' name='t'/>",l.checkClone=b.cloneNode(!0).cloneNode(!0).lastChild.checked,l.noCloneEvent=!0,b.attachEvent&&(b.attachEvent("onclick",function(){l.noCloneEvent=!1}),b.cloneNode(!0).click()),null==l.deleteExpando){l.deleteExpando=!0;try{delete b.test}catch(d){l.deleteExpando=!1}}a=b=c=null}(),function(){var b,c,d=z.createElement("div");for(b in{submit:!0,change:!0,focusin:!0})c="on"+b,(l[b+"Bubbles"]=c in a)||(d.setAttribute(c,"t"),l[b+"Bubbles"]=d.attributes[c].expando===!1);d=null}();var Y=/^(?:input|select|textarea)$/i,Z=/^key/,$=/^(?:mouse|contextmenu)|click/,_=/^(?:focusinfocus|focusoutblur)$/,ab=/^([^.]*)(?:\.(.+)|)$/;function bb(){return!0}function cb(){return!1}function db(){try{return z.activeElement}catch(a){}}n.event={global:{},add:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=n._data(a);if(r){c.handler&&(i=c,c=i.handler,e=i.selector),c.guid||(c.guid=n.guid++),(g=r.events)||(g=r.events={}),(k=r.handle)||(k=r.handle=function(a){return typeof n===L||a&&n.event.triggered===a.type?void 0:n.event.dispatch.apply(k.elem,arguments)},k.elem=a),b=(b||"").match(F)||[""],h=b.length;while(h--)f=ab.exec(b[h])||[],o=q=f[1],p=(f[2]||"").split(".").sort(),o&&(j=n.event.special[o]||{},o=(e?j.delegateType:j.bindType)||o,j=n.event.special[o]||{},l=n.extend({type:o,origType:q,data:d,handler:c,guid:c.guid,selector:e,needsContext:e&&n.expr.match.needsContext.test(e),namespace:p.join(".")},i),(m=g[o])||(m=g[o]=[],m.delegateCount=0,j.setup&&j.setup.call(a,d,p,k)!==!1||(a.addEventListener?a.addEventListener(o,k,!1):a.attachEvent&&a.attachEvent("on"+o,k))),j.add&&(j.add.call(a,l),l.handler.guid||(l.handler.guid=c.guid)),e?m.splice(m.delegateCount++,0,l):m.push(l),n.event.global[o]=!0);a=null}},remove:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=n.hasData(a)&&n._data(a);if(r&&(k=r.events)){b=(b||"").match(F)||[""],j=b.length;while(j--)if(h=ab.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o){l=n.event.special[o]||{},o=(d?l.delegateType:l.bindType)||o,m=k[o]||[],h=h[2]&&new RegExp("(^|\\.)"+p.join("\\.(?:.*\\.|)")+"(\\.|$)"),i=f=m.length;while(f--)g=m[f],!e&&q!==g.origType||c&&c.guid!==g.guid||h&&!h.test(g.namespace)||d&&d!==g.selector&&("**"!==d||!g.selector)||(m.splice(f,1),g.selector&&m.delegateCount--,l.remove&&l.remove.call(a,g));i&&!m.length&&(l.teardown&&l.teardown.call(a,p,r.handle)!==!1||n.removeEvent(a,o,r.handle),delete k[o])}else for(o in k)n.event.remove(a,o+b[j],c,d,!0);n.isEmptyObject(k)&&(delete r.handle,n._removeData(a,"events"))}},trigger:function(b,c,d,e){var f,g,h,i,k,l,m,o=[d||z],p=j.call(b,"type")?b.type:b,q=j.call(b,"namespace")?b.namespace.split("."):[];if(h=l=d=d||z,3!==d.nodeType&&8!==d.nodeType&&!_.test(p+n.event.triggered)&&(p.indexOf(".")>=0&&(q=p.split("."),p=q.shift(),q.sort()),g=p.indexOf(":")<0&&"on"+p,b=b[n.expando]?b:new n.Event(p,"object"==typeof b&&b),b.isTrigger=e?2:3,b.namespace=q.join("."),b.namespace_re=b.namespace?new RegExp("(^|\\.)"+q.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,b.result=void 0,b.target||(b.target=d),c=null==c?[b]:n.makeArray(c,[b]),k=n.event.special[p]||{},e||!k.trigger||k.trigger.apply(d,c)!==!1)){if(!e&&!k.noBubble&&!n.isWindow(d)){for(i=k.delegateType||p,_.test(i+p)||(h=h.parentNode);h;h=h.parentNode)o.push(h),l=h;l===(d.ownerDocument||z)&&o.push(l.defaultView||l.parentWindow||a)}m=0;while((h=o[m++])&&!b.isPropagationStopped())b.type=m>1?i:k.bindType||p,f=(n._data(h,"events")||{})[b.type]&&n._data(h,"handle"),f&&f.apply(h,c),f=g&&h[g],f&&f.apply&&n.acceptData(h)&&(b.result=f.apply(h,c),b.result===!1&&b.preventDefault());if(b.type=p,!e&&!b.isDefaultPrevented()&&(!k._default||k._default.apply(o.pop(),c)===!1)&&n.acceptData(d)&&g&&d[p]&&!n.isWindow(d)){l=d[g],l&&(d[g]=null),n.event.triggered=p;try{d[p]()}catch(r){}n.event.triggered=void 0,l&&(d[g]=l)}return b.result}},dispatch:function(a){a=n.event.fix(a);var b,c,e,f,g,h=[],i=d.call(arguments),j=(n._data(this,"events")||{})[a.type]||[],k=n.event.special[a.type]||{};if(i[0]=a,a.delegateTarget=this,!k.preDispatch||k.preDispatch.call(this,a)!==!1){h=n.event.handlers.call(this,a,j),b=0;while((f=h[b++])&&!a.isPropagationStopped()){a.currentTarget=f.elem,g=0;while((e=f.handlers[g++])&&!a.isImmediatePropagationStopped())(!a.namespace_re||a.namespace_re.test(e.namespace))&&(a.handleObj=e,a.data=e.data,c=((n.event.special[e.origType]||{}).handle||e.handler).apply(f.elem,i),void 0!==c&&(a.result=c)===!1&&(a.preventDefault(),a.stopPropagation()))}return k.postDispatch&&k.postDispatch.call(this,a),a.result}},handlers:function(a,b){var c,d,e,f,g=[],h=b.delegateCount,i=a.target;if(h&&i.nodeType&&(!a.button||"click"!==a.type))for(;i!=this;i=i.parentNode||this)if(1===i.nodeType&&(i.disabled!==!0||"click"!==a.type)){for(e=[],f=0;h>f;f++)d=b[f],c=d.selector+" ",void 0===e[c]&&(e[c]=d.needsContext?n(c,this).index(i)>=0:n.find(c,this,null,[i]).length),e[c]&&e.push(d);e.length&&g.push({elem:i,handlers:e})}return h<b.length&&g.push({elem:this,handlers:b.slice(h)}),g},fix:function(a){if(a[n.expando])return a;var b,c,d,e=a.type,f=a,g=this.fixHooks[e];g||(this.fixHooks[e]=g=$.test(e)?this.mouseHooks:Z.test(e)?this.keyHooks:{}),d=g.props?this.props.concat(g.props):this.props,a=new n.Event(f),b=d.length;while(b--)c=d[b],a[c]=f[c];return a.target||(a.target=f.srcElement||z),3===a.target.nodeType&&(a.target=a.target.parentNode),a.metaKey=!!a.metaKey,g.filter?g.filter(a,f):a},props:"altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(a,b){return null==a.which&&(a.which=null!=b.charCode?b.charCode:b.keyCode),a}},mouseHooks:{props:"button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(a,b){var c,d,e,f=b.button,g=b.fromElement;return null==a.pageX&&null!=b.clientX&&(d=a.target.ownerDocument||z,e=d.documentElement,c=d.body,a.pageX=b.clientX+(e&&e.scrollLeft||c&&c.scrollLeft||0)-(e&&e.clientLeft||c&&c.clientLeft||0),a.pageY=b.clientY+(e&&e.scrollTop||c&&c.scrollTop||0)-(e&&e.clientTop||c&&c.clientTop||0)),!a.relatedTarget&&g&&(a.relatedTarget=g===a.target?b.toElement:g),a.which||void 0===f||(a.which=1&f?1:2&f?3:4&f?2:0),a}},special:{load:{noBubble:!0},focus:{trigger:function(){if(this!==db()&&this.focus)try{return this.focus(),!1}catch(a){}},delegateType:"focusin"},blur:{trigger:function(){return this===db()&&this.blur?(this.blur(),!1):void 0},delegateType:"focusout"},click:{trigger:function(){return n.nodeName(this,"input")&&"checkbox"===this.type&&this.click?(this.click(),!1):void 0},_default:function(a){return n.nodeName(a.target,"a")}},beforeunload:{postDispatch:function(a){void 0!==a.result&&(a.originalEvent.returnValue=a.result)}}},simulate:function(a,b,c,d){var e=n.extend(new n.Event,c,{type:a,isSimulated:!0,originalEvent:{}});d?n.event.trigger(e,null,b):n.event.dispatch.call(b,e),e.isDefaultPrevented()&&c.preventDefault()}},n.removeEvent=z.removeEventListener?function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)}:function(a,b,c){var d="on"+b;a.detachEvent&&(typeof a[d]===L&&(a[d]=null),a.detachEvent(d,c))},n.Event=function(a,b){return this instanceof n.Event?(a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||void 0===a.defaultPrevented&&(a.returnValue===!1||a.getPreventDefault&&a.getPreventDefault())?bb:cb):this.type=a,b&&n.extend(this,b),this.timeStamp=a&&a.timeStamp||n.now(),void(this[n.expando]=!0)):new n.Event(a,b)},n.Event.prototype={isDefaultPrevented:cb,isPropagationStopped:cb,isImmediatePropagationStopped:cb,preventDefault:function(){var a=this.originalEvent;this.isDefaultPrevented=bb,a&&(a.preventDefault?a.preventDefault():a.returnValue=!1)},stopPropagation:function(){var a=this.originalEvent;this.isPropagationStopped=bb,a&&(a.stopPropagation&&a.stopPropagation(),a.cancelBubble=!0)},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=bb,this.stopPropagation()}},n.each({mouseenter:"mouseover",mouseleave:"mouseout"},function(a,b){n.event.special[a]={delegateType:b,bindType:b,handle:function(a){var c,d=this,e=a.relatedTarget,f=a.handleObj;return(!e||e!==d&&!n.contains(d,e))&&(a.type=f.origType,c=f.handler.apply(this,arguments),a.type=b),c}}}),l.submitBubbles||(n.event.special.submit={setup:function(){return n.nodeName(this,"form")?!1:void n.event.add(this,"click._submit keypress._submit",function(a){var b=a.target,c=n.nodeName(b,"input")||n.nodeName(b,"button")?b.form:void 0;c&&!n._data(c,"submitBubbles")&&(n.event.add(c,"submit._submit",function(a){a._submit_bubble=!0}),n._data(c,"submitBubbles",!0))})},postDispatch:function(a){a._submit_bubble&&(delete a._submit_bubble,this.parentNode&&!a.isTrigger&&n.event.simulate("submit",this.parentNode,a,!0))},teardown:function(){return n.nodeName(this,"form")?!1:void n.event.remove(this,"._submit")}}),l.changeBubbles||(n.event.special.change={setup:function(){return Y.test(this.nodeName)?(("checkbox"===this.type||"radio"===this.type)&&(n.event.add(this,"propertychange._change",function(a){"checked"===a.originalEvent.propertyName&&(this._just_changed=!0)}),n.event.add(this,"click._change",function(a){this._just_changed&&!a.isTrigger&&(this._just_changed=!1),n.event.simulate("change",this,a,!0)})),!1):void n.event.add(this,"beforeactivate._change",function(a){var b=a.target;Y.test(b.nodeName)&&!n._data(b,"changeBubbles")&&(n.event.add(b,"change._change",function(a){!this.parentNode||a.isSimulated||a.isTrigger||n.event.simulate("change",this.parentNode,a,!0)}),n._data(b,"changeBubbles",!0))})},handle:function(a){var b=a.target;return this!==b||a.isSimulated||a.isTrigger||"radio"!==b.type&&"checkbox"!==b.type?a.handleObj.handler.apply(this,arguments):void 0},teardown:function(){return n.event.remove(this,"._change"),!Y.test(this.nodeName)}}),l.focusinBubbles||n.each({focus:"focusin",blur:"focusout"},function(a,b){var c=function(a){n.event.simulate(b,a.target,n.event.fix(a),!0)};n.event.special[b]={setup:function(){var d=this.ownerDocument||this,e=n._data(d,b);e||d.addEventListener(a,c,!0),n._data(d,b,(e||0)+1)},teardown:function(){var d=this.ownerDocument||this,e=n._data(d,b)-1;e?n._data(d,b,e):(d.removeEventListener(a,c,!0),n._removeData(d,b))}}}),n.fn.extend({on:function(a,b,c,d,e){var f,g;if("object"==typeof a){"string"!=typeof b&&(c=c||b,b=void 0);for(f in a)this.on(f,b,c,a[f],e);return this}if(null==c&&null==d?(d=b,c=b=void 0):null==d&&("string"==typeof b?(d=c,c=void 0):(d=c,c=b,b=void 0)),d===!1)d=cb;else if(!d)return this;return 1===e&&(g=d,d=function(a){return n().off(a),g.apply(this,arguments)},d.guid=g.guid||(g.guid=n.guid++)),this.each(function(){n.event.add(this,a,d,c,b)})},one:function(a,b,c,d){return this.on(a,b,c,d,1)},off:function(a,b,c){var d,e;if(a&&a.preventDefault&&a.handleObj)return d=a.handleObj,n(a.delegateTarget).off(d.namespace?d.origType+"."+d.namespace:d.origType,d.selector,d.handler),this;if("object"==typeof a){for(e in a)this.off(e,b,a[e]);return this}return(b===!1||"function"==typeof b)&&(c=b,b=void 0),c===!1&&(c=cb),this.each(function(){n.event.remove(this,a,c,b)})},trigger:function(a,b){return this.each(function(){n.event.trigger(a,b,this)})},triggerHandler:function(a,b){var c=this[0];return c?n.event.trigger(a,b,c,!0):void 0}});function eb(a){var b=fb.split("|"),c=a.createDocumentFragment();if(c.createElement)while(b.length)c.createElement(b.pop());return c}var fb="abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",gb=/ jQuery\d+="(?:null|\d+)"/g,hb=new RegExp("<(?:"+fb+")[\\s/>]","i"),ib=/^\s+/,jb=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,kb=/<([\w:]+)/,lb=/<tbody/i,mb=/<|&#?\w+;/,nb=/<(?:script|style|link)/i,ob=/checked\s*(?:[^=]|=\s*.checked.)/i,pb=/^$|\/(?:java|ecma)script/i,qb=/^true\/(.*)/,rb=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,sb={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],area:[1,"<map>","</map>"],param:[1,"<object>","</object>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:l.htmlSerialize?[0,"",""]:[1,"X<div>","</div>"]},tb=eb(z),ub=tb.appendChild(z.createElement("div"));sb.optgroup=sb.option,sb.tbody=sb.tfoot=sb.colgroup=sb.caption=sb.thead,sb.th=sb.td;function vb(a,b){var c,d,e=0,f=typeof a.getElementsByTagName!==L?a.getElementsByTagName(b||"*"):typeof a.querySelectorAll!==L?a.querySelectorAll(b||"*"):void 0;if(!f)for(f=[],c=a.childNodes||a;null!=(d=c[e]);e++)!b||n.nodeName(d,b)?f.push(d):n.merge(f,vb(d,b));return void 0===b||b&&n.nodeName(a,b)?n.merge([a],f):f}function wb(a){X.test(a.type)&&(a.defaultChecked=a.checked)}function xb(a,b){return n.nodeName(a,"table")&&n.nodeName(11!==b.nodeType?b:b.firstChild,"tr")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function yb(a){return a.type=(null!==n.find.attr(a,"type"))+"/"+a.type,a}function zb(a){var b=qb.exec(a.type);return b?a.type=b[1]:a.removeAttribute("type"),a}function Ab(a,b){for(var c,d=0;null!=(c=a[d]);d++)n._data(c,"globalEval",!b||n._data(b[d],"globalEval"))}function Bb(a,b){if(1===b.nodeType&&n.hasData(a)){var c,d,e,f=n._data(a),g=n._data(b,f),h=f.events;if(h){delete g.handle,g.events={};for(c in h)for(d=0,e=h[c].length;e>d;d++)n.event.add(b,c,h[c][d])}g.data&&(g.data=n.extend({},g.data))}}function Cb(a,b){var c,d,e;if(1===b.nodeType){if(c=b.nodeName.toLowerCase(),!l.noCloneEvent&&b[n.expando]){e=n._data(b);for(d in e.events)n.removeEvent(b,d,e.handle);b.removeAttribute(n.expando)}"script"===c&&b.text!==a.text?(yb(b).text=a.text,zb(b)):"object"===c?(b.parentNode&&(b.outerHTML=a.outerHTML),l.html5Clone&&a.innerHTML&&!n.trim(b.innerHTML)&&(b.innerHTML=a.innerHTML)):"input"===c&&X.test(a.type)?(b.defaultChecked=b.checked=a.checked,b.value!==a.value&&(b.value=a.value)):"option"===c?b.defaultSelected=b.selected=a.defaultSelected:("input"===c||"textarea"===c)&&(b.defaultValue=a.defaultValue)}}n.extend({clone:function(a,b,c){var d,e,f,g,h,i=n.contains(a.ownerDocument,a);if(l.html5Clone||n.isXMLDoc(a)||!hb.test("<"+a.nodeName+">")?f=a.cloneNode(!0):(ub.innerHTML=a.outerHTML,ub.removeChild(f=ub.firstChild)),!(l.noCloneEvent&&l.noCloneChecked||1!==a.nodeType&&11!==a.nodeType||n.isXMLDoc(a)))for(d=vb(f),h=vb(a),g=0;null!=(e=h[g]);++g)d[g]&&Cb(e,d[g]);if(b)if(c)for(h=h||vb(a),d=d||vb(f),g=0;null!=(e=h[g]);g++)Bb(e,d[g]);else Bb(a,f);return d=vb(f,"script"),d.length>0&&Ab(d,!i&&vb(a,"script")),d=h=e=null,f},buildFragment:function(a,b,c,d){for(var e,f,g,h,i,j,k,m=a.length,o=eb(b),p=[],q=0;m>q;q++)if(f=a[q],f||0===f)if("object"===n.type(f))n.merge(p,f.nodeType?[f]:f);else if(mb.test(f)){h=h||o.appendChild(b.createElement("div")),i=(kb.exec(f)||["",""])[1].toLowerCase(),k=sb[i]||sb._default,h.innerHTML=k[1]+f.replace(jb,"<$1></$2>")+k[2],e=k[0];while(e--)h=h.lastChild;if(!l.leadingWhitespace&&ib.test(f)&&p.push(b.createTextNode(ib.exec(f)[0])),!l.tbody){f="table"!==i||lb.test(f)?"<table>"!==k[1]||lb.test(f)?0:h:h.firstChild,e=f&&f.childNodes.length;while(e--)n.nodeName(j=f.childNodes[e],"tbody")&&!j.childNodes.length&&f.removeChild(j)}n.merge(p,h.childNodes),h.textContent="";while(h.firstChild)h.removeChild(h.firstChild);h=o.lastChild}else p.push(b.createTextNode(f));h&&o.removeChild(h),l.appendChecked||n.grep(vb(p,"input"),wb),q=0;while(f=p[q++])if((!d||-1===n.inArray(f,d))&&(g=n.contains(f.ownerDocument,f),h=vb(o.appendChild(f),"script"),g&&Ab(h),c)){e=0;while(f=h[e++])pb.test(f.type||"")&&c.push(f)}return h=null,o},cleanData:function(a,b){for(var d,e,f,g,h=0,i=n.expando,j=n.cache,k=l.deleteExpando,m=n.event.special;null!=(d=a[h]);h++)if((b||n.acceptData(d))&&(f=d[i],g=f&&j[f])){if(g.events)for(e in g.events)m[e]?n.event.remove(d,e):n.removeEvent(d,e,g.handle);j[f]&&(delete j[f],k?delete d[i]:typeof d.removeAttribute!==L?d.removeAttribute(i):d[i]=null,c.push(f))}}}),n.fn.extend({text:function(a){return W(this,function(a){return void 0===a?n.text(this):this.empty().append((this[0]&&this[0].ownerDocument||z).createTextNode(a))},null,a,arguments.length)},append:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=xb(this,a);b.appendChild(a)}})},prepend:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=xb(this,a);b.insertBefore(a,b.firstChild)}})},before:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this)})},after:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this.nextSibling)})},remove:function(a,b){for(var c,d=a?n.filter(a,this):this,e=0;null!=(c=d[e]);e++)b||1!==c.nodeType||n.cleanData(vb(c)),c.parentNode&&(b&&n.contains(c.ownerDocument,c)&&Ab(vb(c,"script")),c.parentNode.removeChild(c));return this},empty:function(){for(var a,b=0;null!=(a=this[b]);b++){1===a.nodeType&&n.cleanData(vb(a,!1));while(a.firstChild)a.removeChild(a.firstChild);a.options&&n.nodeName(a,"select")&&(a.options.length=0)}return this},clone:function(a,b){return a=null==a?!1:a,b=null==b?a:b,this.map(function(){return n.clone(this,a,b)})},html:function(a){return W(this,function(a){var b=this[0]||{},c=0,d=this.length;if(void 0===a)return 1===b.nodeType?b.innerHTML.replace(gb,""):void 0;if(!("string"!=typeof a||nb.test(a)||!l.htmlSerialize&&hb.test(a)||!l.leadingWhitespace&&ib.test(a)||sb[(kb.exec(a)||["",""])[1].toLowerCase()])){a=a.replace(jb,"<$1></$2>");try{for(;d>c;c++)b=this[c]||{},1===b.nodeType&&(n.cleanData(vb(b,!1)),b.innerHTML=a);b=0}catch(e){}}b&&this.empty().append(a)},null,a,arguments.length)},replaceWith:function(){var a=arguments[0];return this.domManip(arguments,function(b){a=this.parentNode,n.cleanData(vb(this)),a&&a.replaceChild(b,this)}),a&&(a.length||a.nodeType)?this:this.remove()},detach:function(a){return this.remove(a,!0)},domManip:function(a,b){a=e.apply([],a);var c,d,f,g,h,i,j=0,k=this.length,m=this,o=k-1,p=a[0],q=n.isFunction(p);if(q||k>1&&"string"==typeof p&&!l.checkClone&&ob.test(p))return this.each(function(c){var d=m.eq(c);q&&(a[0]=p.call(this,c,d.html())),d.domManip(a,b)});if(k&&(i=n.buildFragment(a,this[0].ownerDocument,!1,this),c=i.firstChild,1===i.childNodes.length&&(i=c),c)){for(g=n.map(vb(i,"script"),yb),f=g.length;k>j;j++)d=i,j!==o&&(d=n.clone(d,!0,!0),f&&n.merge(g,vb(d,"script"))),b.call(this[j],d,j);if(f)for(h=g[g.length-1].ownerDocument,n.map(g,zb),j=0;f>j;j++)d=g[j],pb.test(d.type||"")&&!n._data(d,"globalEval")&&n.contains(h,d)&&(d.src?n._evalUrl&&n._evalUrl(d.src):n.globalEval((d.text||d.textContent||d.innerHTML||"").replace(rb,"")));i=c=null}return this}}),n.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){n.fn[a]=function(a){for(var c,d=0,e=[],g=n(a),h=g.length-1;h>=d;d++)c=d===h?this:this.clone(!0),n(g[d])[b](c),f.apply(e,c.get());return this.pushStack(e)}});var Db,Eb={};function Fb(b,c){var d=n(c.createElement(b)).appendTo(c.body),e=a.getDefaultComputedStyle?a.getDefaultComputedStyle(d[0]).display:n.css(d[0],"display");return d.detach(),e}function Gb(a){var b=z,c=Eb[a];return c||(c=Fb(a,b),"none"!==c&&c||(Db=(Db||n("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement),b=(Db[0].contentWindow||Db[0].contentDocument).document,b.write(),b.close(),c=Fb(a,b),Db.detach()),Eb[a]=c),c}!function(){var a,b,c=z.createElement("div"),d="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;padding:0;margin:0;border:0";c.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",a=c.getElementsByTagName("a")[0],a.style.cssText="float:left;opacity:.5",l.opacity=/^0.5/.test(a.style.opacity),l.cssFloat=!!a.style.cssFloat,c.style.backgroundClip="content-box",c.cloneNode(!0).style.backgroundClip="",l.clearCloneStyle="content-box"===c.style.backgroundClip,a=c=null,l.shrinkWrapBlocks=function(){var a,c,e,f;if(null==b){if(a=z.getElementsByTagName("body")[0],!a)return;f="border:0;width:0;height:0;position:absolute;top:0;left:-9999px",c=z.createElement("div"),e=z.createElement("div"),a.appendChild(c).appendChild(e),b=!1,typeof e.style.zoom!==L&&(e.style.cssText=d+";width:1px;padding:1px;zoom:1",e.innerHTML="<div></div>",e.firstChild.style.width="5px",b=3!==e.offsetWidth),a.removeChild(c),a=c=e=null}return b}}();var Hb=/^margin/,Ib=new RegExp("^("+T+")(?!px)[a-z%]+$","i"),Jb,Kb,Lb=/^(top|right|bottom|left)$/;a.getComputedStyle?(Jb=function(a){return a.ownerDocument.defaultView.getComputedStyle(a,null)},Kb=function(a,b,c){var d,e,f,g,h=a.style;return c=c||Jb(a),g=c?c.getPropertyValue(b)||c[b]:void 0,c&&(""!==g||n.contains(a.ownerDocument,a)||(g=n.style(a,b)),Ib.test(g)&&Hb.test(b)&&(d=h.width,e=h.minWidth,f=h.maxWidth,h.minWidth=h.maxWidth=h.width=g,g=c.width,h.width=d,h.minWidth=e,h.maxWidth=f)),void 0===g?g:g+""}):z.documentElement.currentStyle&&(Jb=function(a){return a.currentStyle},Kb=function(a,b,c){var d,e,f,g,h=a.style;return c=c||Jb(a),g=c?c[b]:void 0,null==g&&h&&h[b]&&(g=h[b]),Ib.test(g)&&!Lb.test(b)&&(d=h.left,e=a.runtimeStyle,f=e&&e.left,f&&(e.left=a.currentStyle.left),h.left="fontSize"===b?"1em":g,g=h.pixelLeft+"px",h.left=d,f&&(e.left=f)),void 0===g?g:g+""||"auto"});function Mb(a,b){return{get:function(){var c=a();if(null!=c)return c?void delete this.get:(this.get=b).apply(this,arguments)}}}!function(){var b,c,d,e,f,g,h=z.createElement("div"),i="border:0;width:0;height:0;position:absolute;top:0;left:-9999px",j="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;padding:0;margin:0;border:0";h.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",b=h.getElementsByTagName("a")[0],b.style.cssText="float:left;opacity:.5",l.opacity=/^0.5/.test(b.style.opacity),l.cssFloat=!!b.style.cssFloat,h.style.backgroundClip="content-box",h.cloneNode(!0).style.backgroundClip="",l.clearCloneStyle="content-box"===h.style.backgroundClip,b=h=null,n.extend(l,{reliableHiddenOffsets:function(){if(null!=c)return c;var a,b,d,e=z.createElement("div"),f=z.getElementsByTagName("body")[0];if(f)return e.setAttribute("className","t"),e.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",a=z.createElement("div"),a.style.cssText=i,f.appendChild(a).appendChild(e),e.innerHTML="<table><tr><td></td><td>t</td></tr></table>",b=e.getElementsByTagName("td"),b[0].style.cssText="padding:0;margin:0;border:0;display:none",d=0===b[0].offsetHeight,b[0].style.display="",b[1].style.display="none",c=d&&0===b[0].offsetHeight,f.removeChild(a),e=f=null,c},boxSizing:function(){return null==d&&k(),d},boxSizingReliable:function(){return null==e&&k(),e},pixelPosition:function(){return null==f&&k(),f},reliableMarginRight:function(){var b,c,d,e;if(null==g&&a.getComputedStyle){if(b=z.getElementsByTagName("body")[0],!b)return;c=z.createElement("div"),d=z.createElement("div"),c.style.cssText=i,b.appendChild(c).appendChild(d),e=d.appendChild(z.createElement("div")),e.style.cssText=d.style.cssText=j,e.style.marginRight=e.style.width="0",d.style.width="1px",g=!parseFloat((a.getComputedStyle(e,null)||{}).marginRight),b.removeChild(c)}return g}});function k(){var b,c,h=z.getElementsByTagName("body")[0];h&&(b=z.createElement("div"),c=z.createElement("div"),b.style.cssText=i,h.appendChild(b).appendChild(c),c.style.cssText="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;display:block;padding:1px;border:1px;width:4px;margin-top:1%;top:1%",n.swap(h,null!=h.style.zoom?{zoom:1}:{},function(){d=4===c.offsetWidth}),e=!0,f=!1,g=!0,a.getComputedStyle&&(f="1%"!==(a.getComputedStyle(c,null)||{}).top,e="4px"===(a.getComputedStyle(c,null)||{width:"4px"}).width),h.removeChild(b),c=h=null)}}(),n.swap=function(a,b,c,d){var e,f,g={};for(f in b)g[f]=a.style[f],a.style[f]=b[f];e=c.apply(a,d||[]);for(f in b)a.style[f]=g[f];return e};var Nb=/alpha\([^)]*\)/i,Ob=/opacity\s*=\s*([^)]*)/,Pb=/^(none|table(?!-c[ea]).+)/,Qb=new RegExp("^("+T+")(.*)$","i"),Rb=new RegExp("^([+-])=("+T+")","i"),Sb={position:"absolute",visibility:"hidden",display:"block"},Tb={letterSpacing:0,fontWeight:400},Ub=["Webkit","O","Moz","ms"];function Vb(a,b){if(b in a)return b;var c=b.charAt(0).toUpperCase()+b.slice(1),d=b,e=Ub.length;while(e--)if(b=Ub[e]+c,b in a)return b;return d}function Wb(a,b){for(var c,d,e,f=[],g=0,h=a.length;h>g;g++)d=a[g],d.style&&(f[g]=n._data(d,"olddisplay"),c=d.style.display,b?(f[g]||"none"!==c||(d.style.display=""),""===d.style.display&&V(d)&&(f[g]=n._data(d,"olddisplay",Gb(d.nodeName)))):f[g]||(e=V(d),(c&&"none"!==c||!e)&&n._data(d,"olddisplay",e?c:n.css(d,"display"))));for(g=0;h>g;g++)d=a[g],d.style&&(b&&"none"!==d.style.display&&""!==d.style.display||(d.style.display=b?f[g]||"":"none"));return a}function Xb(a,b,c){var d=Qb.exec(b);return d?Math.max(0,d[1]-(c||0))+(d[2]||"px"):b}function Yb(a,b,c,d,e){for(var f=c===(d?"border":"content")?4:"width"===b?1:0,g=0;4>f;f+=2)"margin"===c&&(g+=n.css(a,c+U[f],!0,e)),d?("content"===c&&(g-=n.css(a,"padding"+U[f],!0,e)),"margin"!==c&&(g-=n.css(a,"border"+U[f]+"Width",!0,e))):(g+=n.css(a,"padding"+U[f],!0,e),"padding"!==c&&(g+=n.css(a,"border"+U[f]+"Width",!0,e)));return g}function Zb(a,b,c){var d=!0,e="width"===b?a.offsetWidth:a.offsetHeight,f=Jb(a),g=l.boxSizing()&&"border-box"===n.css(a,"boxSizing",!1,f);if(0>=e||null==e){if(e=Kb(a,b,f),(0>e||null==e)&&(e=a.style[b]),Ib.test(e))return e;d=g&&(l.boxSizingReliable()||e===a.style[b]),e=parseFloat(e)||0}return e+Yb(a,b,c||(g?"border":"content"),d,f)+"px"}n.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=Kb(a,"opacity");return""===c?"1":c}}}},cssNumber:{columnCount:!0,fillOpacity:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":l.cssFloat?"cssFloat":"styleFloat"},style:function(a,b,c,d){if(a&&3!==a.nodeType&&8!==a.nodeType&&a.style){var e,f,g,h=n.camelCase(b),i=a.style;if(b=n.cssProps[h]||(n.cssProps[h]=Vb(i,h)),g=n.cssHooks[b]||n.cssHooks[h],void 0===c)return g&&"get"in g&&void 0!==(e=g.get(a,!1,d))?e:i[b];if(f=typeof c,"string"===f&&(e=Rb.exec(c))&&(c=(e[1]+1)*e[2]+parseFloat(n.css(a,b)),f="number"),null!=c&&c===c&&("number"!==f||n.cssNumber[h]||(c+="px"),l.clearCloneStyle||""!==c||0!==b.indexOf("background")||(i[b]="inherit"),!(g&&"set"in g&&void 0===(c=g.set(a,c,d)))))try{i[b]="",i[b]=c}catch(j){}}},css:function(a,b,c,d){var e,f,g,h=n.camelCase(b);return b=n.cssProps[h]||(n.cssProps[h]=Vb(a.style,h)),g=n.cssHooks[b]||n.cssHooks[h],g&&"get"in g&&(f=g.get(a,!0,c)),void 0===f&&(f=Kb(a,b,d)),"normal"===f&&b in Tb&&(f=Tb[b]),""===c||c?(e=parseFloat(f),c===!0||n.isNumeric(e)?e||0:f):f}}),n.each(["height","width"],function(a,b){n.cssHooks[b]={get:function(a,c,d){return c?0===a.offsetWidth&&Pb.test(n.css(a,"display"))?n.swap(a,Sb,function(){return Zb(a,b,d)}):Zb(a,b,d):void 0},set:function(a,c,d){var e=d&&Jb(a);return Xb(a,c,d?Yb(a,b,d,l.boxSizing()&&"border-box"===n.css(a,"boxSizing",!1,e),e):0)}}}),l.opacity||(n.cssHooks.opacity={get:function(a,b){return Ob.test((b&&a.currentStyle?a.currentStyle.filter:a.style.filter)||"")?.01*parseFloat(RegExp.$1)+"":b?"1":""},set:function(a,b){var c=a.style,d=a.currentStyle,e=n.isNumeric(b)?"alpha(opacity="+100*b+")":"",f=d&&d.filter||c.filter||"";c.zoom=1,(b>=1||""===b)&&""===n.trim(f.replace(Nb,""))&&c.removeAttribute&&(c.removeAttribute("filter"),""===b||d&&!d.filter)||(c.filter=Nb.test(f)?f.replace(Nb,e):f+" "+e)}}),n.cssHooks.marginRight=Mb(l.reliableMarginRight,function(a,b){return b?n.swap(a,{display:"inline-block"},Kb,[a,"marginRight"]):void 0}),n.each({margin:"",padding:"",border:"Width"},function(a,b){n.cssHooks[a+b]={expand:function(c){for(var d=0,e={},f="string"==typeof c?c.split(" "):[c];4>d;d++)e[a+U[d]+b]=f[d]||f[d-2]||f[0];return e}},Hb.test(a)||(n.cssHooks[a+b].set=Xb)}),n.fn.extend({css:function(a,b){return W(this,function(a,b,c){var d,e,f={},g=0;if(n.isArray(b)){for(d=Jb(a),e=b.length;e>g;g++)f[b[g]]=n.css(a,b[g],!1,d);return f}return void 0!==c?n.style(a,b,c):n.css(a,b)
},a,b,arguments.length>1)},show:function(){return Wb(this,!0)},hide:function(){return Wb(this)},toggle:function(a){return"boolean"==typeof a?a?this.show():this.hide():this.each(function(){V(this)?n(this).show():n(this).hide()})}});function $b(a,b,c,d,e){return new $b.prototype.init(a,b,c,d,e)}n.Tween=$b,$b.prototype={constructor:$b,init:function(a,b,c,d,e,f){this.elem=a,this.prop=c,this.easing=e||"swing",this.options=b,this.start=this.now=this.cur(),this.end=d,this.unit=f||(n.cssNumber[c]?"":"px")},cur:function(){var a=$b.propHooks[this.prop];return a&&a.get?a.get(this):$b.propHooks._default.get(this)},run:function(a){var b,c=$b.propHooks[this.prop];return this.pos=b=this.options.duration?n.easing[this.easing](a,this.options.duration*a,0,1,this.options.duration):a,this.now=(this.end-this.start)*b+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),c&&c.set?c.set(this):$b.propHooks._default.set(this),this}},$b.prototype.init.prototype=$b.prototype,$b.propHooks={_default:{get:function(a){var b;return null==a.elem[a.prop]||a.elem.style&&null!=a.elem.style[a.prop]?(b=n.css(a.elem,a.prop,""),b&&"auto"!==b?b:0):a.elem[a.prop]},set:function(a){n.fx.step[a.prop]?n.fx.step[a.prop](a):a.elem.style&&(null!=a.elem.style[n.cssProps[a.prop]]||n.cssHooks[a.prop])?n.style(a.elem,a.prop,a.now+a.unit):a.elem[a.prop]=a.now}}},$b.propHooks.scrollTop=$b.propHooks.scrollLeft={set:function(a){a.elem.nodeType&&a.elem.parentNode&&(a.elem[a.prop]=a.now)}},n.easing={linear:function(a){return a},swing:function(a){return.5-Math.cos(a*Math.PI)/2}},n.fx=$b.prototype.init,n.fx.step={};var _b,ac,bc=/^(?:toggle|show|hide)$/,cc=new RegExp("^(?:([+-])=|)("+T+")([a-z%]*)$","i"),dc=/queueHooks$/,ec=[jc],fc={"*":[function(a,b){var c=this.createTween(a,b),d=c.cur(),e=cc.exec(b),f=e&&e[3]||(n.cssNumber[a]?"":"px"),g=(n.cssNumber[a]||"px"!==f&&+d)&&cc.exec(n.css(c.elem,a)),h=1,i=20;if(g&&g[3]!==f){f=f||g[3],e=e||[],g=+d||1;do h=h||".5",g/=h,n.style(c.elem,a,g+f);while(h!==(h=c.cur()/d)&&1!==h&&--i)}return e&&(g=c.start=+g||+d||0,c.unit=f,c.end=e[1]?g+(e[1]+1)*e[2]:+e[2]),c}]};function gc(){return setTimeout(function(){_b=void 0}),_b=n.now()}function hc(a,b){var c,d={height:a},e=0;for(b=b?1:0;4>e;e+=2-b)c=U[e],d["margin"+c]=d["padding"+c]=a;return b&&(d.opacity=d.width=a),d}function ic(a,b,c){for(var d,e=(fc[b]||[]).concat(fc["*"]),f=0,g=e.length;g>f;f++)if(d=e[f].call(c,b,a))return d}function jc(a,b,c){var d,e,f,g,h,i,j,k,m=this,o={},p=a.style,q=a.nodeType&&V(a),r=n._data(a,"fxshow");c.queue||(h=n._queueHooks(a,"fx"),null==h.unqueued&&(h.unqueued=0,i=h.empty.fire,h.empty.fire=function(){h.unqueued||i()}),h.unqueued++,m.always(function(){m.always(function(){h.unqueued--,n.queue(a,"fx").length||h.empty.fire()})})),1===a.nodeType&&("height"in b||"width"in b)&&(c.overflow=[p.overflow,p.overflowX,p.overflowY],j=n.css(a,"display"),k=Gb(a.nodeName),"none"===j&&(j=k),"inline"===j&&"none"===n.css(a,"float")&&(l.inlineBlockNeedsLayout&&"inline"!==k?p.zoom=1:p.display="inline-block")),c.overflow&&(p.overflow="hidden",l.shrinkWrapBlocks()||m.always(function(){p.overflow=c.overflow[0],p.overflowX=c.overflow[1],p.overflowY=c.overflow[2]}));for(d in b)if(e=b[d],bc.exec(e)){if(delete b[d],f=f||"toggle"===e,e===(q?"hide":"show")){if("show"!==e||!r||void 0===r[d])continue;q=!0}o[d]=r&&r[d]||n.style(a,d)}if(!n.isEmptyObject(o)){r?"hidden"in r&&(q=r.hidden):r=n._data(a,"fxshow",{}),f&&(r.hidden=!q),q?n(a).show():m.done(function(){n(a).hide()}),m.done(function(){var b;n._removeData(a,"fxshow");for(b in o)n.style(a,b,o[b])});for(d in o)g=ic(q?r[d]:0,d,m),d in r||(r[d]=g.start,q&&(g.end=g.start,g.start="width"===d||"height"===d?1:0))}}function kc(a,b){var c,d,e,f,g;for(c in a)if(d=n.camelCase(c),e=b[d],f=a[c],n.isArray(f)&&(e=f[1],f=a[c]=f[0]),c!==d&&(a[d]=f,delete a[c]),g=n.cssHooks[d],g&&"expand"in g){f=g.expand(f),delete a[d];for(c in f)c in a||(a[c]=f[c],b[c]=e)}else b[d]=e}function lc(a,b,c){var d,e,f=0,g=ec.length,h=n.Deferred().always(function(){delete i.elem}),i=function(){if(e)return!1;for(var b=_b||gc(),c=Math.max(0,j.startTime+j.duration-b),d=c/j.duration||0,f=1-d,g=0,i=j.tweens.length;i>g;g++)j.tweens[g].run(f);return h.notifyWith(a,[j,f,c]),1>f&&i?c:(h.resolveWith(a,[j]),!1)},j=h.promise({elem:a,props:n.extend({},b),opts:n.extend(!0,{specialEasing:{}},c),originalProperties:b,originalOptions:c,startTime:_b||gc(),duration:c.duration,tweens:[],createTween:function(b,c){var d=n.Tween(a,j.opts,b,c,j.opts.specialEasing[b]||j.opts.easing);return j.tweens.push(d),d},stop:function(b){var c=0,d=b?j.tweens.length:0;if(e)return this;for(e=!0;d>c;c++)j.tweens[c].run(1);return b?h.resolveWith(a,[j,b]):h.rejectWith(a,[j,b]),this}}),k=j.props;for(kc(k,j.opts.specialEasing);g>f;f++)if(d=ec[f].call(j,a,k,j.opts))return d;return n.map(k,ic,j),n.isFunction(j.opts.start)&&j.opts.start.call(a,j),n.fx.timer(n.extend(i,{elem:a,anim:j,queue:j.opts.queue})),j.progress(j.opts.progress).done(j.opts.done,j.opts.complete).fail(j.opts.fail).always(j.opts.always)}n.Animation=n.extend(lc,{tweener:function(a,b){n.isFunction(a)?(b=a,a=["*"]):a=a.split(" ");for(var c,d=0,e=a.length;e>d;d++)c=a[d],fc[c]=fc[c]||[],fc[c].unshift(b)},prefilter:function(a,b){b?ec.unshift(a):ec.push(a)}}),n.speed=function(a,b,c){var d=a&&"object"==typeof a?n.extend({},a):{complete:c||!c&&b||n.isFunction(a)&&a,duration:a,easing:c&&b||b&&!n.isFunction(b)&&b};return d.duration=n.fx.off?0:"number"==typeof d.duration?d.duration:d.duration in n.fx.speeds?n.fx.speeds[d.duration]:n.fx.speeds._default,(null==d.queue||d.queue===!0)&&(d.queue="fx"),d.old=d.complete,d.complete=function(){n.isFunction(d.old)&&d.old.call(this),d.queue&&n.dequeue(this,d.queue)},d},n.fn.extend({fadeTo:function(a,b,c,d){return this.filter(V).css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){var e=n.isEmptyObject(a),f=n.speed(b,c,d),g=function(){var b=lc(this,n.extend({},a),f);(e||n._data(this,"finish"))&&b.stop(!0)};return g.finish=g,e||f.queue===!1?this.each(g):this.queue(f.queue,g)},stop:function(a,b,c){var d=function(a){var b=a.stop;delete a.stop,b(c)};return"string"!=typeof a&&(c=b,b=a,a=void 0),b&&a!==!1&&this.queue(a||"fx",[]),this.each(function(){var b=!0,e=null!=a&&a+"queueHooks",f=n.timers,g=n._data(this);if(e)g[e]&&g[e].stop&&d(g[e]);else for(e in g)g[e]&&g[e].stop&&dc.test(e)&&d(g[e]);for(e=f.length;e--;)f[e].elem!==this||null!=a&&f[e].queue!==a||(f[e].anim.stop(c),b=!1,f.splice(e,1));(b||!c)&&n.dequeue(this,a)})},finish:function(a){return a!==!1&&(a=a||"fx"),this.each(function(){var b,c=n._data(this),d=c[a+"queue"],e=c[a+"queueHooks"],f=n.timers,g=d?d.length:0;for(c.finish=!0,n.queue(this,a,[]),e&&e.stop&&e.stop.call(this,!0),b=f.length;b--;)f[b].elem===this&&f[b].queue===a&&(f[b].anim.stop(!0),f.splice(b,1));for(b=0;g>b;b++)d[b]&&d[b].finish&&d[b].finish.call(this);delete c.finish})}}),n.each(["toggle","show","hide"],function(a,b){var c=n.fn[b];n.fn[b]=function(a,d,e){return null==a||"boolean"==typeof a?c.apply(this,arguments):this.animate(hc(b,!0),a,d,e)}}),n.each({slideDown:hc("show"),slideUp:hc("hide"),slideToggle:hc("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){n.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),n.timers=[],n.fx.tick=function(){var a,b=n.timers,c=0;for(_b=n.now();c<b.length;c++)a=b[c],a()||b[c]!==a||b.splice(c--,1);b.length||n.fx.stop(),_b=void 0},n.fx.timer=function(a){n.timers.push(a),a()?n.fx.start():n.timers.pop()},n.fx.interval=13,n.fx.start=function(){ac||(ac=setInterval(n.fx.tick,n.fx.interval))},n.fx.stop=function(){clearInterval(ac),ac=null},n.fx.speeds={slow:600,fast:200,_default:400},n.fn.delay=function(a,b){return a=n.fx?n.fx.speeds[a]||a:a,b=b||"fx",this.queue(b,function(b,c){var d=setTimeout(b,a);c.stop=function(){clearTimeout(d)}})},function(){var a,b,c,d,e=z.createElement("div");e.setAttribute("className","t"),e.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",a=e.getElementsByTagName("a")[0],c=z.createElement("select"),d=c.appendChild(z.createElement("option")),b=e.getElementsByTagName("input")[0],a.style.cssText="top:1px",l.getSetAttribute="t"!==e.className,l.style=/top/.test(a.getAttribute("style")),l.hrefNormalized="/a"===a.getAttribute("href"),l.checkOn=!!b.value,l.optSelected=d.selected,l.enctype=!!z.createElement("form").enctype,c.disabled=!0,l.optDisabled=!d.disabled,b=z.createElement("input"),b.setAttribute("value",""),l.input=""===b.getAttribute("value"),b.value="t",b.setAttribute("type","radio"),l.radioValue="t"===b.value,a=b=c=d=e=null}();var mc=/\r/g;n.fn.extend({val:function(a){var b,c,d,e=this[0];{if(arguments.length)return d=n.isFunction(a),this.each(function(c){var e;1===this.nodeType&&(e=d?a.call(this,c,n(this).val()):a,null==e?e="":"number"==typeof e?e+="":n.isArray(e)&&(e=n.map(e,function(a){return null==a?"":a+""})),b=n.valHooks[this.type]||n.valHooks[this.nodeName.toLowerCase()],b&&"set"in b&&void 0!==b.set(this,e,"value")||(this.value=e))});if(e)return b=n.valHooks[e.type]||n.valHooks[e.nodeName.toLowerCase()],b&&"get"in b&&void 0!==(c=b.get(e,"value"))?c:(c=e.value,"string"==typeof c?c.replace(mc,""):null==c?"":c)}}}),n.extend({valHooks:{option:{get:function(a){var b=n.find.attr(a,"value");return null!=b?b:n.text(a)}},select:{get:function(a){for(var b,c,d=a.options,e=a.selectedIndex,f="select-one"===a.type||0>e,g=f?null:[],h=f?e+1:d.length,i=0>e?h:f?e:0;h>i;i++)if(c=d[i],!(!c.selected&&i!==e||(l.optDisabled?c.disabled:null!==c.getAttribute("disabled"))||c.parentNode.disabled&&n.nodeName(c.parentNode,"optgroup"))){if(b=n(c).val(),f)return b;g.push(b)}return g},set:function(a,b){var c,d,e=a.options,f=n.makeArray(b),g=e.length;while(g--)if(d=e[g],n.inArray(n.valHooks.option.get(d),f)>=0)try{d.selected=c=!0}catch(h){d.scrollHeight}else d.selected=!1;return c||(a.selectedIndex=-1),e}}}}),n.each(["radio","checkbox"],function(){n.valHooks[this]={set:function(a,b){return n.isArray(b)?a.checked=n.inArray(n(a).val(),b)>=0:void 0}},l.checkOn||(n.valHooks[this].get=function(a){return null===a.getAttribute("value")?"on":a.value})});var nc,oc,pc=n.expr.attrHandle,qc=/^(?:checked|selected)$/i,rc=l.getSetAttribute,sc=l.input;n.fn.extend({attr:function(a,b){return W(this,n.attr,a,b,arguments.length>1)},removeAttr:function(a){return this.each(function(){n.removeAttr(this,a)})}}),n.extend({attr:function(a,b,c){var d,e,f=a.nodeType;if(a&&3!==f&&8!==f&&2!==f)return typeof a.getAttribute===L?n.prop(a,b,c):(1===f&&n.isXMLDoc(a)||(b=b.toLowerCase(),d=n.attrHooks[b]||(n.expr.match.bool.test(b)?oc:nc)),void 0===c?d&&"get"in d&&null!==(e=d.get(a,b))?e:(e=n.find.attr(a,b),null==e?void 0:e):null!==c?d&&"set"in d&&void 0!==(e=d.set(a,c,b))?e:(a.setAttribute(b,c+""),c):void n.removeAttr(a,b))},removeAttr:function(a,b){var c,d,e=0,f=b&&b.match(F);if(f&&1===a.nodeType)while(c=f[e++])d=n.propFix[c]||c,n.expr.match.bool.test(c)?sc&&rc||!qc.test(c)?a[d]=!1:a[n.camelCase("default-"+c)]=a[d]=!1:n.attr(a,c,""),a.removeAttribute(rc?c:d)},attrHooks:{type:{set:function(a,b){if(!l.radioValue&&"radio"===b&&n.nodeName(a,"input")){var c=a.value;return a.setAttribute("type",b),c&&(a.value=c),b}}}}}),oc={set:function(a,b,c){return b===!1?n.removeAttr(a,c):sc&&rc||!qc.test(c)?a.setAttribute(!rc&&n.propFix[c]||c,c):a[n.camelCase("default-"+c)]=a[c]=!0,c}},n.each(n.expr.match.bool.source.match(/\w+/g),function(a,b){var c=pc[b]||n.find.attr;pc[b]=sc&&rc||!qc.test(b)?function(a,b,d){var e,f;return d||(f=pc[b],pc[b]=e,e=null!=c(a,b,d)?b.toLowerCase():null,pc[b]=f),e}:function(a,b,c){return c?void 0:a[n.camelCase("default-"+b)]?b.toLowerCase():null}}),sc&&rc||(n.attrHooks.value={set:function(a,b,c){return n.nodeName(a,"input")?void(a.defaultValue=b):nc&&nc.set(a,b,c)}}),rc||(nc={set:function(a,b,c){var d=a.getAttributeNode(c);return d||a.setAttributeNode(d=a.ownerDocument.createAttribute(c)),d.value=b+="","value"===c||b===a.getAttribute(c)?b:void 0}},pc.id=pc.name=pc.coords=function(a,b,c){var d;return c?void 0:(d=a.getAttributeNode(b))&&""!==d.value?d.value:null},n.valHooks.button={get:function(a,b){var c=a.getAttributeNode(b);return c&&c.specified?c.value:void 0},set:nc.set},n.attrHooks.contenteditable={set:function(a,b,c){nc.set(a,""===b?!1:b,c)}},n.each(["width","height"],function(a,b){n.attrHooks[b]={set:function(a,c){return""===c?(a.setAttribute(b,"auto"),c):void 0}}})),l.style||(n.attrHooks.style={get:function(a){return a.style.cssText||void 0},set:function(a,b){return a.style.cssText=b+""}});var tc=/^(?:input|select|textarea|button|object)$/i,uc=/^(?:a|area)$/i;n.fn.extend({prop:function(a,b){return W(this,n.prop,a,b,arguments.length>1)},removeProp:function(a){return a=n.propFix[a]||a,this.each(function(){try{this[a]=void 0,delete this[a]}catch(b){}})}}),n.extend({propFix:{"for":"htmlFor","class":"className"},prop:function(a,b,c){var d,e,f,g=a.nodeType;if(a&&3!==g&&8!==g&&2!==g)return f=1!==g||!n.isXMLDoc(a),f&&(b=n.propFix[b]||b,e=n.propHooks[b]),void 0!==c?e&&"set"in e&&void 0!==(d=e.set(a,c,b))?d:a[b]=c:e&&"get"in e&&null!==(d=e.get(a,b))?d:a[b]},propHooks:{tabIndex:{get:function(a){var b=n.find.attr(a,"tabindex");return b?parseInt(b,10):tc.test(a.nodeName)||uc.test(a.nodeName)&&a.href?0:-1}}}}),l.hrefNormalized||n.each(["href","src"],function(a,b){n.propHooks[b]={get:function(a){return a.getAttribute(b,4)}}}),l.optSelected||(n.propHooks.selected={get:function(a){var b=a.parentNode;return b&&(b.selectedIndex,b.parentNode&&b.parentNode.selectedIndex),null}}),n.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){n.propFix[this.toLowerCase()]=this}),l.enctype||(n.propFix.enctype="encoding");var vc=/[\t\r\n\f]/g;n.fn.extend({addClass:function(a){var b,c,d,e,f,g,h=0,i=this.length,j="string"==typeof a&&a;if(n.isFunction(a))return this.each(function(b){n(this).addClass(a.call(this,b,this.className))});if(j)for(b=(a||"").match(F)||[];i>h;h++)if(c=this[h],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(vc," "):" ")){f=0;while(e=b[f++])d.indexOf(" "+e+" ")<0&&(d+=e+" ");g=n.trim(d),c.className!==g&&(c.className=g)}return this},removeClass:function(a){var b,c,d,e,f,g,h=0,i=this.length,j=0===arguments.length||"string"==typeof a&&a;if(n.isFunction(a))return this.each(function(b){n(this).removeClass(a.call(this,b,this.className))});if(j)for(b=(a||"").match(F)||[];i>h;h++)if(c=this[h],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(vc," "):"")){f=0;while(e=b[f++])while(d.indexOf(" "+e+" ")>=0)d=d.replace(" "+e+" "," ");g=a?n.trim(d):"",c.className!==g&&(c.className=g)}return this},toggleClass:function(a,b){var c=typeof a;return"boolean"==typeof b&&"string"===c?b?this.addClass(a):this.removeClass(a):this.each(n.isFunction(a)?function(c){n(this).toggleClass(a.call(this,c,this.className,b),b)}:function(){if("string"===c){var b,d=0,e=n(this),f=a.match(F)||[];while(b=f[d++])e.hasClass(b)?e.removeClass(b):e.addClass(b)}else(c===L||"boolean"===c)&&(this.className&&n._data(this,"__className__",this.className),this.className=this.className||a===!1?"":n._data(this,"__className__")||"")})},hasClass:function(a){for(var b=" "+a+" ",c=0,d=this.length;d>c;c++)if(1===this[c].nodeType&&(" "+this[c].className+" ").replace(vc," ").indexOf(b)>=0)return!0;return!1}}),n.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(a,b){n.fn[b]=function(a,c){return arguments.length>0?this.on(b,null,a,c):this.trigger(b)}}),n.fn.extend({hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)},bind:function(a,b,c){return this.on(a,null,b,c)},unbind:function(a,b){return this.off(a,null,b)},delegate:function(a,b,c,d){return this.on(b,a,c,d)},undelegate:function(a,b,c){return 1===arguments.length?this.off(a,"**"):this.off(b,a||"**",c)}});var wc=n.now(),xc=/\?/,yc=/(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;n.parseJSON=function(b){if(a.JSON&&a.JSON.parse)return a.JSON.parse(b+"");var c,d=null,e=n.trim(b+"");return e&&!n.trim(e.replace(yc,function(a,b,e,f){return c&&b&&(d=0),0===d?a:(c=e||b,d+=!f-!e,"")}))?Function("return "+e)():n.error("Invalid JSON: "+b)},n.parseXML=function(b){var c,d;if(!b||"string"!=typeof b)return null;try{a.DOMParser?(d=new DOMParser,c=d.parseFromString(b,"text/xml")):(c=new ActiveXObject("Microsoft.XMLDOM"),c.async="false",c.loadXML(b))}catch(e){c=void 0}return c&&c.documentElement&&!c.getElementsByTagName("parsererror").length||n.error("Invalid XML: "+b),c};var zc,Ac,Bc=/#.*$/,Cc=/([?&])_=[^&]*/,Dc=/^(.*?):[ \t]*([^\r\n]*)\r?$/gm,Ec=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,Fc=/^(?:GET|HEAD)$/,Gc=/^\/\//,Hc=/^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,Ic={},Jc={},Kc="*/".concat("*");try{Ac=location.href}catch(Lc){Ac=z.createElement("a"),Ac.href="",Ac=Ac.href}zc=Hc.exec(Ac.toLowerCase())||[];function Mc(a){return function(b,c){"string"!=typeof b&&(c=b,b="*");var d,e=0,f=b.toLowerCase().match(F)||[];if(n.isFunction(c))while(d=f[e++])"+"===d.charAt(0)?(d=d.slice(1)||"*",(a[d]=a[d]||[]).unshift(c)):(a[d]=a[d]||[]).push(c)}}function Nc(a,b,c,d){var e={},f=a===Jc;function g(h){var i;return e[h]=!0,n.each(a[h]||[],function(a,h){var j=h(b,c,d);return"string"!=typeof j||f||e[j]?f?!(i=j):void 0:(b.dataTypes.unshift(j),g(j),!1)}),i}return g(b.dataTypes[0])||!e["*"]&&g("*")}function Oc(a,b){var c,d,e=n.ajaxSettings.flatOptions||{};for(d in b)void 0!==b[d]&&((e[d]?a:c||(c={}))[d]=b[d]);return c&&n.extend(!0,a,c),a}function Pc(a,b,c){var d,e,f,g,h=a.contents,i=a.dataTypes;while("*"===i[0])i.shift(),void 0===e&&(e=a.mimeType||b.getResponseHeader("Content-Type"));if(e)for(g in h)if(h[g]&&h[g].test(e)){i.unshift(g);break}if(i[0]in c)f=i[0];else{for(g in c){if(!i[0]||a.converters[g+" "+i[0]]){f=g;break}d||(d=g)}f=f||d}return f?(f!==i[0]&&i.unshift(f),c[f]):void 0}function Qc(a,b,c,d){var e,f,g,h,i,j={},k=a.dataTypes.slice();if(k[1])for(g in a.converters)j[g.toLowerCase()]=a.converters[g];f=k.shift();while(f)if(a.responseFields[f]&&(c[a.responseFields[f]]=b),!i&&d&&a.dataFilter&&(b=a.dataFilter(b,a.dataType)),i=f,f=k.shift())if("*"===f)f=i;else if("*"!==i&&i!==f){if(g=j[i+" "+f]||j["* "+f],!g)for(e in j)if(h=e.split(" "),h[1]===f&&(g=j[i+" "+h[0]]||j["* "+h[0]])){g===!0?g=j[e]:j[e]!==!0&&(f=h[0],k.unshift(h[1]));break}if(g!==!0)if(g&&a["throws"])b=g(b);else try{b=g(b)}catch(l){return{state:"parsererror",error:g?l:"No conversion from "+i+" to "+f}}}return{state:"success",data:b}}n.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:Ac,type:"GET",isLocal:Ec.test(zc[1]),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":Kc,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":n.parseJSON,"text xml":n.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(a,b){return b?Oc(Oc(a,n.ajaxSettings),b):Oc(n.ajaxSettings,a)},ajaxPrefilter:Mc(Ic),ajaxTransport:Mc(Jc),ajax:function(a,b){"object"==typeof a&&(b=a,a=void 0),b=b||{};var c,d,e,f,g,h,i,j,k=n.ajaxSetup({},b),l=k.context||k,m=k.context&&(l.nodeType||l.jquery)?n(l):n.event,o=n.Deferred(),p=n.Callbacks("once memory"),q=k.statusCode||{},r={},s={},t=0,u="canceled",v={readyState:0,getResponseHeader:function(a){var b;if(2===t){if(!j){j={};while(b=Dc.exec(f))j[b[1].toLowerCase()]=b[2]}b=j[a.toLowerCase()]}return null==b?null:b},getAllResponseHeaders:function(){return 2===t?f:null},setRequestHeader:function(a,b){var c=a.toLowerCase();return t||(a=s[c]=s[c]||a,r[a]=b),this},overrideMimeType:function(a){return t||(k.mimeType=a),this},statusCode:function(a){var b;if(a)if(2>t)for(b in a)q[b]=[q[b],a[b]];else v.always(a[v.status]);return this},abort:function(a){var b=a||u;return i&&i.abort(b),x(0,b),this}};if(o.promise(v).complete=p.add,v.success=v.done,v.error=v.fail,k.url=((a||k.url||Ac)+"").replace(Bc,"").replace(Gc,zc[1]+"//"),k.type=b.method||b.type||k.method||k.type,k.dataTypes=n.trim(k.dataType||"*").toLowerCase().match(F)||[""],null==k.crossDomain&&(c=Hc.exec(k.url.toLowerCase()),k.crossDomain=!(!c||c[1]===zc[1]&&c[2]===zc[2]&&(c[3]||("http:"===c[1]?"80":"443"))===(zc[3]||("http:"===zc[1]?"80":"443")))),k.data&&k.processData&&"string"!=typeof k.data&&(k.data=n.param(k.data,k.traditional)),Nc(Ic,k,b,v),2===t)return v;h=k.global,h&&0===n.active++&&n.event.trigger("ajaxStart"),k.type=k.type.toUpperCase(),k.hasContent=!Fc.test(k.type),e=k.url,k.hasContent||(k.data&&(e=k.url+=(xc.test(e)?"&":"?")+k.data,delete k.data),k.cache===!1&&(k.url=Cc.test(e)?e.replace(Cc,"$1_="+wc++):e+(xc.test(e)?"&":"?")+"_="+wc++)),k.ifModified&&(n.lastModified[e]&&v.setRequestHeader("If-Modified-Since",n.lastModified[e]),n.etag[e]&&v.setRequestHeader("If-None-Match",n.etag[e])),(k.data&&k.hasContent&&k.contentType!==!1||b.contentType)&&v.setRequestHeader("Content-Type",k.contentType),v.setRequestHeader("Accept",k.dataTypes[0]&&k.accepts[k.dataTypes[0]]?k.accepts[k.dataTypes[0]]+("*"!==k.dataTypes[0]?", "+Kc+"; q=0.01":""):k.accepts["*"]);for(d in k.headers)v.setRequestHeader(d,k.headers[d]);if(k.beforeSend&&(k.beforeSend.call(l,v,k)===!1||2===t))return v.abort();u="abort";for(d in{success:1,error:1,complete:1})v[d](k[d]);if(i=Nc(Jc,k,b,v)){v.readyState=1,h&&m.trigger("ajaxSend",[v,k]),k.async&&k.timeout>0&&(g=setTimeout(function(){v.abort("timeout")},k.timeout));try{t=1,i.send(r,x)}catch(w){if(!(2>t))throw w;x(-1,w)}}else x(-1,"No Transport");function x(a,b,c,d){var j,r,s,u,w,x=b;2!==t&&(t=2,g&&clearTimeout(g),i=void 0,f=d||"",v.readyState=a>0?4:0,j=a>=200&&300>a||304===a,c&&(u=Pc(k,v,c)),u=Qc(k,u,v,j),j?(k.ifModified&&(w=v.getResponseHeader("Last-Modified"),w&&(n.lastModified[e]=w),w=v.getResponseHeader("etag"),w&&(n.etag[e]=w)),204===a||"HEAD"===k.type?x="nocontent":304===a?x="notmodified":(x=u.state,r=u.data,s=u.error,j=!s)):(s=x,(a||!x)&&(x="error",0>a&&(a=0))),v.status=a,v.statusText=(b||x)+"",j?o.resolveWith(l,[r,x,v]):o.rejectWith(l,[v,x,s]),v.statusCode(q),q=void 0,h&&m.trigger(j?"ajaxSuccess":"ajaxError",[v,k,j?r:s]),p.fireWith(l,[v,x]),h&&(m.trigger("ajaxComplete",[v,k]),--n.active||n.event.trigger("ajaxStop")))}return v},getJSON:function(a,b,c){return n.get(a,b,c,"json")},getScript:function(a,b){return n.get(a,void 0,b,"script")}}),n.each(["get","post"],function(a,b){n[b]=function(a,c,d,e){return n.isFunction(c)&&(e=e||d,d=c,c=void 0),n.ajax({url:a,type:b,dataType:e,data:c,success:d})}}),n.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(a,b){n.fn[b]=function(a){return this.on(b,a)}}),n._evalUrl=function(a){return n.ajax({url:a,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0})},n.fn.extend({wrapAll:function(a){if(n.isFunction(a))return this.each(function(b){n(this).wrapAll(a.call(this,b))});if(this[0]){var b=n(a,this[0].ownerDocument).eq(0).clone(!0);this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstChild&&1===a.firstChild.nodeType)a=a.firstChild;return a}).append(this)}return this},wrapInner:function(a){return this.each(n.isFunction(a)?function(b){n(this).wrapInner(a.call(this,b))}:function(){var b=n(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){var b=n.isFunction(a);return this.each(function(c){n(this).wrapAll(b?a.call(this,c):a)})},unwrap:function(){return this.parent().each(function(){n.nodeName(this,"body")||n(this).replaceWith(this.childNodes)}).end()}}),n.expr.filters.hidden=function(a){return a.offsetWidth<=0&&a.offsetHeight<=0||!l.reliableHiddenOffsets()&&"none"===(a.style&&a.style.display||n.css(a,"display"))},n.expr.filters.visible=function(a){return!n.expr.filters.hidden(a)};var Rc=/%20/g,Sc=/\[\]$/,Tc=/\r?\n/g,Uc=/^(?:submit|button|image|reset|file)$/i,Vc=/^(?:input|select|textarea|keygen)/i;function Wc(a,b,c,d){var e;if(n.isArray(b))n.each(b,function(b,e){c||Sc.test(a)?d(a,e):Wc(a+"["+("object"==typeof e?b:"")+"]",e,c,d)});else if(c||"object"!==n.type(b))d(a,b);else for(e in b)Wc(a+"["+e+"]",b[e],c,d)}n.param=function(a,b){var c,d=[],e=function(a,b){b=n.isFunction(b)?b():null==b?"":b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};if(void 0===b&&(b=n.ajaxSettings&&n.ajaxSettings.traditional),n.isArray(a)||a.jquery&&!n.isPlainObject(a))n.each(a,function(){e(this.name,this.value)});else for(c in a)Wc(c,a[c],b,e);return d.join("&").replace(Rc,"+")},n.fn.extend({serialize:function(){return n.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var a=n.prop(this,"elements");return a?n.makeArray(a):this}).filter(function(){var a=this.type;return this.name&&!n(this).is(":disabled")&&Vc.test(this.nodeName)&&!Uc.test(a)&&(this.checked||!X.test(a))}).map(function(a,b){var c=n(this).val();return null==c?null:n.isArray(c)?n.map(c,function(a){return{name:b.name,value:a.replace(Tc,"\r\n")}}):{name:b.name,value:c.replace(Tc,"\r\n")}}).get()}}),n.ajaxSettings.xhr=void 0!==a.ActiveXObject?function(){return!this.isLocal&&/^(get|post|head|put|delete|options)$/i.test(this.type)&&$c()||_c()}:$c;var Xc=0,Yc={},Zc=n.ajaxSettings.xhr();a.ActiveXObject&&n(a).on("unload",function(){for(var a in Yc)Yc[a](void 0,!0)}),l.cors=!!Zc&&"withCredentials"in Zc,Zc=l.ajax=!!Zc,Zc&&n.ajaxTransport(function(a){if(!a.crossDomain||l.cors){var b;return{send:function(c,d){var e,f=a.xhr(),g=++Xc;if(f.open(a.type,a.url,a.async,a.username,a.password),a.xhrFields)for(e in a.xhrFields)f[e]=a.xhrFields[e];a.mimeType&&f.overrideMimeType&&f.overrideMimeType(a.mimeType),a.crossDomain||c["X-Requested-With"]||(c["X-Requested-With"]="XMLHttpRequest");for(e in c)void 0!==c[e]&&f.setRequestHeader(e,c[e]+"");f.send(a.hasContent&&a.data||null),b=function(c,e){var h,i,j;if(b&&(e||4===f.readyState))if(delete Yc[g],b=void 0,f.onreadystatechange=n.noop,e)4!==f.readyState&&f.abort();else{j={},h=f.status,"string"==typeof f.responseText&&(j.text=f.responseText);try{i=f.statusText}catch(k){i=""}h||!a.isLocal||a.crossDomain?1223===h&&(h=204):h=j.text?200:404}j&&d(h,i,j,f.getAllResponseHeaders())},a.async?4===f.readyState?setTimeout(b):f.onreadystatechange=Yc[g]=b:b()},abort:function(){b&&b(void 0,!0)}}}});function $c(){try{return new a.XMLHttpRequest}catch(b){}}function _c(){try{return new a.ActiveXObject("Microsoft.XMLHTTP")}catch(b){}}n.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/(?:java|ecma)script/},converters:{"text script":function(a){return n.globalEval(a),a}}}),n.ajaxPrefilter("script",function(a){void 0===a.cache&&(a.cache=!1),a.crossDomain&&(a.type="GET",a.global=!1)}),n.ajaxTransport("script",function(a){if(a.crossDomain){var b,c=z.head||n("head")[0]||z.documentElement;return{send:function(d,e){b=z.createElement("script"),b.async=!0,a.scriptCharset&&(b.charset=a.scriptCharset),b.src=a.url,b.onload=b.onreadystatechange=function(a,c){(c||!b.readyState||/loaded|complete/.test(b.readyState))&&(b.onload=b.onreadystatechange=null,b.parentNode&&b.parentNode.removeChild(b),b=null,c||e(200,"success"))},c.insertBefore(b,c.firstChild)},abort:function(){b&&b.onload(void 0,!0)}}}});var ad=[],bd=/(=)\?(?=&|$)|\?\?/;n.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var a=ad.pop()||n.expando+"_"+wc++;return this[a]=!0,a}}),n.ajaxPrefilter("json jsonp",function(b,c,d){var e,f,g,h=b.jsonp!==!1&&(bd.test(b.url)?"url":"string"==typeof b.data&&!(b.contentType||"").indexOf("application/x-www-form-urlencoded")&&bd.test(b.data)&&"data");return h||"jsonp"===b.dataTypes[0]?(e=b.jsonpCallback=n.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,h?b[h]=b[h].replace(bd,"$1"+e):b.jsonp!==!1&&(b.url+=(xc.test(b.url)?"&":"?")+b.jsonp+"="+e),b.converters["script json"]=function(){return g||n.error(e+" was not called"),g[0]},b.dataTypes[0]="json",f=a[e],a[e]=function(){g=arguments},d.always(function(){a[e]=f,b[e]&&(b.jsonpCallback=c.jsonpCallback,ad.push(e)),g&&n.isFunction(f)&&f(g[0]),g=f=void 0}),"script"):void 0}),n.parseHTML=function(a,b,c){if(!a||"string"!=typeof a)return null;"boolean"==typeof b&&(c=b,b=!1),b=b||z;var d=v.exec(a),e=!c&&[];return d?[b.createElement(d[1])]:(d=n.buildFragment([a],b,e),e&&e.length&&n(e).remove(),n.merge([],d.childNodes))};var cd=n.fn.load;n.fn.load=function(a,b,c){if("string"!=typeof a&&cd)return cd.apply(this,arguments);var d,e,f,g=this,h=a.indexOf(" ");return h>=0&&(d=a.slice(h,a.length),a=a.slice(0,h)),n.isFunction(b)?(c=b,b=void 0):b&&"object"==typeof b&&(f="POST"),g.length>0&&n.ajax({url:a,type:f,dataType:"html",data:b}).done(function(a){e=arguments,g.html(d?n("<div>").append(n.parseHTML(a)).find(d):a)}).complete(c&&function(a,b){g.each(c,e||[a.responseText,b,a])}),this},n.expr.filters.animated=function(a){return n.grep(n.timers,function(b){return a===b.elem}).length};var dd=a.document.documentElement;function ed(a){return n.isWindow(a)?a:9===a.nodeType?a.defaultView||a.parentWindow:!1}n.offset={setOffset:function(a,b,c){var d,e,f,g,h,i,j,k=n.css(a,"position"),l=n(a),m={};"static"===k&&(a.style.position="relative"),h=l.offset(),f=n.css(a,"top"),i=n.css(a,"left"),j=("absolute"===k||"fixed"===k)&&n.inArray("auto",[f,i])>-1,j?(d=l.position(),g=d.top,e=d.left):(g=parseFloat(f)||0,e=parseFloat(i)||0),n.isFunction(b)&&(b=b.call(a,c,h)),null!=b.top&&(m.top=b.top-h.top+g),null!=b.left&&(m.left=b.left-h.left+e),"using"in b?b.using.call(a,m):l.css(m)}},n.fn.extend({offset:function(a){if(arguments.length)return void 0===a?this:this.each(function(b){n.offset.setOffset(this,a,b)});var b,c,d={top:0,left:0},e=this[0],f=e&&e.ownerDocument;if(f)return b=f.documentElement,n.contains(b,e)?(typeof e.getBoundingClientRect!==L&&(d=e.getBoundingClientRect()),c=ed(f),{top:d.top+(c.pageYOffset||b.scrollTop)-(b.clientTop||0),left:d.left+(c.pageXOffset||b.scrollLeft)-(b.clientLeft||0)}):d},position:function(){if(this[0]){var a,b,c={top:0,left:0},d=this[0];return"fixed"===n.css(d,"position")?b=d.getBoundingClientRect():(a=this.offsetParent(),b=this.offset(),n.nodeName(a[0],"html")||(c=a.offset()),c.top+=n.css(a[0],"borderTopWidth",!0),c.left+=n.css(a[0],"borderLeftWidth",!0)),{top:b.top-c.top-n.css(d,"marginTop",!0),left:b.left-c.left-n.css(d,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||dd;while(a&&!n.nodeName(a,"html")&&"static"===n.css(a,"position"))a=a.offsetParent;return a||dd})}}),n.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(a,b){var c=/Y/.test(b);n.fn[a]=function(d){return W(this,function(a,d,e){var f=ed(a);return void 0===e?f?b in f?f[b]:f.document.documentElement[d]:a[d]:void(f?f.scrollTo(c?n(f).scrollLeft():e,c?e:n(f).scrollTop()):a[d]=e)},a,d,arguments.length,null)}}),n.each(["top","left"],function(a,b){n.cssHooks[b]=Mb(l.pixelPosition,function(a,c){return c?(c=Kb(a,b),Ib.test(c)?n(a).position()[b]+"px":c):void 0})}),n.each({Height:"height",Width:"width"},function(a,b){n.each({padding:"inner"+a,content:b,"":"outer"+a},function(c,d){n.fn[d]=function(d,e){var f=arguments.length&&(c||"boolean"!=typeof d),g=c||(d===!0||e===!0?"margin":"border");return W(this,function(b,c,d){var e;return n.isWindow(b)?b.document.documentElement["client"+a]:9===b.nodeType?(e=b.documentElement,Math.max(b.body["scroll"+a],e["scroll"+a],b.body["offset"+a],e["offset"+a],e["client"+a])):void 0===d?n.css(b,c,g):n.style(b,c,d,g)},b,f?d:void 0,f,null)}})}),n.fn.size=function(){return this.length},n.fn.andSelf=n.fn.addBack,"function"==typeof define&&define.amd&&define("jquery",[],function(){return n});var fd=a.jQuery,gd=a.$;return n.noConflict=function(b){return a.$===n&&(a.$=gd),b&&a.jQuery===n&&(a.jQuery=fd),n},typeof b===L&&(a.jQuery=a.$=n),n});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12509020-1']);
  _gaq.push(['_trackPageview']);

try
{
//(function() {
// var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
// ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
// var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 //})();

 // doubleclick checker -
(function() {
 var o=onload, n=function(){setTimeout(function(){ if(typeof _gat === "undefined"){
 (function(){ var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
 //_gaq.push(['_trackEvent','GA Remarketing Tag','DC Script','Failed',0,false]);
}}, 1000); }
 if (typeof o!='function'){onload=n} else { onload=function(){o(); n()}}
})(window);

}
catch(err){
    //Do nothing
}

</script>
<script type="text/javascript">

if (typeof jQuery != 'undefined') {
  jQuery(document).ready(function($) {
    var filetypes = /\.(zip|exe|dmg|pdf|doc.*|xls.*|ppt.*|mp3|txt|rar|wma|mov|avi|wmv|flv|wav)$/i;
    var baseHref = '';
    if (jQuery('base').attr('href') != undefined) baseHref = jQuery('base').attr('href');

    jQuery('a').on('click', function(event) {
      var el = jQuery(this);
      var track = true;
      var href = (typeof(el.attr('href')) != 'undefined' ) ? el.attr('href') :"";
      var onclick = (typeof(el.attr('onclick')) != 'undefined' ) ? el.attr('onclick') :"";
      var isThisDomain = href.match(document.domain.split('.').reverse()[1] + '.' + document.domain.split('.').reverse()[0]);
      if (!href.match(/^javascript:/i)) {
        var elEv = []; elEv.value=0, elEv.non_i=false;
        if (href.match(/^mailto\:/i)) {
          elEv.category = "email";
          elEv.action = "click";
          elEv.label = href.replace(/^mailto\:/i, '');
          elEv.loc = href;
        }
        else if (href.match(filetypes)) {
          var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
          elEv.category = "download";
          elEv.action = "click-" + extension[0];
          elEv.label = href.replace(/ /g,"-");
          elEv.loc = baseHref + href;
        }
        else if (href.match(/^https?\:/i) && !isThisDomain) {
          elEv.category = "external";
          elEv.action = "click";
          elEv.label = href.replace(/^https?\:\/\//i, '');
          elEv.non_i = true;
          elEv.loc = href;
        }
        else if (href.match(/^http?\:/i) && isThisDomain) {
          elEv.category = "player";
          elEv.action = "navigation";
          elEv.label = href.replace(/^http?\:\/\//i, '');
          //elEv.non_i = true;
          elEv.loc = baseHref + href;
        }
        else if (href.match(/^\?t/i) && isThisDomain) {
          elEv.category = "player";
          elEv.action = "click";
          elEv.label = href.replace(/^http?\:\/\//i, '');
          //elEv.non_i = true;
          elEv.loc = baseHref + href;
        }
        else if (href.match(/^tel\:/i)) {
          elEv.category = "telephone";
          elEv.action = "click";
          elEv.label = href.replace(/^tel\:/i, '');
          elEv.loc = href;
        }
        else track = false;
        if (track) {
          _gaq.push(['_trackEvent', elEv.category.toLowerCase(), elEv.action.toLowerCase(), elEv.label.toLowerCase(), elEv.value, elEv.non_i]);
          if ( el.attr('target') == undefined || el.attr('target').toLowerCase() != '_blank') {
            setTimeout(function() { location.href = elEv.loc; }, 400);
            return false;
      }
    }
      }
    });
  });
}
</script>
</html>
