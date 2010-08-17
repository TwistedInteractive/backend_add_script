<?php
	Class extension_backend_add_script extends Extension
	{
		/**
		* About this extension:
		*/
		public function about()
		{
			return array(
				'name' => 'Backend add script',
				'version' => '1.1',
				'release-date' => '2010-08-17',
				'author' => array(
					'name' => 'Giel Berkers',
					'website' => 'http://www.gielberkers.com',
					'email' => 'info@gielberkers.com'),
				'description' => 'Adds a hook to the backend so you can easily make JavaScript adjustments on certain pages'
			);
		}
		
		/**
		* Set the delegates
		*/
		public function getSubscribedDelegates()
		{
			return array(
				array(
					'page' => '/backend/',
					'delegate' => 'InitaliseAdminPageHead',
					'callback' => 'addScriptToHead'
				)
			);
		}
		
		/**
		 * Add script to the <head>-section of the admin area
		 */
		public function addScriptToHead($context)
		{
			// We have to put a lot of javascript here since there are missing some handles:
			$javaScript = "\n";
			$callback   = $context['parent']->getPageCallback();
			
			// Current callback and action:
			$driver = '"'.$callback['driver'].'"';
			$action = isset($callback['context']['page']) ? '"'.$callback['context']['page'].'"' : 'false';
			$section= isset($callback['context']['section_handle']) ? '"'.$callback['context']['section_handle'].'"' : 'false';
			$idEntry= isset($callback['context']['entry_id']) ? '"'.$callback['context']['entry_id'].'"' : 'false';
			
			// User information:
			$javaScript.= "var user_id   = ".$context['parent']->Author->get('id').";\n";
			$javaScript.= "var user_type = '".$context['parent']->Author->get('user_type')."';\n";
			$javaScript.= "var driver    = ".$driver.";\n";
			$javaScript.= "var action    = ".$action.";\n";
			$javaScript.= "var section   = ".$section.";\n";
			$javaScript.= "var id_entry  = ".$idEntry.";\n";
			
			$tag = new XMLElement('script', $javaScript, array('type'=>'text/javascript'));
			$context['parent']->Page->addElementToHead($tag, 50);
			$context['parent']->Page->addScriptToHead(URL.'/extensions/backend_add_script/assets/custom.js', 51, false);
			$context['parent']->Page->addStylesheetToHead(URL.'/extensions/backend_add_script/assets/custom.css', 'screen', 201);
		}	
	}
?>