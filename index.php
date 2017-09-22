<?php
require_once('./autoload.php');

use Openstack\Identity\V3\Identity;

$M = new Identity();

$res = $M->auth(['name'=>'demo','password'=>'dandan123','all'=>1]);

print_r($res);

?>