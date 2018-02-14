<?php

/**
 * @file plugins/themes/default/coloftechThemePlugin.inc.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University Library
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class coloftechThemePlugin
 * @ingroup plugins_themes_default_manuscript
 *
 * @brief Default theme
 */
import('lib.pkp.classes.plugins.GenericPlugin');
import('lib.pkp.classes.plugins.ThemePlugin');
//import('classes.user.UserDAO');
import('lib.pkp.classes.user.PKPUser');


class coloftechThemePlugin extends ThemePlugin {
	/**
	 * Initialize the theme's styles, scripts and hooks. This is only run for
	 * the currently active theme.
	 *
	 * @return null
	 */
	public function init() {

		// Initialize the parent theme
		$this->setParent('defaultthemeplugin');
		
		$this->addStyle('bootstrap3', 'bootstrap/css/bootstrap.min.css');
		$this->addScript('bootstrap3', 'bootstrap/js/bootstrap.min.js');

		// Add custom styles
		$this->modifyStyle('stylesheet', array('addLess' => array('styles/index.less')));

		$this->addStyle('customcss', 'styles/css/index.css');
		// Remove the typography options of the parent theme.
		// `removeOption` was introduced in OJS 3.0.2
		if (method_exists($this, 'removeOption')) {
			$this->removeOption('typography');
		}

		// Add the option for an accent color
		$this->addOption('accentColour', 'colour', array(
			'label' => 'plugins.themes.coloftech.option.accentColour.label',
			'description' => 'plugins.themes.default.option.colour.description',
			'default' => '#F7BC4A',
		));

		// Load the Montserrat and Open Sans fonts
		$this->addStyle(
			'font',
			'//fonts.googleapis.com/css?family=Montserrat:400,700|Noto+Serif:400,400i,700,700i',
			array('baseUrl' => '')
		);

		// Dequeue any fonts loaded by parent theme
		// `removeStyle` was introduced in OJS 3.0.2
		if (method_exists($this, 'removeStyle')) {
			$this->removeStyle('fontNotoSans');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSansNotoSerif');
			$this->removeStyle('fontLato');
			$this->removeStyle('fontLora');
			$this->removeStyle('fontLoraOpenSans');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
		}

		// Start with a fresh array of additionalLessVariables so that we can
		// ignore those added by the parent theme. This gets rid of @font
		// variable overrides from the typography option
		$additionalLessVariables = array();

		// Update colour based on theme option from parent theme
		if ($this->getOption('baseColour') !== '#1E6292') {
			$additionalLessVariables[] = '@bg-base:' . $this->getOption('baseColour') . ';';
			if (!$this->isColourDark($this->getOption('baseColour'))) {
				$additionalLessVariables[] = '@text-bg-base:rgba(0,0,0,0.84);';
			}
		}

		// Update accent colour based on theme option
		if ($this->getOption('accentColour') !== '#F7BC4A') {
			$additionalLessVariables[] = '@accent:' . $this->getOption('accentColour') . ';';
		}

		if ($this->getOption('baseColour') && $this->getOption('accentColour')) {
			$this->modifyStyle('stylesheet', array('addLessVariables' => join('', $additionalLessVariables)));
		}



		HookRegistry::register('TemplateManager::display', array($this, 'getActivejournal'), HOOK_SEQUENCE_NORMAL);
		HookRegistry::register('TemplateManager::display', array($this, 'getEditors'), HOOK_SEQUENCE_NORMAL);
		HookRegistry::register('TemplateManager::display', array($this, 'getmanagerial'), HOOK_SEQUENCE_NORMAL);
	}

	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.themes.coloftech.name');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return __('plugins.themes.coloftech.description');
	}

	function getActivejournal($hookName, $args){


		$smarty = $args[0];
		$template = $args[1];
		$journalId = 0;

		
		$journalInfo =& Request::getJournal();
		if($journalInfo != NULL){			
		$journalId = (int)$journalInfo->getId();
		}

		$smarty->assign('journalId',$journalId);
		
		//return $journalId;
	}
	function getActiveJournalUsers($journalId=0)
	{
		$sql = sprintf("SELECT us.user_id,us.username,us.first_name,us.last_name,uug.user_group_id,ugg.context_id,ugg.role_id,ugs.setting_value FROM users AS us LEFT JOIN user_user_groups AS uug ON uug.user_id = us.user_id LEFT JOIN user_groups AS ugg ON ugg.user_group_id = uug.user_group_id LEFT JOIN user_group_settings AS ugs ON ugs.user_group_id = ugg.user_group_id WHERE ugs.setting_name = 'name'");
	}


	function getEditors($hookName, $args){


		$journalId = 0;
		$journalInfo =& Request::getJournal();
		if($journalInfo != NULL){			
		$journalId = (int)$journalInfo->getId();
		}


		$smarty = $args[0];
		$template = $args[1];

	$sql = sprintf("SELECT us.user_id,us.username,us.first_name,us.last_name,ugs.setting_value FROM users AS us LEFT JOIN user_user_groups AS uug ON uug.user_id = us.user_id LEFT JOIN user_groups AS ugg ON ugg.user_group_id = uug.user_group_id LEFT JOIN user_group_settings AS ugs ON ugs.user_group_id = ugg.user_group_id WHERE ugg.context_id = %d AND ugs.setting_name = 'name' AND ugg.user_group_id = 3 and us.user_id <> 1 OR ugg.context_id = %d AND ugs.setting_name = 'name' AND ugg.user_group_id = 5 and us.user_id <> 1 GROUP BY us.user_id",$journalId,$journalId);
		
		/* database connection parser*/
		$config = parse_ini_file("config.inc.php");
		$host = $config['host'];
		$user = $config['username'];
		$pass = $config['password'];
		$db = $config['name'];

		/* i create my own connection because i can't find how i can connect to the database*/
		/* database connection parser*/

		$conn = new Mysqli($host, $user, $pass, $db);		
		$result = $conn->query($sql);
		
		if($result->num_rows > 0){

		$smarty->assign('editorCount',$result->num_rows);


		$editorialteam = array();
		while($row = $result->fetch_assoc()) {
        	$editorialteam[] = $row;
    		}
    	$i = 0;$j=3;
    	$html = '';
    	$count = count($editorialteam) - 1;


    	foreach ($editorialteam as $key) {
    		
    		if ($j == 3) {

    			if ($i == 0) {
    			$html .= "<div class='item active'><div class='row'>";
    			}else{

    			$html .= "<div class='item '><div class='row'>";
    			}
    		}
    		if ($j > 0 ) {

    			$html .= '
    			<div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="../../plugins/themes/coloftech/images/um.png" class="img-responsive" alt="a" />
                                </div>

                                <div class="info">

                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h5>
                                                '.$key['username'].'</h5>
                                            <h5 class="price-text-color">
                                                '.$key['setting_value'].'</h5>
                                        </div>
                                    </div>

                                    <div class="separator clear-left">
                                        
                                        <p class="btn-add">
                                            <i class="fa fa-list"></i><a href="https://github.com/coloftech/coloftechThemePlugin" class="hidden-sm">Details</a></p>

                                    </div>
                                    <div class="clearfix">
                                    </div>


                                </div>

                            </div>
                  </div>
                  ';
    		}


    		if ($j == 1 || $i == $count) {
    			$html .= "</div></div>";
    		}


    		

    		$j--;

    		if ($j <=0) {
    			$j = 3;
    		}
    		$i++;
    	}

    	$html .= '';
		$smarty->assign('editorialdata',$html);

		$smarty->assign('editorialteam',$editorialteam);

		}else{

		$smarty->assign('editorCount',0);
		$smarty->assign('editorialteam',$editorialteam);
		}

		$conn->close();

		

	}


	function getmanagerial($hookName, $args){


		$journalId = 0;
		$journalInfo =& Request::getJournal();
		if($journalInfo != NULL){			
		$journalId = (int)$journalInfo->getId();
		}


		$smarty = $args[0];
		$template = $args[1];

	$sql = sprintf("SELECT us.user_id,us.username,us.first_name,us.last_name,ugs.setting_value FROM users AS us LEFT JOIN user_user_groups AS uug ON uug.user_id = us.user_id LEFT JOIN user_groups AS ugg ON ugg.user_group_id = uug.user_group_id LEFT JOIN user_group_settings AS ugs ON ugs.user_group_id = ugg.user_group_id WHERE ugg.context_id = %d AND ugs.setting_name = 'name' AND ugg.user_group_id = 7 and us.user_id <> 1 OR ugg.context_id = %d AND ugs.setting_name = 'name' AND ugg.user_group_id = 11 and us.user_id <> 1  OR ugg.context_id = %d AND ugs.setting_name = 'name' AND ugg.user_group_id = 13 and us.user_id <> 1 GROUP BY us.user_id",$journalId,$journalId,$journalId);
		
		/* database connection parser*/
		$config = parse_ini_file("config.inc.php");
		$host = $config['host'];
		$user = $config['username'];
		$pass = $config['password'];
		$db = $config['name'];

		/* i create my own connection because i can't find how i can connect to the database*/
		/* database connection parser*/

		$conn = new Mysqli($host, $user, $pass, $db);		
		$result = $conn->query($sql);
		
		if($result->num_rows > 0){

		$smarty->assign('managementCount',$result->num_rows);


		$managementteam = array();
		while($row = $result->fetch_assoc()) {
        	$managementteam[] = $row;
    		}
    	$i = 0;$j=4;
    	$html = '';
    	$count = count($managementteam) - 1;


    	foreach ($managementteam as $key) {
    		
    		if ($j == 4) {

    			if ($i == 0) {
    			$html .= "<div class='item active'><div class='row'>";
    			}else{

    			$html .= "<div class='item '><div class='row'>";
    			}
    		}
    		if ($j > 0 ) {

    			$html .= '
    			<div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="../../plugins/themes/coloftech/images/um.png" class="img-responsive" alt="a" />
                                </div>

                                <div class="info">

                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h5>
                                                '.$key['username'].'</h5>
                                            <h5 class="price-text-color">
                                                '.$key['setting_value'].'</h5>
                                        </div>
                                    </div>

                                    <div class="separator clear-left">
                                        
                                        <p class="btn-add">
                                            <i class="fa fa-list"></i><a href="https://github.com/coloftech/coloftechThemePlugin" class="hidden-sm">Details</a></p>

                                    </div>
                                    <div class="clearfix">
                                    </div>


                                </div>

                            </div>
                  </div>
                  ';
    		}


    		if ($j == 1 || $i == $count) {
    			$html .= "</div></div>";
    		}


    		

    		$j--;

    		if ($j <=0) {
    			$j = 4;
    		}
    		$i++;
    	}

    	$html .= '';
		$smarty->assign('managementdata',$html);

		$smarty->assign('managementteam',$managementteam);

		}else{

		$smarty->assign('managementCount',0);
		$smarty->assign('managementteam',$managementteam);
		}

		$conn->close();

		

	}


	function getProfileImg($userId=0)
	{
		$sql = sprintf("SELECT us.user_id,uss.setting_value FROM users AS us LEFT JOIN user_settings AS uss ON uss.user_id = us.user_id WHERE uss.setting_name = 'profileImage'");


	}
}
?>
