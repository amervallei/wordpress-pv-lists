<?php

function display_table( $results ){

	$table = NULL;

	$headers = $results[0];
	// print_r( $headers );
	// print_r( $results );
	echo '<table>';
	// table headers
	echo "<tr>";
	foreach($headers as $key => $value){
		echo '<th>';
		echo $key;
		echo "</th>";
		$table = $table . '<br>Next: ' . $key . '<br>'; 
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

	return($table);

}
