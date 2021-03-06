<?php
/**
 * OpenSeadragon (based on DPLA fork of the ZoomIt plugin)
 *
 * @copyright Copyright 2014 Digital Public Library of America
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

 function openseadragon_create_mdid_pyramid($record_name, $record_id, $width, $height)
 {
   $pyramid = array();
   if ($height >= $width) {
     $height_4 = 400;
     $width_4 = floor(($width * 400) / $height);
     $dimensions_4 = array('height' => (int) $height_4, 'width' => (int) $width_4);
   	$url_4 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/400x400/');
     $height_3 = 1000;
     $width_3 = floor(($width * 1000) / $height);
     $dimensions_3 = array('height' => (int) $height_3, 'width' => (int) $width_3);
   	$url_3 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/' . $width_3 . 'x' . $height_3 . '/');
     $height_2 = 2000;
     $width_2 = floor(($width * 2000) / $height);
     $dimensions_2 = array('height' => (int) $height_2, 'width' => (int) $width_2);
   	$url_2 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/' . $width_2 . 'x' . $height_2 . '/');
   }
   else {
     $width_4 = 400;
     $height_4 = floor(($height * 400) / $width);
     $dimensions_4 = array('height' => (int) $height_4, 'width' => (int) $width_4);
   	$url_4 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/400x400/');
     $width_3 = 1000;
     $height_3 = floor(($height * 1000) / $width);
     $dimensions_3 = array('height' => (int) $height_3, 'width' => (int) $width_3);
   	$url_3 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/' . $width_3 . 'x' . $height_3 . '/');
     $width_2 = 2000;
     $height_2 = floor(($height * 2000) / $width);
     $dimensions_2 = array('height' => (int) $height_2, 'width' => (int) $width_2);
   	$url_2 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/' . $width_2 . 'x' . $height_2 . '/');
   }
   $dimensions_1 = array('height' => (int) $height, 'width' => (int) $width);
   $url_1 = array('url' => 'https://fitdil.fitnyc.edu/media/get/' . $record_id . '/' . $record_name . '/');
   $pyramid[] = $url_4 + $dimensions_4;
   $pyramid[] = $url_3 + $dimensions_3;
   $pyramid[] = $url_2 + $dimensions_2;
   $pyramid[] = $url_1 + $dimensions_1;
   return json_encode($pyramid);
 }

function openseadragon_create_pyramid($image)
{
    $sizes = array('original', 'fullsize', 'thumbnail');
    $pyramid = array();
    foreach ($sizes as $size) {
        $pyramid[] = openseadragon_pyramid_level($image, $size);
    }
    return json_encode($pyramid);
}

function openseadragon_pyramid_level($image, $size='original')
{
    $url = array('url' => $image->getWebPath($size));
    $dimensions = openseadragon_dimensions($image, $size);
    $level = $url + $dimensions;
    return $level;
}

function openseadragon_dimensions($image, $size='original')
{

    // If we're getting the level hash for original, trust stored ID3 data
    $stored_md = json_decode($image->metadata, true);
    if (($size == 'original') && ($md = _dimensions_from_id3($stored_md))) {
        return $md;
    }

    // If it's not an original, or there was no stored ID3 data, try using
    // gd's getimagesize() function
    if ($md = _dimensions_from_gd($image, $size)) {
        return $md;
    }

    // If that didn't work, try exif_read_data(), which only works on
    // JPEGs and TIFFs
    if ($md = _dimensions_from_exif($image, $size)) {
        return $md;
    }

    // If all else fails and it's not an original, bodge together dimensions
    // from the size constraints. NOTE:: this has an adverse impact on aspect
    // ratio.
    if ($size != 'original') {
        return array(
            'width' => (int) get_option($size.'_constraint'),
            'height' => (int) get_option($size.'_constraint')
        );
    }

    // If all else fails, just return null, because we don't know what to do
    else {
        return array('width' => null, 'height' => null);
    }
}

function _get_full_path($image, $size='original')
{
    return FILES_DIR.'/'.$image->getStoragePath($size);
}

function _dimensions_from_id3($source)
{
    if ((isset($source['video']))
    && (isset($source['video']['resolution_x']))
    && (isset($source['video']['resolution_y'])))
    {
        return array(
            'width' => $source['video']['resolution_x'],
            'height' => $source['video']['resolution_y']
            );
    } else {
        return false;
    }
}

function _dimensions_from_gd($image, $size='original')
{
    try {
        $fn = _get_full_path($image, $size);
        list($width, $height, $type, $attrs) = getimagesize($fn);
        return array('width' => $width, 'height' => $height);
    } catch (Exception $e) {
        $message = $e->getMessage();
        _log("Getting dimensions using getimagesize failed: $message");
        return false;
    }
}

function _dimensions_from_exif($image, $size='original')
{
    try {
        $fn = _get_full_path($image, $size);
        $d = new Omeka_File_MimeType_Detect($fn);
        if (array_search($d->detect(), array('image/tiff', 'image/jpeg'))) {
            $exif_md = exif_read_data($fn, 'COMPUTED');
            return array(
                'width' => $exif_md['COMPUTED']['Width'],
                'height' => $exif_md['COMPUTED']['Height']
            );
        } else {
            return false;
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
        _log("Getting dimensions using exif_read_data failed: $message");
        return false;
    }
}

?>
