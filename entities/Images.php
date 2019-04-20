<?php

/**
 * @Entity @Table(name="user")
 **/

class Images
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="text") **/
    protected $path;



    public function __construct( $path)
    {
        $this->path = $path;
    }


    # Accessors
    public function getId() : int { return $this->id; }
    public function getPath() : string { return $this->path; }
}
