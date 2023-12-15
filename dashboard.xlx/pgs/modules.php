<?php

$Result = @fopen($CallingHome['ServerURL']."?do=GetReflectorList", "r");

$INPUT = "";

if ($Result) {

	while (!feof ($Result)) {
		$INPUT .= fgets ($Result, 1024);
	}

	$XML = new ParseXML();
	$Reflectorlist = $XML->GetElement($INPUT, "reflectorlist");
	$Reflectors    = $XML->GetAllElements($Reflectorlist, "reflector");
}

fclose($Result);
?>

<table class="table table-striped table-hover text-white col-md-4">
	<tr class="table-left">
		<th class="col-md-1 text-white">Modul | Raum</th>
		<th class="col-md-1 text-white">Link-Befehl am Funkgerät</th>
		<th class="col-md-2 text-white">Information</th>

 </tr>
<?php



$Modules = $PageOptions['ModuleNames'];
$ModulesCount = count($PageOptions['ModuleNames']);
$cnt = 0;
foreach($Modules as $ModuleKey => $ModuleInfo) {
  $cnt++;
  echo "<tr><td class='text-white'>$ModuleKey</td><td class='text-white'>UR-Call: \"$ReflectorLinkName".$ModuleKey."L\"</td><td class='text-white'>$ModuleInfo</td></tr>";
}



?>

</table>
