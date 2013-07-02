<?php
class PluginPublishfrom_ModulePublishfrom_MapperPublishfrom extends Mapper {
    public function getUserList(){
        $users = Config::Get('plugin.publishfrom.user_logins');
        $ids = Config::Get('plugin.publishfrom.user_ids');
        $expr = Config::Get('plugin.publishfrom.user_id_expression');
        if(is_array($users)){
            foreach($users as $i=>$u)
                $logins_in .= ($i == 0?'':',')."'$u'";
        }
        if($expr){
            $expr = explode("-",$expr);
            $s = $expr[0]; $e = $expr[1];
            while($s <= $e) {
                $ids[] = $s++;
            }
        }       
        if(is_array($ids)){
            foreach($ids as $i=>$u)
                $ids_in .= ($i == 0?'':',').$u;
        }
        if($logins_in||$ids_in){
            $or = ($logins_in&&$ids_in?' OR ':'');
            $sql = "SELECT 
                        u.*,
                        ua.user_id as 'user_admin'
                    FROM ".Config::Get('db.table.user')." u
                        LEFT OUTER JOIN ".Config::Get('db.table.user_administrator')." ua ON ua.user_id = u.user_id
                    WHERE 1=1 ";
            if($rating = Config::Get('plugin.publishfrom.limit_rating_min')){
                $sql .= "AND user_rating > ".intval($rating);
            }               
            $sql .= " AND ".($logins_in?"u.user_login IN ($logins_in)":'').$or.($ids_in?"u.user_id IN ($ids_in)":'');
            return $this->oDb->select($sql);
        }
        return array();
    }
    
    public function UpdateTopic($oTopic,$oUser = null,$isEdit = false) {        
        $sql = '';
        if($oUser){
            $sql = "UPDATE ".Config::Get('db.table.topic')." SET ";
            if(!$isEdit){
                $sql .= "real_user_id = ?d";
            } else {
                $sql .= "last_edit_user_id = ?d";
            }
            $sql .="    WHERE
                        topic_id = ?d";         
            if ($this->oDb->query($sql,
                        $oUser->getId(),
                        
                        $oTopic->getId())) {
                return true;
            }       
        } else {
            $sql = "UPDATE ".Config::Get('db.table.topic')." 
                SET 
                    user_id= ?d,
                    blog_id= ?d
                WHERE
                    topic_id = ?d
            ";          
            if ($this->oDb->query($sql,
                        $oTopic->getUserId(),
                        $oTopic->getBlogId(),                       
                        $oTopic->getId())) {
                return true;
            }       
        }
        return false;
    }   
}