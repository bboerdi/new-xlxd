<?php

$Result = @fopen($CallingHome['ServerURL']."?do=GetReflectorList", "r");

if (!$Result) die("HEUTE GIBTS KEIN BROT");

$INPUT = "";
while (!feof ($Result)) {
    $INPUT .= fgets ($Result, 1024);
}
fclose($Result);

$XML = new ParseXML();
$Reflectorlist = $XML->GetElement($INPUT, "reflectorlist");
$Reflectors    = $XML->GetAllElements($Reflectorlist, "reflector");

?>


<table class="table table-sm table-dark table-striped table-hover text-white">
   <tr class="table-center">  
      <th class="col-md-1">#</th>
      <th class="col-md-3">Reflektor</th>
      <th class="col-md-3">Land</th>
      <th class="col-md-1">In Betrieb?</th>
      <th class="col-md-4">Information</th>
   </tr>
<?php

for ($i=0;$i<count($Reflectors);$i++) {
   
   $NAME          = $XML->GetElement($Reflectors[$i], "name");
   $COUNTRY       = $XML->GetElement($Reflectors[$i], "country");
   $LASTCONTACT   = $XML->GetElement($Reflectors[$i], "lastcontact");
   $COMMENT       = $XML->GetElement($Reflectors[$i], "comment");
   $DASHBOARDURL  = $XML->GetElement($Reflectors[$i], "dashboardurl");
   
   echo '
 <tr class="table-center">
   <td>'.($i+1).'</td>
   <td><a href="'.$DASHBOARDURL.'"  target="_peer" class="listinglink text-white"  data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Besuche das Dashboard von '.$NAME.'">'.$NAME.'</a></td>
   <td>'.$COUNTRY.'</td>
   <td><img src="./img/'; if ($LASTCONTACT<(time()-600)) { echo 'down'; } ELSE { echo 'up'; } echo '.png" class="table-status" alt=""></td>
   <td>'.$COMMENT.'</td>
 </tr>';
}

?>
</table>
   
   
