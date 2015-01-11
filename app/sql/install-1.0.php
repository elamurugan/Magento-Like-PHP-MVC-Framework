<?php
$installer = $this;
try {
    $tablePrefix = '';
    $sql = <<<SQLTEXT
CREATE TABLE IF NOT EXISTS `{{$tablePrefix}}config` (
`id` int(12) NOT NULL,
  `path` varchar(512) NOT NULL,
  `value` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

SQLTEXT;

    $installer->run($sql);
} catch (Exception $e) {
    $installer->log($e->getMessage());
}

