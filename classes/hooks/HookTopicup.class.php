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
    }

    public function InjectTopicupLink($aParam)
    {
        $this->oUserCurrent = $this->User_GetUserCurrent();

        if ($this->ACL_UserCanUpTopic($this->oUserCurrent, $aParam['topic']) !== true)
            return;

        $this->Viewer_Assign('oUser', $this->oUserCurrent);
        $this->Viewer_Assign('oTopic', $aParam['topic']);
        $this->Viewer_Assign('iTopicId', $aParam['topic']->getId());
        return $this->Viewer_Fetch(PluginTopicup::GetTemplateFilePath(__CLASS__, 'inject_topicup_link.tpl'));
    }
}

?>