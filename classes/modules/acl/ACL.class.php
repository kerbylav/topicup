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

class PluginTopicup_ModuleACL extends PluginTopicup_Inherit_ModuleACL
{
    function UserCanUpTopic($oUser, $oTopic, $bBriefCheck = false)
    {
        if (is_numeric($oTopic))
            $oTopic = $this->Topic_GetTopicById($oTopic);

        if (!$oUser || !$oTopic)
            return $this->Lang_Get('not_access');

        /*        if ($oUser->isAdministrator())
                    return true;*/

        if (in_array($oUser->getLogin(), Config::Get('plugin.topicup.super_uppers')))
            return true;

        if (Config::Get('plugin.topicup.min_up_period')) {
            if (strtotime('-' . Config::Get('plugin.topicup.min_up_period') . ' second', time()) < strtotime($oTopic->getDateUp()))
                return $this->Lang_Get('plugin.topicup.err_min_up_period');
        }

        if (Config::Get('plugin.topicup.min_user_rating') !== false) {
            if ($oUser->getRating() < Config::Get('plugin.topicup.min_user_rating'))
                return $this->Lang_Get('plugin.topicup.err_min_user_rating', array('rating' => Config::Get('plugin.topicup.min_user_rating')));
        }

        if (Config::Get('plugin.topicup.min_topic_rating') !== false) {
            if ($oTopic->getRating() < Config::Get('plugin.topicup.min_topic_rating'))
                return $this->Lang_Get('plugin.topicup.err_min_topic_rating', array('rating' => Config::Get('plugin.topicup.min_topic_rating')));
        }

        if (Config::Get('plugin.topicup.max_count_per_period')) {
            $aFilter = array(
                'user_id' => $oUser->getId(),
                'date_up >' => date("Y-m-d H:i:s", strtotime('-' . Config::Get('plugin.topicup.min_up_period') . ' second', time())),
                '#page' => array(1, 0)
            );
            $aData = $this->PluginTopicup_Topicup_GetDataItemsByFilter($aFilter);
            if ($aData['count'] >= Config::Get('plugin.topicup.max_count_per_period')) {
                return $this->Lang_Get('plugin.topicup.err_max_count_per_period', array('rating' => Config::Get('plugin.topicup.max_count_per_period')));
            }
        }

        return true;
    }
}

?>