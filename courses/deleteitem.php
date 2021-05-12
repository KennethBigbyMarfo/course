<?php
@session_start();
require("../classes/mysql.class.php");

if(isset($_POST['mv'])){
	
	$id=base64_decode($_POST['mv']);
	if(isset($_SESSION['term_User'])){
	
		$q=new MySQL();
		$query="delete from courses where id=$id";
		$rs=$q->Query($query);
		echo $q->Error();
		if($rs){echo '<div class="alert alert-success">Deleted Item Successfully!</div>';}else{
			echo '<div class="alert alert-success">Transaction Failed!</div>';}
		
		}
	
	}
