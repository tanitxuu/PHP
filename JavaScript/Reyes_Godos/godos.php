<?php
$GODOS =
'["Alarico",["Atanagildo","Leovigildo","RecaredoI",["Sisebuto","RecaredoII","Suintila",["Chindasvinto","Recesvinto","Wamba","Égica","Witiza","Rodrigo"]],"Sisenando","Chintila"],"Witerico","Gundemaro"]';
$NORMANDOS =
'["LINDGREN","ROLLON",["RICARDO","ROBERTO","GUILLERMO",["ESTEBAN","MA TILDE"]]]';
$valor = $_GET['godos'];
if ($valor=="godos"){
echo $GODOS;
}
if ($valor=="normandos"){
echo $NORMANDOS;
}
?>