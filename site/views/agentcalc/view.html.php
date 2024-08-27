<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use \Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

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
        $user = Factory::getApplication()->getIdentity();
        $customFields = FieldsHelper::getFields('com_users.user',$user, true);
        $values = array_column($customFields, 'rawvalue', 'name');
        $this->company = $values['company'];
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