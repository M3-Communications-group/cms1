<? 
ini_set("memory_limit", "32M");
require("../inc/config.php");
require("../inc/mysql_connect.php");
require("../inc/functions.php");
require("inc/functions.php");
require("inc/setup.php");
require("inc/auth.php");

$_GET["admin_option"] = 25;
locate_position(25);

if($_SESSION["perm_view"] != 1) {
	die("Not allowed!");
}

header('Content-type: application/xls');
header('Content-disposition: attachment; filename="newsalert.xls"');

$myquery = "SELECT * from newsalert_users left join newsalert_users_groups on newsalert_users.pid = newsalert_users_groups.id where pid in (3, 6, 12, 14, 16, 18, 21, 23, 24) order by newsalert_users.id";
$MyResult = query($myquery);
echo '

<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<body>

<table border="1" cellpadding="5" cellspacing="0">
	<tr>
		<td width="100" align="center"><b>E-mail</b></td>
		<td width="100" align="center"><b>Category</b></td>
	</tr>
';
while ($row = mysql_fetch_array($MyResult)) {
	echo '
		<tr>
			<td>'.$row["email"].'</td>
			<td>'.$row["name"].'</td>
		</tr>
	';
}
echo '
<table>
</body>
</html>';
?>
