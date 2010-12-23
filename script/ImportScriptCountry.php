<?php
 /*
  * country code      : iso country code, 2 characters
postal code       : varchar(10)
place name        : varchar(120)
admin name1       : 1. order subdivision (state) varchar(100)
admin code1       : 1. order subdivision (state) varchar(20)
admin name2       : 2. order subdivision (county/province) varchar(100)
admin code2       : 2. order subdivision (county/province) varchar(20)
admin name3       : 3. order subdivision (community) varchar(100)
latitude          : estimated latitude (wgs84)
longitude         : estimated longitude (wgs84)
accuracy          : accuracy of lat/lng from 1=estimated to 6=centroid
  */
 

/*mysql_connect("localhost", "chartercar", "passbdd") or die("<p>Connexion au serveur mysql impossible, erreur ". mysql_errno() .", message d'erreur : ". mysql_error() ."</p>");
mysql_select_db("chartercar") or die("<p>Sélection de la base impossible, erreur ". mysql_errno() .", message d'erreur : ". mysql_error() ."</p>"); 
  
$filename = "allCountries.txt";
$fd = fopen ($filename, "r");


while(!feof($fd))
{
 $current_line = fgets($fd);
list($countrycode, $cp, $placename, $adminname1, $admincode1,$adminname2,$admincode2,$blank,$lati,$longi)= explode("	",$current_line);

  mysql_query("INSERT INTO `villeinfo` (countrycode, postalcode,placename, adminname1,admincode1,adminname2,admincode2,location, lat, lon) VALUES ('$countrycode', '$cp', '".addslashes($placename)."', '".addslashes($adminname1)."', '$admincode1','$adminname2','$admincode2',GeomFromText( ' POINT($lati   $longi) ' ), $lati , $longi )");
//echo "INSERT INTO `villeinfo` (countrycode, postalcode,placename, adminname1,admincode1,adminname2,admincode2,location, lat, lon) VALUES ('$countrycode', '$cp', '".addslashes($placename)."', '".addslashes($adminname1)."', '$admincode1','$adminname2','$admincode2',GeomFromText( ' POINT($lati   $longi) ' ), $lati , $longi )";
}*/


$center = "GeomFromText('POINT(44.817  -0.217)')";
$radius = 0.05; //50km
$bbox = "CONCAT('POLYGON((',
X($center) - $radius, ' ', Y($center) - $radius, ',',
X($center) + $radius, ' ', Y($center) - $radius, ',',
X($center) + $radius, ' ', Y($center) + $radius, ',',
X($center) - $radius, ' ', Y($center) + $radius, ',',
X($center) - $radius, ' ', Y($center) - $radius, '))'
)";

$query = "
SELECT iddemandetr, placename, postalcode, AsText(location) ,  SQRT(POW( ABS( X(location) - X($center)), 2) + POW( ABS(Y(location) - Y($center)), 2 )) AS distance
FROM villeinfo v
INNER JOIN demandetr d ON (d.villedepart = v.placename) WHERE Intersects( location, GeomFromText($bbox) )
AND  SQRT(POW( ABS( X(location) - X($center)), 2) + POW( ABS(Y(location) - Y($center)), 2 )) < $radius ORDER BY distance;";


echo $query;

//foreach ( $splitcontents as $color )
//{
//
//echo $color[4]."<br />";
//}

?> 