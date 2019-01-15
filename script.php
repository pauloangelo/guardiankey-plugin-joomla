<?php
// No direct access to this file
defined('_JEXEC') or die;

/**
 * Script file of GuardianKey module
 */
 
require_once dirname(__FILE__) . '/guardiankey.class.php';

class PlgAuthenticationGuardianKeyInstallerScript
{
	/**
	 * Method to install the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function install($parent) 
	{   $db = JFactory::getDbo();
     $query = 'INSERT INTO '. $db->quoteName('#__postinstall_messages') .
              ' ( `extension_id`, 
                  `title_key`, 
                  `description_key`, 
                  `action_key`, 
                  `language_extension`, 
                  `language_client_id`, 
                  `type`, 
                  `action_file`, 
                  `action`, 
                  `condition_file`, 
                  `condition_method`, 
                  `version_introduced`, 
                  `enabled`) VALUES '
              .'( 700,
               "Congratulations! You installed GuardianKey plugin!", 
               "- Go to  Administration->Extensions->Plugins-Authentication - GuardianKey, and check if the fields are values. If not, you need visit https://panel.guardiankey.io for register and get keys.<br> 
					 - If not happened any error in installation, go to Administration->Extensions->Plugins and enable GuardianKey. You need disable plugin Authentication - Joomla after enable Authentication - GuardianKey.<br>", 
               "GuardianKey PostInstall",
               "",
                1,
               "action", 
               "site://plugins/authentication/guardiankey/actions.php",
               "guardiankey_postinstall_action", 
               "site://plugins/authentication/guardiankey/actions.php", 
               "guardiankey_postinstall_condition", 
               "3.2.0", 
               1)';
     
     $db->setQuery($query);
     $db->execute();
		}

function uninstall( $parent ) {               
  
 }      		
	
	}