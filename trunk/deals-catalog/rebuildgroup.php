<?php
require('configuration.php');
$dbs = new JConfig;
$host = $dbs->host;
$user = $dbs->user;
$password = $dbs->password;
$db = $dbs->db;
mysql_connect($host, $user, $password) or
die("Could not connect: " . mysql_error());
mysql_select_db($db);
// 0-> parent_id in Joomla this is the value of the parent_id field of the Root record
// 1-> start the left tree at 1
rebuild_tree ( 0 , 1);
 
function rebuild_tree($parent_id, $left) {
 
// the right value of this node is the left value + 1
$right = $left+1;
 
// get all children of this node
$result = mysql_query('SELECT id FROM jos_core_acl_aro_groups '.
'WHERE parent_id="'.$parent_id.'";');
while ($row = mysql_fetch_array($result)) {
// recursive execution of this function for each
// child of this node
// $right is the current right value, which is
// incremented by the rebuild_tree function
$right = rebuild_tree($row['id'], $right);
}
 
// we've got the left value, and now that we've processed
// the children of this node we also know the right value
mysql_query('UPDATE jos_core_acl_aro_groups SET lft='.$left.', rgt='.
$right.' WHERE id="'.$parent_id.'";');
 
// return the right value of this node + 1
return $right+1;
}
?>