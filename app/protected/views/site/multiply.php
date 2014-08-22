<?php
	echo "<table border='1'>";
	for($i=1;$i<=12;$i++)
	{
		echo "<tr>";
		for($j=2;$j<=12;$j++)
		{
			echo "<td width='100px' align='center'>".$j."x".$i."=".$i*$j."</td>";	
		}
		echo "</tr>";
	}
	echo "</table>";
?>