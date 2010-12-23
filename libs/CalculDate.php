<?
/*
 * @arg $date1,$heure1,$date2,$heure2
 * @format date : 25/10/2006 -> $date1=25/10/2006
 * @format heure : 09:10 -> $heure1=09 ; $min1=10
 */
function Duration($date1,$heure1,$min1,$date2,$heure2,$min2)
{

	list($jourdepart, $moisdepart, $anneedepart) = explode('/', $date1);
	list($jourarrive, $moisarrive, $anneearrive) = explode('/', $date2);
	list($heure1,$minute1) = explode(':',$heure1.":".$min1);
	list($heure2,$minute2) = explode(':',$heure2.":".$min2);	
	$timestamp1 = @mktime($heure1,$minute1,0,$moisdepart,$jourdepart,$anneedepart); 
	$timestamp2 = @mktime($heure2,$minute2,0,$moisarrive,$jourarrive,$anneearrive); 
	$total_hr=abs($timestamp2 - $timestamp1)/(3600); 
	return $total_hr;
}

/*
 * @format 25/10/2006
 * @return boolean
 */
function CheckDateFormation($date)
{
	list($jourdepart, $moisdepart, $anneedepart) = explode('/', $date);
	if(@checkdate($moisdepart,$jourdepart,$anneedepart))
	{
	  return true;
	}
	else
	{
	 return false;
	}		
}

function CheckHeure($heure)
{
	if($heure==="")
		return false;
		
	return (bool)(intval($heure)>=0) and (intval($heure)<=23);
}

function CheckMinutes($minutes)
{
	if($minutes==="")
		return false;

	return (bool)(intval($minutes)>=0) and (intval($minutes)<=59);
}

?>