<?php
require_once "../app/Libraries/koolreport/core/autoload.php";

use \koolreport\processes\Group;
use \koolreport\processes\ColumnMeta;
use \koolreport\processes\DateTimeFormat;
use \koolreport\processes\CopyColumn;




class InformeCaudales extends \koolreport\KoolReport
{

    private $datosInforme;
    public function __construct($datosInforme)
    {
        $this->datosInforme = $datosInforme;
    }


    public function settings()
    {
        return array(
            "dataSources" => array(
                "data" => array(
                    "class" => '\koolreport\datasources\ArrayDataSource',
                    "dataFormat" => "table",
                    "data" => $this->datosInforme
                )
            )
        );
    }

    function setup()
    {
        $this->datosInforme
            ->pipe($this->datosInforme);
    }
}
