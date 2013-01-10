<?php
/*-------------------------------------------------------
*
*   Topic Up.
*   Copyright © 2012 Alexei Lukin
*
*--------------------------------------------------------
*
*   Official site: http://kerbystudio.ru
*   Contact e-mail: kerby@kerbystudio.ru
*
---------------------------------------------------------
*/

class PluginTopicup_ActionProfile extends PluginTopicup_Inherit_ActionProfile
{

    protected function RegisterEvent()
    {
        parent::RegisterEvent();
        $this->AddEventPreg('/^.+$/i','/^excludedtopics/i','/^(page([1-9]\d{0,5}))?$/i','EventExcludedTopics');
    }

    protected function EventExcludedTopics()
    {
        if (!$this->oUserCurrent)
        {
            return parent::EventNotFound();
        }

        /**
         * Получаем логин из УРЛа
         */
        $sUserLogin=$this->sCurrentEvent;

        /**
         * Проверяем есть ли такой юзер
         */
        if (!($this->oUserProfile=$this->User_GetUserByLogin($sUserLogin)))
        {
            return parent::EventNotFound();
        }

        if ($this->oUserProfile->getId() != $this->oUserCurrent->getId())
        {
            return parent::EventNotFound();
        }

        $iPage=$this->GetParamEventMatch(1, 2)?$this->GetParamEventMatch(1, 2):1;

        $this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.topicup.menu_excludedtopics_title'));

        /**
         * Получаем список топиков
         */
        $aResult=$this->Topic_GetTopicsByFilter(array('ignore_excluded'=>true,'only_include_topics'=>$this->PluginTopicup_Topicup_GetExcludedTopics($this->oUserProfile->getId())),$iPage,Config::Get('module.topic.per_page'));
        $aTopics=$aResult['collection'];
        /**
         * Вызов хуков
         */
        $this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
        /**
         * Формируем постраничность
         */
        $aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),$this->oUserProfile->getUserWebPath().'excludedtopics/');
        /**
         * Загружаем переменные в шаблон
         */
        $this->Viewer_Assign('aPaging',$aPaging);
        $this->Viewer_Assign('aTopics',$aTopics);
        $this->Viewer_Assign('bExcludedTopics',true);


        $this->SetTemplate(PluginTopicup::GetTemplateFilePath(__CLASS__, 'actions/ActionProfile/excludedtopics.tpl'));
    }

    public function EventShutdown()
    {
        parent::EventShutdown();

        if (!$this->oUserProfile)
        {
            return;
        }

        $this->Viewer_Assign('iExcludedTopics',count($this->PluginTopicup_Topicup_GetExcludedTopics($this->oUserProfile->getId())));
    }
}
?>