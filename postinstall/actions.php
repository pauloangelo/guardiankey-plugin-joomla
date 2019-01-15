	<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Authentication.GuardianKey
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
require_once dirname(__FILE__) . '../guardiankey.class.php';

function guardiankey_postinstall_condition()
{
	
	$db = JFactory::getDbo();
	$query = $db->getQuery(true)
		->select('*')
		->from($db->qn('#__extensions'))
		->where($db->qn('type') . ' = ' . $db->q('plugin'))
		->where($db->qn('enabled') . ' = ' . $db->q('1'))
		->where($db->qn('folder') . ' = ' . $db->q('authentication'))
		->where($db->qn('element') . ' = ' . $db->q('guardiankey'));
	$db->setQuery($query);
	$enabled_plugins = $db->loadObjectList();
	return count($enabled_plugins) == 0;
	
}

function guardiankey_postinstall_action(){

		$guardiankey = new GuardianKey();
		$user = JFactory::getUser();
		$GKinfo = $guardiankey->register($user->email);
		if (is_array($GKinfo)) {
			$rjson = new stdClass();
			$rjson->gk_registration_email = $GKinfo['email'];
			$rjson->gk_agentId = $GKinfo['agentid'];
			$rjson->gk_key = $GKinfo['key'];
			$rjson->gk_orgId = $GKinfo['orgid'];
			$rjson->gk_iv = $GKinfo['iv'];
			$rjson->gk_groupId = $GKinfo['groupid'];
			$rjson->gk_service = 'Joomla!';
			$rjson->gk_reverse = '1';
			$rjson->gk_notify_users = '0';
			$rjson->gk_subject_mail = 'asasasdasd';
			$rjson->gk_text_mail = 'asdasdasd';
			
			$sjson = json_decode($rjson);
			

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('params') . ' = ' . $db->quote($sjson)
			);
			$conditions = array(
				$db->quoteName('element') . ' = guardiankey', 
			);
			$query->update($db->quoteName('#__extensions') )->set($fields)->where($conditions);
			$db->setQuery($query);

			$result = $db->execute();



 // Enable the plugin
 $db = JFactory::getDbo();
   $query = $db->getQuery(true)
 	->select('*')
 	->from($db->qn('#__extensions'))
 	->where($db->qn('type') . ' = ' . $db->q('plugin'))
 	->where($db->qn('enabled') . ' = ' . $db->q('0'))
 	->where($db->qn('folder') . ' = ' . $db->q('authentication'))
 	->where($db->qn('element') . ' = ' . $db->q('guardiankey'));
 $db->setQuery($query);
 $enabled_plugins = $db->loadObjectList();
 
  $query = $db->getQuery(true)
 	->update($db->qn('#__extensions'))
 	->set($db->qn('enabled') . ' = ' . $db->q(1))
 	->where($db->qn('type') . ' = ' . $db->q('plugin'))
 	->where($db->qn('folder') . ' = ' . $db->q('authentication'))
 	->where($db->qn('element') . ' = ' . $db->q('guardiankey'));
 $db->setQuery($query);
 $db->execute();
 
   //Redirect the user to the plugin configuration page
 $url = 'index.php?option=com_plugins&view=plugin&layout=edit&extension_id='
           .$enabled_plugins[0]->extension_id ;
 JFactory::getApplication()->redirect($url);
 
		}
}