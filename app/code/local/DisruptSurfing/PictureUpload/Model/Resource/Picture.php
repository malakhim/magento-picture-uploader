<?php
// Note: Every model requires a resource
class DisruptSurfing_PictureUpload_Model_Resource_Picture extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('pictureupload/picture', 'picture_id');
    }
}