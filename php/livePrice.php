<?php 
include 'serverConn.php';
$conn=connectToServer();
/*$sql="SELECT p.name pn, po.option1 pop
FROM products p
LEFT JOIN product_options po ON (po.productcode=p.id)
WHERE concat(po.productcode, '-', po.optionid) IN (
'110002-1',
'110005-1',
'110014-1',
'110021-1',
'112000-1',
'112002-1',
'115000-1',
'115003-5',
'115005-1',
'115010-1',
'115011-1',
'115013-1',
'116000-1',
'116001-1',
'116004-1',
'116005-1',
'116018-1',
'116020-1',
'116022-1',
'116024-1',
'118000-1',
'118001-1',
'118003-1',
'118005-1',
'118011-1',
'118028-1',
'122000-1',
'122001-1',
'124000-1',
'124001-1',
'124002-1',
'124007-1',
'124010-1',
'124012-1',
'126000-1',
'126001-1',
'126002-1',
'126007-1',
'126010-1',
'126013-1',
'128000-1',
'128004-1',
'128018-1',
'128019-1',
'145167-4',
'145278-3',
'145299-1',
'145307-1',
'239023-1',
'239025-1',
'239026-2',
'239074-2',
'239075-1',
'268000-1',
'268001-1',
'268002-1',
'268004-1',
'269000-1',
'269001-1',
'269002-1',
'269010-1',
'300000-1',
'300008-1',
'300009-1',
'300024-1',
'300027-1',
'314000-1',
'314001-1',
'314011-1',
'314015-1',
'315000-1',
'315001-1',
'315007-1',
'317046-1',
'317050-1')";
$result = $conn->query($sql);

if($result){
	$outp = "";
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"name":"'  . $rs["pn"] . '",';
			$outp .= '"option":"'. $rs["pop"]     . '"}'; 
	}
	$outp ='{"records":['.$outp.']}';
	$conn->close();

	 $outp;
}else{
	echo $conn->error;
}*/
$sql="SELECT p.productcode pc, po.optionid pop, p.name name, 
IF(t3.price IS NOT NULL AND reseller_price_enabled = 1, t3.price, ROUND((.8 * po.price),2)) tier3,
CONCAT('https://www.ifixit.com/Store/Parts/', p.productcode) URL
FROM products p, product_options po

LEFT JOIN (
SELECT productcode, optionid, price
FROM product_option_reseller_pricing 
WHERE customer_discountid = 17
) t3
ON po.productcode = t3. productcode AND po.optionid = t3.optionid

WHERE p.productcode = po.productcode
AND concat(po.productcode, '-', po.optionid) IN (
'110002-1',
'110005-1',
'110014-1',
'110021-1',
'112000-1',
'112002-1',
'115000-1',
'115003-5',
'115005-1',
'115010-1',
'115011-1',
'115013-1',
'116000-1',
'116001-1',
'116004-1',
'116005-1',
'116018-1',
'116020-1',
'116022-1',
'116024-1',
'118000-1',
'118001-1',
'118003-1',
'118005-1',
'118011-1',
'118028-1',
'122000-1',
'122001-1',
'124000-1',
'124001-1',
'124002-1',
'124007-1',
'124010-1',
'124012-1',
'126000-1',
'126001-1',
'126002-1',
'126007-1',
'126010-1',
'126013-1',
'128000-1',
'128004-1',
'128018-1',
'128019-1',
'145167-4',
'145278-3',
'145299-1',
'145307-1',
'239023-1',
'239025-1',
'239026-2',
'239074-2',
'239075-1',
'268000-1',
'268001-1',
'268002-1',
'268004-1',
'269000-1',
'269001-1',
'269002-1',
'269010-1',
'300000-1',
'300008-1',
'300009-1',
'300024-1',
'300027-1',
'314000-1',
'314001-1',
'314011-1',
'314015-1',
'315000-1',
'315001-1',
'315007-1',
'317046-1',
'317050-1')
GROUP BY po.productcode;
";
$result = $conn->query($sql);

if($result){
	$outp = "";
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"name":"'  . $rs["name"] . '",';
			$outp .= '"price":"'   . $rs["tier3"]        . '",';
			$outp .= '"id":"'   . $rs["pc"]        . '",';
			$outp .= '"option":"'. $rs["pop"]     . '"}'; 
	}
	$outp ='{"records":['.$outp.']}';
	$conn->close();

	echo $outp;
}else{
	echo $conn->error;
}
?>