<?php

require("./falconide.php");
require("./email.php");
require("./row.php");

$falconide = new Falconide("<API KEY>");

$email = new Email();
$email->setFrom("testing@m3m.in");
$email->setFromname("Sachin Vernekar");
$email->setReplytoid("vernekar.sachin21@gmail.com");
$email->setSubject("Proje Teklifi Haftalık Bülten");
$email->setContent(" ");
/* Optional Settings */

$email->setFooter("1");
$email->setUnsubscribe("1");
$email->setOpentrack("1");
$email->setClicktrack("1");
#$email->setCC("vernekar.sachin21@gmail.com");
$email->setXAPIheaders("AST");
$email->addAttribute("Name", "Sachin");
$email->addAttribute("Name", "Alok");
$email->addAttribute("City", "Mumbai");
$email->addAttribute("City", "Delhi");
$email->setTemplateid('3048');
$email->addRecipients("vernekar.sachin21@gmail.com");
$email->addRecipients("sachin.vernekar@netcore.co.in");
#$email->addAttachment("/home/sachin/Desktop/test.html");

$table1 = new Table();
$row1 = new Row("room");
$row1->addData("id",1);
$row1->addData("name","sachin");
$row1->addData("age","22");
$row1->setData();

$row1->addData("id",2);
$row1->addData("name","ets");
$row1->addData("age","25");
$row1->setData();

$row2 = new Row("rooms");
$row2->addData("id",2);
$row2->addData("name","hello");
$row2->addData("age","24");
$row2->setData();

$table1->add($row1);
$table1->add($row2);

$table2 = new Table();
$row1 = new Row("room");
$row1->addData("id",1);
$row1->addData("name","sachin");
$row1->addData("age","22");
$row1->setData();

$row2 = new Row("rooms");
$row2->addData("id",2);
$row2->addData("name","hello");
$row2->addData("age","56");
$row2->setData();

$table2->add($row1);
$table2->add($row2);

$email->addTrigData($table1);
$email->addTrigData($table2);

$falconide->sendmail($email);
?>
