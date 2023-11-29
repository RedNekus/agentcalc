<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Document\Document;

defined('_JEXEC') or exit();

class AgentcalcViewAagentcalc extends JViewLegacy {
    public function display($tpl = null):void
    {
        $app = Factory::getApplication();
        $wa = $app->getDocument()->getWebAssetManager();

        if (!$wa->assetExists('script', 'keyselectmodal'))
        {
            parent::display($tpl);;
        }
    }
}