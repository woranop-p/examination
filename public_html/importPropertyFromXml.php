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
function __initData($propData){
   
    $__Data = array(
        'title' => $propData['Address']['Title'],
        'HouseAddress' => $propData['Address']['HouseAddress'],
        'Street' => $propData['Address']['Street'],
        'ProjectName' => $propData['Information']['ProjectName'],
        'CompanyName' => $propData['Information']['CompanyName'],
        'Description' => $propData['Description']['DescriptionText'],
        'PropertyID'  => $propData['Information']['PropertyID'],
        'OfficeID' => $propData['Information']['OfficeID'],
        'SaleID' => $propData['Information']['SaleID'],
        'PropertyCategory' => $propData['Information']['PropertyCategory']['@attributes']['PropertyCategory'],
        'PropertyType' => $propData['Information']['PropertyType']['@attributes']['PropertyType'],
        'CurrentListingPrice' => $propData['Information']['CurrentListingPrice'],
        'FloorLevel' => $propData['Information']['FloorLevel']['@attributes']['FloorLevel'],
        'TotalArea' => $propData['Information']['TotalArea'],
        'TotalNumberOfRooms' => $propData['Information']['TotalNumberOfRooms'],
        'NumberOfBathrooms' => $propData['Information']['NumberOfBathrooms'],
        'NumberOfLivingrooms' => $propData['Information']['NumberOfLivingrooms'],
        'NumberOfBedrooms' => $propData['Information']['NumberOfBedrooms'],
        'NumberOfToiletRooms' => $propData['Information']['NumberOfToiletRooms'],
        'NumberOfFloors' => $propData['Information']['NumberOfFloors'],
        'Entrance' => $propData['Information']['Entrance'],
        'Garage' => $propData['Information']['Garage'],
        'GarageArea' => $propData['Information']['GarageArea'],
        'YearBuild' => $propData['Information']['YearBuild'],
    );
    // print_r($__Data);exit();
    return $__Data;
}
$argements = arguments($argv); 
$path = str_replace(array( '[', ']' ), '', $argements['filePath'] );

$doc= file_get_contents($path);
$json_array = simplexml_load_string($doc);

$json  = json_encode($json_array->Properties->Property );
$xmlData = json_decode($json, true);
$insertData = __initData($xmlData);

// create prop
    $entityManager = getEntityManager();
    $propertie = new Properties($insertData); 

    // images 
    $images = $xmlData['Images']['Image'];
    foreach($images as $image){
        $__img = new Images($image['FileName']); 
        $entityManager->persist($__img);
        $entityManager->flush();
        $img = $entityManager->find("Images", $__img->getId());
        $propertie->assignImage($img);
    }

    $features = $xmlData['Features']['FeatureID'];
    foreach($features as $feature){
        $__feature = new Features($feature); 
        $entityManager->persist($__feature);
        $entityManager->flush();
        $feature_ob = $entityManager->find("Features", $__feature->getId());
        $propertie->assignFeature($feature_ob);
    }
    $entityManager->persist($propertie);
    $entityManager->flush();

echo "Your new Property Id: ".$propertie->getId()."\n";
