<?php
defined('_JEXEC') or exit();

try {
    $controller = JControllerLegacy::getInstance('Agentcalc');
} catch (Exception $e) {
}
try {
    $input = JFactory::getApplication()->input;
} catch (Exception $e) {
}

try {
    $controller->execute($input->get('task', 'display'));
} catch (Exception $e) {
}
$controller->redirect();