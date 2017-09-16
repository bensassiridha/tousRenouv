<?php 
    require('mysql.php');     

$postal = (isset($_POST['ip_cp']) ? $_POST['ip_cp'] : null); 

if(isset($_POST['ip_cp']))
{
	$sql ="SELECT * FROM ttre_villes_france WHERE ville_code_postal='".$_POST['ip_cp']."' ORDER BY ville_id ASC";
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$option='<option value="0"></option>';
		while($row = $result->fetch_assoc())
		{
			$option.='<option value="'.$row['ville_id'].'">'.$row['ville_nom_reel'].'</option>';
		}
	} else {
		echo "0 results";
	}
	echo $option ; 
}
$conn->close();

