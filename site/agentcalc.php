<?php
defined('_JEXEC') or exit();
try {
    $controller = JControllerLegacy::getInstance('Agentcalc');
} catch (Exception $e) {
    echo "Controller error: ". $e->getMessage();
}
try {
    $input = JFactory::getApplication()->input;
} catch (Exception $e) {
    echo "Application error: ". $e->getMessage();
}
if( isset($controller) && isset($input) ) {
    try {
        $task = $input->get('task', 'display');

        $controller->execute($task);
    } catch (Exception $e) {
        echo "Execute error: ". $e->getMessage();
    }
    $controller->redirect();
}
