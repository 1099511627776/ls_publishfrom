<?php
if (! class_exists ( 'Plugin' )) {
	die ( 'Hacking attemp!' );
}

class PluginPublishfrom extends Plugin {

    protected $aInherits=array(
        'entity' => array('ModuleTopic_EntityTopic' => '_ModuleTopic_EntityTopic'),
    );
	
	public function Activate() {
		return true;
	}
	
	public function Deactivate() {
		return true;
	}
	
	public function Init() {
		//$sTemplatesUrl = Plugin::GetTemplatePath ( 'PluginWall' );
		//$this->Viewer_AppendStyle ( Plugin::GetTemplateWebPath ( 'wall' ) . 'css/wall.css' );
	}
}