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
    // $propertie = new Properties($insertData); 

    // // // // images 

    // $images = $xmlData['Images']['Image'];
    // foreach($images as $image){
    //     $__img = new Images($image['FileName']); 
    //     $entityManager->persist($__img);
    //     $entityManager->flush();
    //     $img = $entityManager->find("Images", $__img->getId());
    //     $propertie->assignImage($img);
    // }

    // $features = $xmlData['Features']['FeatureID'];
    // foreach($features as $feature){
    //     $__feature = new Features($feature); 
    //     $entityManager->persist($__feature);
    //     $entityManager->flush();
    //     $feature_ob = $entityManager->find("Features", $__feature->getId());
    //     $propertie->assignFeature($feature_ob);
    // }
    // $entityManager->persist($propertie);
    // $entityManager->flush();


// $propertie_id = $propertie->getId(); print_r($propertie_id);

// $product = $entityManager->find("Properties", 5);
// $users = $entityManager->getRepository("Properties")->findAll();
// print "Props: " . print_r($users, true) . PHP_EOL;
// print_r($users);
// foreach($users as $user){
//     print_r( $user->getTitle() );
// }

// create a user
// $entityManager = getEntityManager();
// $user = new User('Programster', 'programster@programster.org'); 
// $entityManager->persist($user);
// $entityManager->flush();

// echo "Created User with ID " . $user->getId() . PHP_EOL;

// List all users:

// $users = $entityManager->getRepository("User")->findAll();
// print "Users: " . print_r($users, true) . PHP_EOL;

// foreach($users as $user){
//     echo $user->getId().' ';
// }

$dql = "SELECT p FROM Properties p";
$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);
$bugs = $query->getResult();

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
    // 'title',
    'HouseAddress',
    'Street',   
    'CompanyName',
    'Description',
);

foreach($bugs AS $bug) {
    // echo $bug->getProjectName('th')."\n";
    // echo $bug->getJsonData('Street' , 'th')."\n-";
    // echo $bug->getTitle('en')."\n";
    // echo $bug->getHouseAddress('th')." - "."\n";
    // echo $bug->getData('PropertyID' )."\n";
    echo 'Title : '.$bug->getTitle('th')."\n";
    foreach($fieldData as $field){
        echo $field.' : '.$bug->getData( $field , 'th')."\n";
    }
    foreach($fieldJson as $field){
        echo  $field.' : '.$bug->getJsonData( $field , 'th')."\n";
    }
    echo "Image :";
    foreach($bug->getImages() AS $imgs) {
        echo "   Image Path: ".$imgs->getPath()."\n";
    }
    echo "Feature :";
    foreach($bug->getFeature() AS $feature) {
        echo " - ".$feature->getFeatureName()."\n";
    }
    echo "\n";
}