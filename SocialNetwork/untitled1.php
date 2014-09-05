<?php
include("common/AES.class.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<?php
//z = "abcdefgh01234567"; // 128-bit key
//$z = "abcdefghijkl012345678901"; // 192-bit key
$z = "abcdefghijuklmno0123456789012345"; // 256-bit key

$aes = new AES($z);

$data = "1";

$cryp=$aes->encrypt($data);
$decryp=$aes->decrypt($cryp);

echo "\n\nCipher-Text:\n" . $cryp . "\n";
echo "\n\nPlain-Text:\n" . $decryp . "\n";
?>

</body>
</html>