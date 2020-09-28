<?php

function display_table( $results ){

	$table = NULL;

	$headers = $results[0];
	// print_r( $headers );
	// print_r( $results );
	$table = $table . '<table>';
	// table headers
	$table = $table . '<tr>';
	foreach($headers as $key => $value){
		$table = $table . '<th>' . $key . '</th>'; 
	}
	$table = $table . '</tr>';

	// table contents
	foreach ($results as $row) {
		$table = $table . '<tr>';
		//	print_r( $row );
		foreach( $row as $key => $value ){
			//			echo $key . ' : ' . $value ;
			$table = $table . '<td>' . $value . '</td>';
		}
		$table = $table . '</tr>';
	}
	$table = $table . '</table>';

	return($table);

}
