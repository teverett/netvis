<?php

$db = array();
$db["servername"] = "192.168.75.75";
$db["username"]= "netvis";
$db["password"] = "netvis";
$db["dbname"] = "netvis";

$snmp = array();
$snmp["community"]="public";

$colors = array();
$colors["up-router"]="rgb(58, 132, 129)";
$colors["down-router"]="rgb(164,164,164)";
$colors["up-host"]="rgb(58, 132, 59)";
$colors["down-host"]="rgb(164,164,164)";
$colors["up-edge"]="rgb(0,0,0)";
$colors["down-edge"]="rgb(164,164,164)";

$edge_conf["width"]=1;
$node_conf["size"]=2;
$node_conf["font"]="10px";
$node_conf["router-mass"]=4;
$node_conf["host-mass"]=1;
?>
