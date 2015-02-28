<?php
	// Note indexController will be automatically referred to in www.site.com/helloworld
	class tutorialmagento_Helloworld_IndexController extends Mage_Core_Controller_Front_Action{
		/**
		 * index action
		 */
		// Likewise, indexAction will automatically be referred to as the action in www.site.com/helloworld
		public function indexAction(){
			// Load the layout block and template from layout files
			$this->loadLayout();

			// Render the interface frmo the block, according to the order that was preset in the layout file
			$this->renderLayout();
		}
	}

