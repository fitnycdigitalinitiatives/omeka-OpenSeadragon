<?php
/**
 * OpenSeadragon (based on DPLA fork of the ZoomIt plugin)
 *
 * @copyright Copyright 2014 Digital Public Library of America
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * @package OpenSeadragon\View\Helper
 */
class OpenSeadragon_View_Helper_Openseadragon extends Zend_View_Helper_Abstract
{
    protected $_supportedExtensions = array('bmp', 'gif', 'ico', 'jpeg', 'jpg',
                                            'png', 'tiff', 'tif');

    /**
     * Return a OpenSeadragon image viewer for the provided files.
     *
     * @param File|array $files A File record or an array of File records.
     * @param int $width The width of the image viewer in pixels.
     * @param int $height The height of the image viewer in pixels.
     * @return string|null
     */
    public function openseadragon($item)
    {
      // Check for valid Flickr data.
  		if (($record_name = metadata($item, array('Item Type Metadata', 'Record Name'), array('all' => true))) && ($record_id = metadata($item, array('Item Type Metadata', 'Record ID'), array('all' => true))) && ($width = metadata($item, array('Item Type Metadata', 'Width'), array('all' => true))) && ($height = metadata($item, array('Item Type Metadata', 'Height'), array('all' => true)))) {
        if (count($record_name) == 1) {
          return $this->view->partial('common/openseadragon.php', array(
              'record_name' => $record_name[0], 'record_id' => $record_id[0], 'width' => $width[0], 'height' => $height[0]
          ));
        }
        elseif (count($record_name) > 1) {
          $tilesource = array();
          $arrlength = count($record_id);
          for ($x = 0; $x < $arrlength; $x++) {
            if (($record_name[$x]) && ($record_id[$x]) && ($width[$x]) && ($height[$x])) {
              $type = array('type' => 'legacy-image-pyramid');
              $levels = array('levels' => openseadragon_create_mdid_pyramid($record_name[$x], $record_id[$x], $width[$x], $height[$x]));
              $tilesource[] = $type + json_decode($levels, true);
            }
          }
          return $this->view->partial('common/openseadragon_collection.php', array(
              'tilesource' => json_encode($tilesource), 'record_name' => $record_name[0]
          ));
        }
      }
      // Return if there are no valid Flickr data.
      else {
        return;
      }
    }
}
