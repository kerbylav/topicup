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


class PluginTopicup_ModuleUser_EntityUser extends PluginTopicup_Inherit_ModuleUser_EntityUser
{
    /**
     * Возвращает дату поднятия топика
     *
     * @return string|null
     */
    public function getDateUp() {
        $d=$this->_getDataOne('topic_date_up');
        return $d?$d:$this->getDateAdd();
    }

    /**
     * Устанавливает дату поднятия топика
     *
     * @param string $data
     */
    public function setDateUp($data) {
        $this->_aData['topic_date_up']=$data;
    }
}

?>