<?php

defined('_JEXEC') or exit();

class AgentcalcTableItem extends JTable {
    function __construct(&$db)
    {
        $table = "#__agentcalc_settings";
        $key = 'id';
        parent::__construct($table, $key, $db);
    }
}