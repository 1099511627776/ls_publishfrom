<?php

class PluginPublishfrom_ModuleTopic_EntityTopic extends PluginPublishfrom_Inherit_ModuleTopic_EntityTopic
{
    public function Init(){
    	parent::Init();
    }
	
	public function getAddedUserId(){
		dump($this->_aData);
		return $this->_aData['real_user_id'];
	}

	public function getLastEditUserId(){
		return $this->_aData['last_edit_user_id'];
	}

	public function getAddedUser() {
		if (!$this->_getDataOne('added_user')) {
			$this->_aData['added_user']=$this->User_GetUserById($this->getAddedUserId());
		}
		return $this->_getDataOne('added_user');
	}

	public function getLastEditUser() {
		if (!$this->_getDataOne('ledit_user')) {
			$this->_aData['ledit_user']=$this->User_GetUserById($this->getLastEditUserId());
		}
		return $this->_getDataOne('ledit_user');
	}

}

?>
