<?php require_once('Connections/mySQL33.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE db3 SET Name=%s, `Old`=%s, Addr=%s WHERE ID=%s",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Old'], "int"),
                       GetSQLValueString($_POST['Addr'], "text"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_mySQL33, $mySQL33);
  $Result1 = mysql_query($updateSQL, $mySQL33) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_detailCordSet = "-1";
if (isset($_GET['id'])) {
  $colname_detailCordSet = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_mySQL33, $mySQL33);
$query_detailCordSet = sprintf("SELECT * FROM db3 WHERE ID = %s", $colname_detailCordSet);
$detailCordSet = mysql_query($query_detailCordSet, $mySQL33) or die(mysql_error());
$row_detailCordSet = mysql_fetch_assoc($detailCordSet);
$totalRows_detailCordSet = mysql_num_rows($detailCordSet);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>設定</title>
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table width="100" border="1" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Old</td>
    <td>Addr</td>
  </tr>
  <tr>
    <td><input type="text" name="ID" value="<?php echo $row_detailCordSet['ID']; ?>" readonly="true" /></td>
    <td><input type="text" name="Name" value="<?php echo $row_detailCordSet['Name']; ?>" /></td>
    <td><input type="text" name="Old" value="<?php echo $row_detailCordSet['Old']; ?>" /></td>
    <td><input type="text" name="Addr" value="<?php echo $row_detailCordSet['Addr']; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="更新" /></td>
    <td colspan="2">刪除</td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>

</body>
</html>
<?php
mysql_free_result($detailCordSet);
?>
