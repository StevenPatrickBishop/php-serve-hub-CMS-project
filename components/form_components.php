<?php
//-----------------------------form parts ------------------------------


/*
        Things to pass
		0. table class
        1. paragraph class   default: ''
        2. paragraph text    default: ''
        3. input class      default: ''
        4. input name       required
        5. value:           default: ''
		6. q_update: 		set true if input fieds are being populated by database query
        */

function showTextInput( $tbl_class = '', $p_class = '', $p_text = '', $i_class = '', $i_name, $i_value = '', $q_update ) {

	$error_class = strtolower( $p_text ) . "-errors error";
	if ( !$q_update ) {
		$i_value = isset( $_POST[ $i_name ] ) ? htmlspecialchars( $_POST[ $i_name ] ) : '';
	}

	echo "<table class='$tbl_class'>";
	echo "<tr>";
	echo "<td>";
	echo "<p class='$p_class'> $p_text:</p>";
	echo "</td>";
	echo "<td>";
	echo "<input class='$i_class' type='text' name='$i_name' value='$i_value'/>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	if((isset($_POST[$i_name])) && empty($i_value)){
	echo("<p class='$error_class'> - $p_text has not been set</p> ");}
	echo "</td>";
	echo "</tr>";
	echo "</table>";

}


function showTextArea( $tbl_class = '', $p_class = '', $p_text = '', $t_class = '', $t_name, $t_value = '', $q_update ) {


	$error_class = strtolower( $p_text ) . "-errors error";
	if ( !$q_update ) {
		$t_value = isset( $_POST[ $t_name ] ) ? htmlspecialchars( $_POST[ $t_name ] ) : '';
	}


	echo "<table class='$tbl_class'>";
	echo "<tr>";
	echo "<td>";
	echo "<p class='$p_class'>$p_text: </p>";
	echo "</td>";
	echo "<td>";
	echo "<textarea rows='4' cols='50' class='$t_class'name='$t_name'>$t_value</textarea>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	 if((isset($_POST[$t_name])) && empty($t_value)){
	      echo("<p class='$error_class'> - $p_text has not been set</p> ");}
	echo "</td>";
	echo "</tr>";
	echo "</table>";


}

?>