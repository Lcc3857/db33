<?php require_once('Connections/mySQL33.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_indexCordSet = 3;
$pageNum_indexCordSet = 0;
if (isset($_GET['pageNum_indexCordSet'])) {
  $pageNum_indexCordSet = $_GET['pageNum_indexCordSet'];
}
$startRow_indexCordSet = $pageNum_indexCordSet * $maxRows_indexCordSet;

mysql_select_db($database_mySQL33, $mySQL33);
$query_indexCordSet = "SELECT * FROM db3";
$query_limit_indexCordSet = sprintf("%s LIMIT %d, %d", $query_indexCordSet, $startRow_indexCordSet, $maxRows_indexCordSet);
$indexCordSet = mysql_query($query_limit_indexCordSet, $mySQL33) or die(mysql_error());
$row_indexCordSet = mysql_fetch_assoc($indexCordSet);

if (isset($_GET['totalRows_indexCordSet'])) {
  $totalRows_indexCordSet = $_GET['totalRows_indexCordSet'];
} else {
  $all_indexCordSet = mysql_query($query_indexCordSet);
  $totalRows_indexCordSet = mysql_num_rows($all_indexCordSet);
}
$totalPages_indexCordSet = ceil($totalRows_indexCordSet/$maxRows_indexCordSet)-1;

$queryString_indexCordSet = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_indexCordSet") == false && 
        stristr($param, "totalRows_indexCordSet") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_indexCordSet = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_indexCordSet = sprintf("&totalRows_indexCordSet=%d%s", $totalRows_indexCordSet, $queryString_indexCordSet);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>home</title>
</head>

<body>
<table width="100" border="1" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td colspan="4">新增</td>
  </tr>
  <tr>
    <td colspan="4">從1~2共2筆</td>
  </tr>
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Old</td>
    <td>Addr</td>
  </tr>
  
  
  <?php do { ?>
  <tr>
    <td><?php echo $row_indexCordSet['ID']; ?></td>
    <td><?php echo $row_indexCordSet['Name']; ?></td>
    <td><?php echo $row_indexCordSet['Old']; ?></td>
    <td><?php echo $row_indexCordSet['Addr']; ?></td>
  </tr>
  <?php } while ($row_indexCordSet = mysql_fetch_assoc($indexCordSet)); ?>
</table>


<table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_indexCordSet > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_indexCordSet=%d%s", $currentPage, 0, $queryString_indexCordSet); ?>"><img src="First.gif" border=0></a>
            <?php } // Show if not first page ?>
      </td>
      <td width="31%" align="center"><?php if ($pageNum_indexCordSet > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_indexCordSet=%d%s", $currentPage, max(0, $pageNum_indexCordSet - 1), $queryString_indexCordSet); ?>"><img src="Previous.gif" border=0></a>
            <?php } // Show if not first page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum_indexCordSet < $totalPages_indexCordSet) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_indexCordSet=%d%s", $currentPage, min($totalPages_indexCordSet, $pageNum_indexCordSet + 1), $queryString_indexCordSet); ?>"><img src="Next.gif" border=0></a>
            <?php } // Show if not last page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum_indexCordSet < $totalPages_indexCordSet) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_indexCordSet=%d%s", $currentPage, $totalPages_indexCordSet, $queryString_indexCordSet); ?>"><img src="Last.gif" border=0></a>
            <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>

</body>
</html>
<?php
mysql_free_result($indexCordSet);
?>
