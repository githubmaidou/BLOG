<?php
header("Content-type:text/html;charset=utf-8");
function curl_get($url)
{
    $refer = "http://music.163.com/";
    $header[] = "Cookie: " . "appver=1.5.0.75771;";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, $refer);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
  
function music_search($s,$limit){
    $url= "http://music.163.com/api/search/pc";
    $curl = curl_init();
    $post_data ="s=".$s."&limit=".$limit."&type=1&offset=0&total=true&hlpretag='<span class=\"s-fc7\">'&hlposttag='</span>'&#/outchain/2/28371369/m/use/html=";
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $header =array(
        'Host: music.163.com',
        'Origin: http://music.163.com',
        'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36',
        'Content-Type: application/x-www-form-urlencoded',
        'Referer: http://music.163.com/search/',
    );
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    $src = curl_exec($curl);
    curl_close($curl);
    return $src;
}
function get_music_info($music_id)
{
    $url = "http://music.163.com/api/song/detail/?id=" . $music_id . "&ids=%5B" . $music_id . "%5D";
    return curl_get($url);
}
  
function get_artist_album($artist_id, $limit)
{
    $url = "http://music.163.com/api/artist/albums/" . $artist_id . "?limit=" . $limit;
    return curl_get($url);
}
  
function get_album_info($album_id)
{
    $url = "http://music.163.com/api/album/" . $album_id;
    return curl_get($url);
}
  
function get_playlist_info($playlist_id)
{
    $url = "http://music.163.com/api/playlist/detail?id=" . $playlist_id;
    return curl_get($url);
}
  
function get_music_lyric($music_id)
{
    $url = "http://music.163.com/api/song/lyric?os=pc&id=" . $music_id . "&lv=-1&kv=-1&tv=-1";
    return curl_get($url);
}
  
function get_mv_info()
{
    $url = "http://music.163.com/api/mv/detail?id=319104&type=mp4";
    return curl_get($url);
}
$body= '['.music_search($_GET['keyword'],$_GET['limit']).']';

$mp3array=json_decode($body)[0]->result->songs;
#print_r($mp3array);
for ($a=0;$a<count($mp3array);$a++) {
	echo $mp3array[$a]->name.'-'.$mp3array[$a]->artists[0]->name.','.$mp3array[$a]->mp3Url.','.$mp3array[$a]->album->picUrl.'^';
	
}

#print_r(json_decode($body)[0]->result->songs[0]->name);
#echo ',';
#print_r(json_decode($body)[0]->result->songs[0]->mp3Url);
#echo ',';
#echo json_decode($body)[0]->result->songs[0]->album->picUrl;
#echo json_decode($body)[0]->result->songs[0]->album->id;
#foreach(json_decode($body)[0]->result->songs[0]->album as $key=>$value){
#print_r($key);
#echo '<br>';
#print_r($value);
#echo '<br>';
#}
?>
