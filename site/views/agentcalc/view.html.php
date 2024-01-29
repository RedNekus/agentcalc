<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

class AgentcalcViewAgentcalc extends BaseHtmlView {
    protected $form;
    protected $calc;

    function display($tpl = null): void
    {
        if (!$this->form = $this->get('Form'))
        {
            return;
        }
        $this->calc = $this->get('Calc');
        $this->addScripts();
        parent::display($tpl);
    }

    /**
     * @throws Exception
     */
    protected function addScripts(): void
    {
        $doc = JFactory::getApplication()->getDocument();
        Joomla\CMS\HTML\HTMLHelper::_('bootstrap.framework');
        $doc->addScript(JUri::base() . 'media/com_agentcalc/js/calculate.js');
        $doc->addScript(JUri::base() . 'media/com_agentcalc/js/calculate.js');
        $doc->addStyleSheet(JURI::root() . "media/com_agentcalc/css/agentcalc.css", ['version'=>'auto']);
    }
}