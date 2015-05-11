<?php

if (!isset($argv[2]) OR !isset($argv[1]))  {
  die("Usage: vedge.php <file> <acl or nat>\n");
}

require("coreDecode.php");

// Going to output as a CSV for import into spreadsheets

if ($argv[2] == "acl") {

echo "Rule Number,Enabled,Description,Policy,Protocol,Port,Source,Destination,Logging Enabled";
echo "\n";

// vEdge ACLs

foreach ($array[0]["Configuration"]["EdgeGatewayServiceConfiguration"]["FirewallService"]["FirewallRule"] as $key=>$value) {
  echo $value["Id"].","; // Rule Number
  echo $value["IsEnabled"].","; // Enabled
  echo $value["Description"].","; // Description
  echo $value["Policy"].","; // Policy

  // Protocol
  //
  // TCP/UDP
  if (isset($value["Protocols"]["Tcp"]) AND isset($value["Protocols"]["Udp"])) {
        echo "TCP/UDP,";
  }
  // ICMP
  else if (isset($value["Protocols"]["Icmp"])) {
    echo "ICMP,";
  }
  // TCP
  else if (isset($value["Protocols"]["Tcp"])) {
    echo "TCP,";
  }
  // UDP
  else if (isset($value["Protocols"]["Udp"])) {
    echo "UDP,";
  }
  // ANY
  else if (isset($value["Protocols"]["Any"])) {
    echo "Any,";
  }
  // ERROR
  else
    echo "ERROR,";

  // Port
  if (isset($value["Protocols"]["Icmp"])) {
    echo "ICMP,";
  }
  else if ($value["Port"] == "-1") { 
    echo "Any,";
  } else
  echo $value["Port"].",";

  echo $value["SourceIp"].","; // Source
  echo $value["DestinationIp"].","; // Destination
  echo $value["EnableLogging"]; // Logging Enabled

  echo "\n";
  }

}

// vEdge NAT Rules

if ($argv[2] == "nat") {

  echo "NAT Type,Original,Translated";
  echo "\n";

  foreach ($array[0]["Configuration"]["EdgeGatewayServiceConfiguration"]["NatService"]["NatRule"] as $key=>$value) {
    echo $value["RuleType"].","; 
    echo $value["GatewayNatRule"]["OriginalIp"].",";
    echo $value["GatewayNatRule"]["TranslatedIp"];
    echo "\n";
  }

}
