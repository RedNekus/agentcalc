<?php
/**
 * View file for responding to Ajax request for performing Search Here on the map
 * 
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AgentcalcViewAgentcalc extends JViewLegacy {
    protected $items;

    function display($tpl = null): void
    {
        $this->items = $this->get('CompanyRates');
        echo $this->loadTemplate('json');
    }
}