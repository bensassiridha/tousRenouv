<?php
class query{
    function execute($sql) {
		$boolean = mysql_query($sql);
			if (!$boolean) {
				echo mysql_error();
				exit;
			}
    
	return $boolean;
							}
}
?>