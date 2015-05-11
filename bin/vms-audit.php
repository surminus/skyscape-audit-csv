<?php

// Use the vcloud-tools JSON output from "vcloud-walk vdcs" to 
// audit VM details used across environments in basic csv

require("coreDecode.php");

echo "vApp,Name,CPUs,Memory,Disks,,,,,,,IPs\n";

foreach ($array[0]["vapps"] as $ValueVapp) {

  echo $ValueVapp["name"].", , ,\n";
  
  foreach ($ValueVapp["vms"] as $ValueVM) {

    echo " ,".$ValueVM["name"].",";
  
    $ValueCPU = str_replace("virtual CPU(s)", "", $ValueVM["cpu"]);
      echo $ValueCPU.",";

    $ValueMem = str_replace("MB of memory", "", $ValueVM["memory"]);
      echo $ValueMem / 1024;
      echo ",";

    $count = 0;
    foreach ($ValueVM["disks"] as $ValueDisks) {
      echo $ValueDisks["size"] / 1024;
      echo ",";
      $count++;
    }
    while ($count < 7) {
      echo ","; // For consistent CSV output
      $count++;
    }

    foreach ($ValueVM["network_connections"] as $ValueNetworks) {
      if ( isset($ValueNetworks["IpAddress"]) ) {
      echo $ValueNetworks["IpAddress"].",";
      }
    }
  echo "\n";
  }

}



