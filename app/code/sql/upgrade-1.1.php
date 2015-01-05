<?php
$installer = $this;
try {
    $tablePrefix = '';
    $sql = <<<SQLTEXT


SQLTEXT;
    //$installer->run($sql);
} catch (Exception $e) {
    $installer->log($e->getMessage());
}

