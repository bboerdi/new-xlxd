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

<table class="table table-striped table-hover">
	<tr class="table-left">
		<th class="col-md-1">Number | Nummer</th>
		<th class="col-md-1">Module | Raum</th>
		<th class="col-md-2">Information</th>

 </tr>
<?php



$Modules = $PageOptions['ModuleNames'];
$ModulesCount = count($PageOptions['ModuleNames']);
$cnt = 0;
foreach($Modules as $ModuleKey => $ModuleInfo) {
  $cnt++;
  echo "<tr><td>#$cnt</td><td>$ModuleKey</td><td>$ModuleInfo</td></tr>";
}



?>

</table>
