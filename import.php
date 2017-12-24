<?php

include 'system/autoloader.php';

use Models\Network,
    Models\Agency,
    Models\Bill;

$imp = new Importer();

$data = $imp->proced("data/agency_network.txt");
foreach($data AS $arRow)
    Network::getRepository()->save(new Network($arRow));

$data = $imp->proced("data/agency.txt");
//print_r($data);
foreach($data AS $arRow)
    Agency::getRepository()->save(new Agency($arRow));

$data = $imp->proced("data/billing.txt");
print_r($data);
foreach($data AS $arRow)
    Bill::getRepository()->save(new Bill($arRow));






/*$newUser = new User(Array(
 'username' => "1",
 'firstname' => "1",
 'lastname' => "1",
 'email' => "1",
 ));
 User::getRepo()->save($newUser);*/
