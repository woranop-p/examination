<?php

/**
 * @Entity @Table(name="Features")
 **/

class Features
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="text") **/
    protected $feature_id;
     /** @Column(type="text") **/
    protected $feature_name;


    public function __construct( $Fid)
    {

        $this->feature_id = $Fid;
        $this->feature_name = 'Feature-Number' . $Fid;
    }


    # Accessors
    public function getId() : int { return $this->id; }
    public function getFeatureName()  { return $this->feature_name; }
}
