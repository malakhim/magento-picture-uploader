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
	 * TODO: Send email after items loaded into database
	 * TODO: Change email back to Disrupt
	 * TODO: Handle error messages gracefully (using session?)
	 */
	public function indexAction(){
		$this->loadLayout();

		$this->renderLayout();

		if(isset($_FILES['surfimage']['name']) && $_FILES['surfimage']['name'] != '')
		{
		    try
		    {       
		    	// Add file to database
		    	
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
		        
		        $picture = Mage::getModel('pictureupload/picture');
		        $picture->setName($_POST['name']);
		        $picture->setEmail($_POST['email']);
		        $picture->setIp($_SERVER['REMOTE_ADDR']);
		        $picture->setFilename($_FILES['surfimage']['name']);
		        $picture->setTimestamp(microtime(true));
		        $picture->setTitle($_POST['title']);
		        $picture->save();

		        // Send email to Disrupt
		        $body = "Hi there, ".$_POST['name']." has uploaded a new image to put on a surfboard";
		        $mail = Mage::getModel('core/email');
		        $mail->setToName('Disrupt');
		        $mail->setToEmail('malakhim@gmail.com');
		        $mail->setBody($body);
		        $mail->setSubject('A new image has been uploaded');
		        $mail->setFromEmail(Mage::getStoreConfig('trans_email/ident_support/email'));
		        $mail->setFromName(Mage::getStoreConfig('trans_email/ident_support/name'));
		        $mail->setType('html');
		        try{
		        	$mail->send();
		        	Mage::getSingleton('core/session')->addSuccess('Your request has been sent');
		        	// TODO: Redirect user to view page upon success
		        	$this->_redirect('pictureupload/index/view');
		        }

		        catch (Exception $e) {
			   		Mage::getSingleton('core/session')->addError('Unable to send. Mailing error: '.$e->getMessage());
			   		echo 'Mailing error: '.$e->getMessage();
				}
		        //FIXME: Debugging testing redirect
				finally{
		        	$this->_redirect('pictureupload/index/view');
				}
		    }
		    catch (Exception $e)
		    {
		        echo 'Error Message: '.$e->getMessage();
		    }
		}
	}

	public function viewAction(){
		$this->loadLayout();

		// Get block names - Debugging, for local.xml
		// $blocks = Mage::app()->getLayout()->getAllBlocks();
		// var_dump(array_keys($blocks));
		
		// Pull database entries into collection
		$images = Mage::getModel('pictureupload/picture')->getCollection()->getData();

		// Pass to block
		Mage::register('uploaded_images',$images);

		// Show array of images on screen, with corresponding titles and artists
		// Link to like/share buttons for each
		
		$this->renderLayout();
	}
}