<?php
function sort_profile($a,$b){
	return $a['user_profile_name'] > $b['user_profile_name'];
}

class PluginPublishfrom_HookPublishfrom extends Hook {
	public function RegisterHook() {	
		$this->AddHook('topic_add_after','topic_after');
		$this->AddHook('topic_edit_after','topic_after');
		$this->AddHook('topic_add_after','topic_add_after_userid');
		$this->AddHook('topic_edit_after','topic_edit_after_userid');
		$this->AddHook('template_form_add_topic_topic_end','template_form_add_topic_topic_end');
		$this->AddHook('template_form_add_topic_link_end','template_form_add_topic_topic_end');
		$this->AddHook('template_form_add_topic_question_end','template_form_add_topic_topic_end');
		$this->AddHook('template_form_add_topic_photoset_end','template_form_add_topic_topic_end');
		
		$this->AddHook('template_publishfrom_theme_select','publishfrom_theme_select');
	}
	
	public function topic_add_after_userid($arg){
		$oTopic = $arg['oTopic'];
		$oBlog = $arg['oBlog'];
		$oUser = $this->User_GetUserCurrent();
		//if($oUser->isAdministrator()){
			$this->PluginPublishfrom_Publishfrom_UpdateTopic($oTopic,$oUser,false);			
		//}
	}
	public function topic_edit_after_userid($arg){
		$oTopic = $arg['oTopic'];
		$oBlog = $arg['oBlog'];
		$oUser = $this->User_GetUserCurrent();
		//if($oUser->isAdministrator()){
			$this->PluginPublishfrom_Publishfrom_UpdateTopic($oTopic,$oUser,true);			
		//}
	}

	public function topic_after($arg){
		$oTopic = $arg['oTopic'];
		$oBlog = $arg['oBlog'];
		if($oUser = $this->User_GetUserCurrent()) {
			if($oUser->isAdministrator()){
				$uid = getRequest(Config::Get('plugin.publishfrom.select_name'));
				if(!$uid)
					$uid = $oUser->getId();
				$oTopic = $this->Topic_GetTopicById($oTopic->getId());
				if($oBlog && $oBlog->getType() == 'personal'){
					if($oTopic->getPublish()){
						$oBlogNew = $this->Blog_GetPersonalBlogByUserId($uid);
						$oTopic->setBlog($oBlogNew);
						$oTopic->setBlogId($oBlogNew->getId());
					}
				}		
				$oTopic->setUser($this->User_GetUserById($uid));			
				$oTopic->setUserId($uid);
				//$this->Logger_SetFileName(Config::Get('sys.logs.file'));
				//$this->Logger_Notice('before::'.$uid."::".$oTopic->getUser()->getLogin());
				//$this->Topic_UpdateTopic($oTopic);
				$this->PluginPublishfrom_Publishfrom_UpdateTopic($oTopic);			
				//$oTopic = $this->Topic_GetTopicById($oTopic->getId());
				//$this->Logger_Notice('after::'.$uid."::".$oTopic->getUser()->getLogin());
			}
		};
	}
	
	public function template_form_add_topic_topic_end(){
		if($this->User_GetUserCurrent()->isAdministrator()){
			$aUserList = $this->PluginPublishfrom_Publishfrom_GetUserList();
			usort($aUserList,"sort_profile");
			dump($aUserList);
			$oUserCurrent = $this->User_GetUserCurrent();
			$this->Viewer_Assign("oUserCurrent",$oUserCurrent);
			$this->Viewer_Assign("sSelectName",Config::Get('plugin.publishfrom.select_name'));
			$this->Viewer_Assign("aUserList",$aUserList);
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'form_select.tpl');			
		}
	}
}