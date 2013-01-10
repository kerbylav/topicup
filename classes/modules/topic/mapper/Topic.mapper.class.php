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


class PluginTopicup_ModuleTopic_MapperTopic extends PluginTopicup_Inherit_ModuleTopic_MapperTopic
{
    public function UpdateTopicupData(ModuleTopic_EntityTopic $oTopic)
    {
        $sql = "UPDATE " . Config::Get('db.table.topic') . "
        SET
        topic_date_up= ?
        WHERE
        topic_id = ?d
        ";
        if ($this->oDb->query($sql, $oTopic->getDateUp(), $oTopic->getId()) !== false)
        {
            return true;
        }
        return false;
    }

    public function AddTopic(ModuleTopic_EntityTopic $oTopic)
    {
        $iId = parent::AddTopic($oTopic);
        if ($iId)
        {
            $oTopic->setId($iId);
            $oTopic->setDateUp($oTopic->getDateAdd());

            $this->UpdateTopicupData($oTopic);
        }

        return $iId;
    }

    public function UpdateTopic(ModuleTopic_EntityTopic $oTopic)
    {
        parent::UpdateTopic($oTopic);
        return $this->UpdateTopicupData($oTopic);
    }

    protected function buildFilter($aFilter)
    {
        $sWhere = parent::buildFilter($aFilter);

        if (!isset($aFilter['ignore_excluded']))
        {
            $oEngine = Engine::GetInstance();
            if ($oUser = $oEngine->User_GetUserCurrent())
            {
                $aList = $oEngine->PluginTopicup_Topicup_GetExcludedTopics($oUser->getId());
                if (count($aList) > 0)
                    $sWhere .= " AND topic_id not in (" . join(",", $aList) . ")";
            }
        }

        if (isset($aFilter['only_include_topics']))
        {
            if (!is_array($aFilter['only_include_topics']))
                $aFilter['only_include_topics'] = array($aFilter['only_include_topics']);

            if (count($aFilter['only_include_topics']) > 0)
                $sWhere .= " AND topic_id in (" . join(",", $aFilter['only_include_topics']) . ")";
        }
        return $sWhere;
    }

    public function GetTopics($aFilter, &$iCount, $iCurrPage, $iPerPage)
    {
        if (!isset($aFilter['order']))
            $aFilter['order'] = 't.topic_date_up desc';

        return parent::GetTopics($aFilter, $iCount, $iCurrPage, $iPerPage);
    }
}

?>