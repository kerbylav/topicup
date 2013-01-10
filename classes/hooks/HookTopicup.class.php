<?php
/*-------------------------------------------------------
*
*   kEditComment.
*   Copyright © 2012 Alexei Lukin
*
*--------------------------------------------------------
*
*   Official site: http://kerbystudio.ru
*   Contact e-mail: kerby@kerbystudio.ru
*
---------------------------------------------------------
*/

class PluginTopicup_HookTopicup extends Hook
{

    protected $oUserCurrent;

    public function RegisterHook()
    {
        if (!$this->User_GetUserCurrent())
            return;

        $this->AddHook('template_topic_show_info', 'InjectTopicupLink');
        $this->AddHook('template_profile_sidebar_menu_item_last', 'IncludeMenuProfile');
    }

    public function InjectTopicupLink($aParam)
    {
        $this->oUserCurrent = $this->User_GetUserCurrent();

        $oTopic=$aParam['topic'];
        $this->Viewer_Assign('oTopic', $oTopic);
        $this->Viewer_Assign('iTopicId', $oTopic->getId());
        
        $res=$this->Viewer_Fetch(PluginTopicup::GetTemplateFilePath(__CLASS__, 'inject_topicup_link_exclude.tpl'));

        if ($this->ACL_UserCanUpTopic($this->oUserCurrent, $oTopic) !== true)
            return $res;

        $this->Viewer_Assign('oUser', $this->oUserCurrent);
        return $this->Viewer_Fetch(PluginTopicup::GetTemplateFilePath(__CLASS__, 'inject_topicup_link.tpl')).$res;
    }

    protected function PrepareMenu()
    {

    }

    public function IncludeMenuProfile()
    {
        $this->PrepareMenu();
        return $this->Viewer_Fetch(PluginTopicup::GetTemplateFilePath(__CLASS__, 'inject_menu_profile.tpl'));
    }

}

?>