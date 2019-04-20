<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="properties")
 **/

class Properties
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="text") **/
    protected $title;

    /** @Column(type="text") **/
    protected $HouseAddress;

    /** @Column(type="text") **/
    protected $Street;

    /** @Column(type="text") **/
    protected $ProjectName;
    /** @Column(type="text") **/
    protected $CompanyName;

    /** @Column(type="text") **/
    protected $Description;

    /** @Column(type="string") **/
    protected $PropertyID;
    /** @Column(type="string") **/
    protected $OfficeID;
    /** @Column(type="string") **/
    protected $SaleID;
    /** @Column(type="string") **/
    protected $PropertyCategory;
    /** @Column(type="string") **/
    protected $PropertyType;
    /** @Column(type="string") **/
    protected $CurrentListingPrice;
    /** @Column(type="string") **/
    protected $FloorLevel;
    /** @Column(type="string") **/
    protected $TotalArea;
    /** @Column(type="string") **/
    protected $TotalNumberOfRooms;
    /** @Column(type="string") **/
    protected $NumberOfBathrooms;
    /** @Column(type="string") **/
    protected $NumberOfLivingrooms;
    /** @Column(type="string") **/
    protected $NumberOfBedrooms;
    /** @Column(type="string") **/
    protected $NumberOfToiletRooms;
    /** @Column(type="string") **/
    protected $NumberOfFloors;
    /** @Column(type="string") **/
    protected $Entrance;
    /** @Column(type="string") **/
    protected $Garage;
    /** @Column(type="string") **/
    protected $GarageArea;
    /** @Column(type="string") **/
    protected $YearBuild;

    /**
     * @ManyToMany(targetEntity="Images")
     */
    protected $images;
    /**
     * @ManyToMany(targetEntity="Features")
     */
    protected $features;

    public function __construct($insetData = array())
    {
        $this->title = $insetData['title'];
        $this->HouseAddress = $insetData['HouseAddress'];
        $this->Street = $insetData['Street'];
        $this->ProjectName = $insetData['ProjectName'];
        $this->CompanyName = $insetData['CompanyName'];
        $this->Description = $insetData['Description'];
        $this->PropertyID = $insetData['PropertyID'];
        $this->OfficeID = $insetData['OfficeID'];
        $this->SaleID = $insetData['SaleID'];
        $this->PropertyCategory = $insetData['PropertyCategory'];
        $this->PropertyType = $insetData['PropertyType'];
        $this->CurrentListingPrice = $insetData['CurrentListingPrice'];
        $this->FloorLevel = $insetData['FloorLevel'];
        $this->TotalArea = $insetData['TotalArea'];
        $this->TotalNumberOfRooms = $insetData['TotalNumberOfRooms'];
        $this->NumberOfBathrooms = $insetData['NumberOfBathrooms'];
        $this->NumberOfLivingrooms = $insetData['NumberOfLivingrooms'];
        $this->NumberOfBedrooms = $insetData['NumberOfBedrooms'];
        $this->NumberOfToiletRooms = $insetData['NumberOfToiletRooms'];
        $this->NumberOfFloors = $insetData['NumberOfFloors'];
        $this->Entrance = $insetData['Entrance'];
        $this->Garage = $insetData['Garage'];
        $this->GarageArea = $insetData['GarageArea'];
        $this->YearBuild = $insetData['YearBuild'];
        $this->images = new ArrayCollection();
        $this->features = new ArrayCollection();
    }


    # Accessors
    public function getId() : int { return $this->id; }
    public function getTitle($lang = 'en') { 
        $_title = json_decode($this->title,true);
        $_title = json_decode($_title,true);
        return $_title[$lang] ; 
    }
    public function getHouseAddress($lang = 'en') { 
        $_HouseAddress = json_decode($this->HouseAddress,true);
        return $_HouseAddress[$lang] ; 
    }
    public function getStreet($lang = 'en') { 
        $_Street = json_decode($this->Street,true);
        return $_Street[$lang] ; 
    }
    public function getProjectName($lang = 'en') { 
        $_ProjectName = json_decode($this->ProjectName,true);
        return $_ProjectName[$lang] ; 
    }
    public function getJsonData($field , $lang = 'en'){
        if(empty($field)) return '';
        $_JsonData = json_decode( ($this->{$field}) ,true);
        return  $_JsonData[$lang] ;
    }
    public function getData($field){
        return ($this->{$field});
    }
    public function assignImage($image)
    {
        $this->images[] = $image;
    }
    public function assignFeature($feature)
    {
        $this->features[] = $feature;
    }
    public function getImages(){
        return $this->images;
    }
    public function getFeature()
    {
        return $this->features;
    }
}
