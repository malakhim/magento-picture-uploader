<?php

class DisruptSurfing_PictureUpload_IndexController extends Mage_Core_Controller_Front_Action{

	/**
	 * Handles image upload template and file processing
	 * TODO: Separate file processing
	 * TODO: Check if file already exists
	 * TODO: Limit file size
	 * TODO: Limit file types (Check with Gary what file types are allowable)
	 * TODO: Check with Gary if duplicates are allowed
	 * TODO: Check with Gary if we want these images to be left on server after email has been sent
	 * TODO: Create install script for database
	 * TODO: Add items into database
	 * TODO: Send email after items loaded into database
	 */
	public function indexAction(){
		$this->loadLayout();

		$this->renderLayout();

		if(isset($_FILES['surfimage']['name']) && $_FILES['surfimage']['name'] != '')
		{
		    try
		    {       
		        $path = Mage::getBaseDir().DS.'uploaded_surfboard_images'.DS;  
		        $fname = $_FILES['surfimage']['name']; 
		        // Load magento's file uploader class
		        $uploader = new Varien_File_Uploader('surfimage');
		        // Allowed extensions
		        $uploader->setAllowedExtensions(array('jpg','png','gif','jpeg','bmp'));
		        // Create the directory if it doesn't exist
		        $uploader->setAllowCreateFolders(true);
		        // If file already exists, uploaded file's name will be changed
		        $uploader->setAllowRenameFiles(false);
		        // If true, file dispersion is supported - These are small files so we're not allowing that
		        $uploader->setFilesDispersion(false);
		        // Save file
		        $uploader->save($path,$fname);
		         
		    }
		    catch (Exception $e)
		    {
		        echo 'Error Message: '.$e->getMessage();
		    }
		}
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
