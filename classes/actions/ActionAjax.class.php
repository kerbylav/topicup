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

class PluginTopicup_ActionAjax extends PluginTopicup_Inherit_ActionAjax
{

    protected function RegisterEvent()
    {
        $this->AddEvent('topicup-up', 'EventTopicupUp');
        parent::RegisterEvent();
    }

    protected function EventTopicupUp()
    {
        /**
         * Устанавливаем формат Ajax ответа
         */
        $this->Viewer_SetResponseAjax('json');

        if (!$this->oUserCurrent) {
            $this->Message_AddErrorSingle($this->Lang_Get('not_access'));
            return;
        }

        $oTopic = $this->Topic_GetTopicById(getRequest('id'));

        if (!$oTopic) {
            $this->Message_AddErrorSingle($this->Lang_Get('not_access'));
            return;
        }

        $sCheckResult = $this->ACL_UserCanUpTopic($this->oUserCurrent, $oTopic);
        if ($sCheckResult !== true) {
            $this->Message_AddErrorSingle($sCheckResult);
            return;
        }

        $sDE = date("Y-m-d H:i:s");
        $oTopic->setDateUp($sDE);
        if ($this->Topic_UpdateTopic($oTopic)) {
            $oData = Engine::GetEntity('PluginTopicup_ModuleTopicup_EntityData');
            $oData->setTopicId($oTopic->getId());
            $oData->setUserId($this->oUserCurrent->getId());
            $oData->setDateUp($sDE);
            if (!$oData->save())
                $this->Message_AddErrorSingle($this->Lang_Get('error'));

            $this->Message_AddNoticeSingle($this->Lang_Get('plugin.topicup.notice_upped'));
        } else
            $this->Message_AddErrorSingle($this->Lang_Get('error'));
    }

}

?>
