<?php
require_once("../include/synoconf.php");
require_once("../include/database.php");
require_once("../include/misc.php");

if (isset($_POST['node'])) {
	echo SYNOBLOG_IMG_GetPublicTreeData($_POST['node']);
	exit;
}

$action = (array_key_exists('action', $_POST)) ? $_POST['action'] : null ;
if ('get_album_photo' == $action) {
	echo SYNOBLOG_IMG_GetAlbumPhoto(hex2binForPath($_POST['current_dir']));
	exit;
}

function SYNOBLOG_IMG_GetAlbumPhoto($album)
{
	$album = stripslashes($album);
	global $SYNO_PHOTO_THUMB_WIDTH, $SYNO_PHOTO_THUMB_HEIGHT, $SYNOBLOG_PHOTO_SERVICE_REAL_DIR_PATH;
	global $SYNOBLOG_PHOTO_SERVICE_REAL_DIR, $SYNOBLOG_PHOTO_SERVICE_REAL_DIR_PREFIX;
	$files = array();
	$i = 0;

	if($album == null || $album == "") {
		return json_encode($files);
	}


	$escape = BLOG_DB_GetEscape();
	$query = "Select * from photo_image where path like ? $escape and path not like ? $escape order by path ";
	$sqlParam = array($SYNOBLOG_PHOTO_SERVICE_REAL_DIR_PATH.SYNOBLOG_MISC_EscapForLike($album)."/%",
					  $SYNOBLOG_PHOTO_SERVICE_REAL_DIR_PATH.SYNOBLOG_MISC_EscapForLike($album)."/%/%");

	$db_result = BLOG_DB_PHOTO_Query($GLOBALS['dbconn_photo'], $query, $sqlParam);

	while(($row = BLOG_DB_PHOTO_FetchRow($db_result))) {
		$path = $SYNOBLOG_PHOTO_SERVICE_REAL_DIR_PREFIX.$row[1];
		$file_name = basename($path);
		$dir_name = substr(str_replace("/".$file_name, "", $path), strlen($SYNOBLOG_PHOTO_SERVICE_REAL_DIR."/"));

		$src = $url = SYNOBLOG_MISC_GetUrlPrefix().'/photo/convert.php?dir='.bin2hex($dir_name).'&name='.bin2hex($file_name).'&type=';
		$have_thumb = SYNOBLOG_MISC_IsPhotoFileWithThumb($file_name);

		if($have_thumb) {
			$url .= '0'; // small thumb
			$src .= '1'; // big thumb
		} else {
			$url .= '2'; // orig
			$src .= '2';
		}

		if ($row['version'] % 2 == 0) {
			$tmp = SYNOBLOG_MISC_GetWidthHeight($row[7],$row[8],$SYNO_PHOTO_THUMB_WIDTH,$SYNO_PHOTO_THUMB_HEIGHT);
		} else {
			$tmp = SYNOBLOG_MISC_GetWidthHeight($row[8],$row[7],$SYNO_PHOTO_THUMB_WIDTH,$SYNO_PHOTO_THUMB_HEIGHT);
		}

		$files['images'][$i]['id'] = $i;
		$files['images'][$i]['dir'] = htmlspecialchars($dir_name);
		$files['images'][$i]['name'] = htmlspecialchars($file_name);
		$files['images'][$i]['url'] = $url;
		$files['images'][$i]['src'] = $src;
		$files['images'][$i]['dispaly_info'] = htmlspecialchars($dir_name."/".$file_name);
		$files['images'][$i]['thumb_width'] = $tmp['width'];
		$files['images'][$i]['thumb_height'] = $tmp['height'];

		$i++;
	}

	return json_encode($files);
}


function SYNOBLOG_IMG_GetPublicTreeData($path)
{
	if (!strstr($path, 'source')) {
		return json_encode(array());
	}

	$escape = BLOG_DB_GetEscape();
	$path = hex2binForPath(stripslashes($path));

	if($path == "source") {
		$query = "Select sharename from photo_share where is_subdir = 'f' and public = 't'";
		$sqlParam = array();
	} else {
		$query = "Select sharename from photo_share where public = 't' and sharename like ? order by sharename";
		$sqlParam = array(substr($path, 7).'/%');
	}
	$db_result = BLOG_DB_PHOTO_Query($GLOBALS['dbconn_photo'], $query, $sqlParam);

	$i = 0;
	while(($row = BLOG_DB_PHOTO_FetchRow($db_result))) {
		$result[$i]['text'] = basename($row[0]);
		$result[$i]['id'] = 'source/';
		$result[$i]['id'] .= (dirname($row[0]) == '.') ? '' : bin2hex(dirname($row[0])) . '/';
		$result[$i]['id'] .= bin2hex(basename($row[0]));
		$result[$i]['cls'] = 'root';
		$i++;
	}

	return json_encode($result);

}

function hex2bin($hexdata) {
	for ($i=0;$i<strlen($hexdata);$i+=2) {
		$bindata.=chr(hexdec(substr($hexdata,$i,2)));
	}
	return $bindata;
}
function hex2binForPath($path) {
	if (null == $path) {
		return false;
	}
	$array_path = explode('/', '/'.$path);
	$ret = 'source';
	foreach ($array_path as $part) {
		if ($part == null || $part == 'source') continue;
		$ret .= "/" . hex2bin($part);
	}
	if (FALSE == strstr($path,'source')) {
		$ret = preg_replace ('/source\//' , '' , $ret);
	}
	return $ret;
}
?>
