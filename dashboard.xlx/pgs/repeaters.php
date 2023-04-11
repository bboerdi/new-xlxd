<table class="table table-sm table-dark table-striped table-hover text-white">
	<tr class="table-center">
		<th class="col-md-1">#</th>
		<th class="col-md-1">Land</th>
		<th class="col-md-2">DV Station</th>
		<th class="col-md-1">Band</th>
		<th class="col-md-2">Zuletzt geh&ouml;rt</th>
		<th class="col-md-2">Verbunden seit</th>
		<th class="col-md-1">Protokoll</th>
		<th class="col-md-1">Module</th><?php

if ($PageOptions['RepeatersPage']['IPModus'] != 'HideIP') {
	echo '
	<th class="col-md-1">IP</th>';
}

?>
		</tr>
<?php
$Reflector->LoadFlags();

for ($i=0;$i<$Reflector->NodeCount();$i++) {

	echo '<tr class="table-center">
	<td>'.($i+1).'</td>
	<td>';
	list ($Flag, $Name) = $Reflector->GetFlag($Reflector->Nodes[$i]->GetCallSign());
	if (file_exists("./img/flags/".$Flag.".png")) {
		echo '<a href="#" class="ps-1 nav-link" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="' . $Name . '"><img src="./img/flags/' . $Flag . '.png" alt="' . $Name . '"></a>';
	}
	echo '</td>
	<td><a href="https://www.aprsdirect.de/views/overview.php?c='.$Reflector->Nodes[$i]->GetCallSign();
	if ($Reflector->Nodes[$i]->GetSuffix() != "") echo '-'.$Reflector->Nodes[$i]->GetSuffix();
	echo '" class="ps-1 nav-link" target="_aprs">'.$Reflector->Nodes[$i]->GetCallSign();
	if ($Reflector->Nodes[$i]->GetSuffix() != "") { echo '-'.$Reflector->Nodes[$i]->GetSuffix(); }
	echo '</a></td>
	<td>';
	if (($Reflector->Nodes[$i]->GetPrefix() == 'REF') || ($Reflector->Nodes[$i]->GetPrefix() == 'XRF')) {
		switch ($Reflector->Nodes[$i]->GetPrefix()) {
			case 'REF'  : echo 'REF-Link'; break;
			case 'XRF'  : echo 'XRF-Link'; break;
		}
	}
	else {
		switch ($Reflector->Nodes[$i]->GetSuffix()) {
			case 'A' : echo '23cm'; break;
			case 'B' : echo '70cm'; break;
			case 'C' : echo '2m'; break;
			case 'D' : echo 'Dongle'; break;
			case 'G' : echo 'Internet-Gateway'; break;
			default  : echo 'Hotspot';
		}
	}
	echo '</td>
	<td>'.date("d.m.Y H:i", $Reflector->Nodes[$i]->GetLastHeardTime()).'</td>
	<td>'.FormatSeconds(time()-$Reflector->Nodes[$i]->GetConnectTime()).' s</td>
	<td>'.$Reflector->Nodes[$i]->GetProtocol().'</td>
	<td>'.$Reflector->Nodes[$i]->GetLinkedModule().'</td>';
	if ($PageOptions['RepeatersPage']['IPModus'] != 'HideIP') {
		echo '<td>';
		$Bytes = explode(".", $Reflector->Nodes[$i]->GetIP());
		$MC = $PageOptions['RepeatersPage']['MasqueradeCharacter'];
		if ($Bytes !== false && count($Bytes) == 4) {
			switch ($PageOptions['RepeatersPage']['IPModus']) {
				case 'ShowLast1ByteOfIP':
					echo $MC.'.'.$MC.'.'.$MC.'.'.$Bytes[3];
					break;
				case 'ShowLast2ByteOfIP':
					echo $MC.'.'.$MC.'.'.$Bytes[2].'.'.$Bytes[3]; break;
				case 'ShowLast3ByteOfIP':
					echo $MC.'.'.$Bytes[1].'.'.$Bytes[2].'.'.$Bytes[3];
					break;
				default:
					echo $Reflector->Nodes[$i]->GetIP();
			}
		} else {
			$ipstr = $Reflector->Nodes[$i]->GetIP();
			$count = substr_count($ipstr, ":");
			if ($count > 1) {
				if (1 == substr_count($ipstr, "::")) { $ipstr = str_replace("::", str_repeat(":", 9 - $count), $ipstr); }
				if (7 == substr_count($ipstr, ":")) {
					echo $MC.':'.$MC.':'.$MC.':'.$MC.':'.$MC.':'.$MC;
					$Bytes = explode(":", $ipstr);
					for( $k=6; $k<8; $k++) { echo (0==strlen($Bytes[$k])) ? ':0' : ':'.$Bytes[$k]; }
				}
			}
		}
		echo '</td>';
   }
   echo '</tr>';
   if ($i == $PageOptions['RepeatersPage']['LimitTo']) { $i = $Reflector->NodeCount()+1; }
}

?>

</table>
