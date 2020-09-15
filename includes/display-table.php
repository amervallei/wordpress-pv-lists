<?php

function display_table( $results ){

	$headers = $results[0];
	// print_r( $headers );
	// print_r( $results );
printf('<table %s','style="color: red;">');
//	echo '<table>';
	// table headers
	echo "<tr>";
	foreach($headers as $key => $value){
		echo '<th>';
		echo $key;
		echo "</th>";
	}
	echo "</tr>";

	// table contents
	foreach ($results as $row) {
		echo "<tr>";
		//	print_r( $row );
		foreach( $row as $key => $value ){
			echo "<td>";
			echo $value ;
			//			echo $key . ' : ' . $value ;
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";

}
