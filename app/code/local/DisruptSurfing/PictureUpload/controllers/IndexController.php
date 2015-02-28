<?php

class DisruptSurfing_PictureUpload_IndexController extends Mage_Core_Controller_Front_Action{

	public function indexAction(){
		$this->loadLayout();

		$this->renderLayout();
	}

	public function goodbyeAction(){
		$this->loadLayout();

		$this->renderLayout();	
	}

	public function testAction(){
		echo "Setup!";
	}

	public function testModelAction(){
		// $picture = Mage::getModel('pictureupload/picture');
		// echo get_class($picture);

		// Get request parameters and assign to $params
	    $params = $this->getRequest()->getParams();
	    $picture = Mage::getModel('pictureupload/picture');
	    echo("Loading the picture with an ID of ".$params['picture_id']);
	    $picture->load($params['picture_id']);
	    $data = $picture->getData();
	    var_dump($data);
	}

	public function createNewPostAction(){
		$picture = Mage::getModel('pictureupload/picture');
		$picture->setFilename('testpic2.jpg');
		$picture->setName('Bob Marley');
		$picture->setEmail('bob@bob.com');
		$picture->setIp('1.1.1.1');
		$picture->save();
		echo 'picture with ID '.$picture->getID().' created!';
	}

	public function editPictureAction(){
		$picture = Mage::getModel('pictureupload/picture');
		$picture->load(1);
		$picture->setName('John Smith');
		$picture->save();
		echo 'Post edited';
	}

	public function deletePictureAction(){
		$picture = Mage::getModel('pictureupload/picture');
		$picture->load(1);
		$picture->delete();
		echo 'Picture deleted';
	}

	public function showAllPicturesAction(){
		$pictures = Mage::getModel('pictureupload/picture')->getCollection();
		foreach($pictures as $pic){
			echo '<h3>'.$pic->getFilename().'</h3>';
			echo nl2br($pic->getName());
		}
	}
}
