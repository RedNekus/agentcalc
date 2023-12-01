<?php
/**
 * View file for responding to Ajax request for performing Search Here on the map
 * 
 */
 
// No direct access to this file
use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');

class AgentcalcViewAgentcalc extends JViewLegacy {
    protected array $items;
    
    function display($tpl = null): void
    {
        $input = Factory::getApplication()->input;
        $this->items = $this->get('Items');
        $this->data = $input->json->getArray() ?? [];
        $this->prepayment = $input->getInt('prepayment');
        echo new JResponseJson(['tbody' => $this->loadTemplate('json')] );
    }
}