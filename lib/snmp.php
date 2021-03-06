<?php
include_once("config.php");

function getSNMPSysName($ip) {
	global $snmp;
//	echo $snmp["community"];
//	echo $ip;
	return snmp_value(snmp2_get($ip->ip, $snmp["community"], "SNMPv2-MIB::sysName.0"));
}

function getSNMPSysDesc($ip) {
	global $snmp;
	return snmp_value(snmp2_get($ip->ip, $snmp["community"], "SNMPv2-MIB::sysDescr.0"));
}

function snmp_value($v){
	$i = strpos($v, ":");
	if (false !=$i){
		return trim(substr($v,$i+1));
	}
	return false;

}

/*
* pass IP to query SMMP on and host to connect these interfaces to in the DB
*/
function getInterfacesOnSNMPHost($ip, $host) {
	global $snmp;

	$ret = array();

	$addresses =  snmp2_walk ($ip->ip, $snmp["community"], "IP-MIB::ipAdEntAddr");
	$interfaceNumbers = snmp2_walk ($ip->ip, $snmp["community"], "IP-MIB::ipAdEntIfIndex");
	$netmasks = snmp2_walk ($ip->ip, $snmp["community"], "IP-MIB::ipAdEntNetMask");
	
	$interface_address =  array();
	$interface_masks =  array();

	for($i=0; $i<count($addresses);$i++){
		$interface_address[snmp_value($interfaceNumbers[$i])] = snmp_value($addresses[$i]);
		$interface_masks[snmp_value($interfaceNumbers[$i])] = snmp_value($netmasks[$i]);
	}
	var_dump($interface_address);
	var_dump($interface_masks);

	$interface_count = count($interface_address);
	echo $interface_count."\n";
	for ( $i=1; $i<=$interface_count;$i++){
		$inter = new IFace;
		$inter->host = $host->sysname;
		$name = snmp_value(snmp2_get($ip->ip, $snmp["community"], "IF-MIB::ifDescr.".$i));
//		echo ("name: ".$name."\n");
		$index = snmp_value(snmp2_get($ip->ip, $snmp["community"], "IF-MIB::ifIndex.".$i));
//		echo ("index: ".$index."\n");
		$inter->idx =  $index;
		$inter->ip = $interface_address[$index];
		$inter->name = $name;
		$inter->mask = $interface_masks[$index];

//		var_dump($inter);
		array_push($ret, $inter);
	}

	return $ret;
}

?>



