<?php

function plugin_activate() {
	global $prefixeTable;
	$query = '
		CREATE TABLE IF NOT EXISTS '.$prefixeTable.'accepted_by (
			accepted_by_id int(11) NOT NULL AUTO_INCREMENT,
			name varchar(100) NOT NULL,
			PRIMARY KEY (accepted_by_id)
		) ENGINE=MyISAM DEFAULT CHARACTER SET utf8
		;';
	pwg_query($query);
}

function plugin_uninstall() {
  global $prefixeTable;

  $query = '
    DROP TABLE '.$prefixeTable.'accepted_by
    ;';
  pwg_query($query);

}
?>
