<?php
class Distance
{
        public static function inArea($latitude, $longitude)
        {
                $area = 200;
                return DB::query("SELECT *, 
                                (3959 * 
                                acos(
                                cos(radians($latitude))
                                * cos(radians(latitude)) 
                                * cos(radians(longitude)-radians($longitude)) 
                                + sin(radians($latitude))
                                * sin(radians(latitude))
                                )
                        ) AS `distance` 
                  FROM haiyyausers
                  HAVING distance < $area ORDER BY distance ASC");
        }
}
?>
