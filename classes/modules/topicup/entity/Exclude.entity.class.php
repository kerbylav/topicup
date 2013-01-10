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


class PluginTopicup_ModuleTopicup_EntityExclude extends EntityORM
{
    protected $aRelations=array(
        'user'=>array('belongs_to', 'ModuleUser_EntityUser', 'user_id'),
        'topic'=>array('belongs_to', 'ModuleTopic_EntityTopic', 'topic_id'),
    );

}
?>
