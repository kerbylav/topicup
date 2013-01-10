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


class PluginTopicup_ModuleTopicup extends ModuleORM
{

    protected $oMapper;

    /**
     * Инициализация модуля
     */
    public function Init()
    {
        parent::Init();
        $this->oMapper=Engine::GetMapper(__CLASS__);
    }


    public function GetExcludedTopics($iUserId)
    {
        $ck="topicup_excluded_topics_{$iUserId}";
        if (false === ($data=$this->Cache_Get($ck)))
        {
            $data=$this->oMapper->GetExcludedTopics($iUserId);
            $this->Cache_Set($data, $ck, array(
            ), 60 * 60 * 24 * 3);
        }

        return $data;
    }
}
?>
