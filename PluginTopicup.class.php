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

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin'))
{
    die('Hacking attempt!');
}

class PluginTopicup extends Plugin
{

    protected $aInherits=array('module'=>array('ModuleTopic','ModuleACL'),'action'=>array('ActionAjax'),'mapper'=>array('ModuleTopic_MapperTopic'));


    public function Activate()
    {
        if (!$this->isTableExists('prefix_topicup_data'))
        {
            $this->ExportSQL(dirname(__FILE__) . '/install.sql');
        }
        return true;
    }

    public function Deactivate()
    {
        return true;
    }

    /**
	 * Инициализация плагина
	 */
    public function Init()
    {
        $this->Viewer_AppendScript(PluginTopicup::GetTemplateFilePath(__CLASS__,'js/script.js'));
        $this->Viewer_AppendStyle(PluginTopicup::GetTemplateFilePath(__CLASS__,'css/style.css'));
    }

    public function GetTemplateFilePath($sPluginClass,$sFileName)
    {
        $sPP=Plugin::GetTemplatePath($sPluginClass);
        $fName=$sPP . $sFileName;
        if (file_exists($fName))
            return $fName;
        
        $aa=explode("/", $sPP);
        array_pop($aa);
        array_pop($aa);
        $aa[]='default';
        $aa[]='';
        return join("/", $aa) . $sFileName;
    }

    public function GetTemplateFileWebPath($sPluginClass,$sFileName)
    {
        return str_replace(Config::Get('path.root.server'), Config::Get('path.root.web'), $this->GetTemplateFilePath($sPluginClass, $sFileName));
    }

}


?>