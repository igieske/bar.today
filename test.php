<?php
$counter=$_GET['counter'];

$frase=array("Фраза 1<br>","Фраза 2<br>","Фраза 3<br>","Фраза 4<br>","Фраза 5<br>","Фраза 6<br>","Фраза 7<br>","Фраза 8<br>","Фраза 9<br>");
if ($counter<9)
{
	for ($k=0;$k<=$counter;$k++)
	{
	echo $frase[$k];
	}
if ($counter=30) $counter=20;
exit("<meta http-equiv='refresh' content='2; url= test.php?counter=$counter'>");
}
echo "The end :)";
?>