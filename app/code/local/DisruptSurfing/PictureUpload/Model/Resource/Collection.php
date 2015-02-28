<?php
class DisruptSurfing_PictureUpload_Model_Resource_Picture_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected function _construct(){
		$this->init('pictureupload/picture');
	}
}
