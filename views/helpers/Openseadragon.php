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
		if (metadata($item, array('Item Type Metadata', 'Flickr URL\'s'))) {
            $flickr_urls = metadata($item, array('Item Type Metadata', 'Flickr URL\'s'));
			$flickr_urls = json_decode(html_entity_decode($flickr_urls), true);
        }

        // Return if there are no valid Flickr data.
        else {
            return;
        }

        return $this->view->partial('common/openseadragon.php', array(
            'flickr_urls' => $flickr_urls
        ));
    }
}
