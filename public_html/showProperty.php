<?php

require_once(__DIR__ . '/../bootstrap.php');

function arguments($argv) {
    $_ARG = array();
    foreach ($argv as $arg) {
        if (preg_match('/--([^=]+)=(.*)/',$arg,$reg)) {
            $_ARG[$reg[1]] = $reg[2];
        } elseif(preg_match('/-([a-zA-Z0-9])/',$arg,$reg)) {
            $_ARG[$reg[1]] = 'true';
        }
   
    }
  return $_ARG;
}

$argements = arguments($argv); 
$lang = $argements['language'];

$entityManager = getEntityManager();

$dql = "SELECT p FROM Properties p";
$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);
$props = $query->getResult();

$fieldData = array(
    'PropertyID' ,
    'OfficeID',
    'SaleID',
    'PropertyCategory',
    'PropertyType',
    'CurrentListingPrice',
    'FloorLevel',
    'TotalArea',
    'TotalNumberOfRooms',
    'NumberOfBathrooms',
    'NumberOfLivingrooms',
    'NumberOfBedrooms',
    'NumberOfToiletRooms',
    'NumberOfFloors',
    'Entrance',
    'Garage',
    'GarageArea',
    'YearBuild',
); 
$fieldJson = array(
    'ProjectName', 
    'title',
    'HouseAddress',
    'Street',   
    'CompanyName',
    'Description',
);

foreach($props AS $prop) {
    echo 'ID : '.$prop->getId( )."\n";
    foreach($fieldData as $field){
        echo "\n".$field.' : '.$prop->getData( $field  )."\n";
    }
    foreach($fieldJson as $field){
        echo  "\n".$field.' : '.$prop->getJsonData( $field , $lang )."\n";
    }
    echo "Image :";
    foreach($prop->getImages() AS $imgs) {
        echo "   Image Path: ".$imgs->getPath()."\n";
    }
    echo "Feature :";
    foreach($prop->getFeature() AS $feature) {
        echo " - ".$feature->getFeatureName()."\n";
    }
    echo "\n";
}