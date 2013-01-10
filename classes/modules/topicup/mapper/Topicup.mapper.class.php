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


class PluginTopicup_ModuleTopicup_MapperTopicup extends Mapper
{

    public function GetExcludedTopics($iUserId)
    {
        $sql = "SELECT t.topic_id FROM " . MapperORM::GetTableName(Engine::GetEntity('PluginTopicup_ModuleTopicup_EntityExclude')) . " as t WHERE t.user_id=?d";
        $aTopics = array();
        if ($aRows = $this->oDb->select($sql, $iUserId))
        {
            foreach ($aRows as $aTopic)
            {
                $aTopics[] = $aTopic['topic_id'];
            }
        }

        return $aTopics;
    }
}

?>