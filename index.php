<?php
/*
 * Example use 
 */
require_once('lib/Naivecoin.php');
$naivecoin = new Naivecoin('domaine.ndd', '3001');
//272d471b24240423c0d5ab615ed939668f4aa043163f80dc1fc58d44a871890a
//Get latest block 
//$b1 = $naivecoin->createWallet("azertyuiop1");
//$b2 = $naivecoin->createAddress('azertyuiop1', $b1['id']);
//print_r($b1);
//print_r($b2);
//print_r($naivecoin->getWalletById($b1['id']));
print_r($naivecoin->getBalance('201c6f81d5a77bf6b3123b802a8d6b9ad4afca4282f62a94d48e8d45ff47bb21'));

$w = $naivecoin->withdrawal("7d1856cdeb03d91286945aaa78e00e62a0f0c6922620ff608fcbf0c4317c933d", 
	'azertyuiop1',
	"201c6f81d5a77bf6b3123b802a8d6b9ad4afca4282f62a94d48e8d45ff47bb21",
	"3d40013ce4fe837cbd871088b04f04dabee5d019e7948e2b719f6cd752350e81", 
	rand(10000,100000000));


print_r($w);


//print_r($naivecoin->getAllWallets());



