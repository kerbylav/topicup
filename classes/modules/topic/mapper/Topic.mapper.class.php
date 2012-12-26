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
        $sql="UPDATE " . Config::Get('db.table.topic') . "
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
        $iId=parent::AddTopic($oTopic);
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

    public function GetTopics($aFilter, &$iCount, $iCurrPage, $iPerPage)
    {
        if (!isset($aFilter['order']))
            $aFilter['order'] = 't.topic_date_up desc';

        return parent::GetTopics($aFilter, $iCount, $iCurrPage, $iPerPage);
    }
}

?>