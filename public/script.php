<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require '../src/modeles/PdoGsb.php';
use Modeles\PdoGsb;
use Outils\Utilitaires;

require '../vendor/autoload.php';
require '../config/define.php';

$pdo = PdoGsb::getpdoGsb();
$pdo ->setMdpVisiteur();
$pdo ->setMdpComptable();
?>
