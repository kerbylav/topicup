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

class PluginTopicup_ModuleTopic extends PluginTopicup_Inherit_ModuleTopic
{
    public function GetTopicsByFilter($aFilter, $iPage = 1, $iPerPage = 10, $aAllowData = null)
    {
        $oUser = $this->User_GetUserCurrent();
        if ($oUser)
        {
            $aExclude = $this->PluginTopicup_Topicup_GetExcludedTopics($oUser->getId());
            if (count($aExclude) > 0)
                $aFilter['exclude_topics'] = $aExclude;
        }

        return parent::GetTopicsByFilter($aFilter, $iPage, $iPerPage, $aAllowData);
    }
}