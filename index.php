<?php
include 'Interfaces.php';

class ServiceGPS implements iService
{
    public $priceHour = 15;
    public function getCost(int $distance, int $time)
    {
        if($time <= 60)
        {
            return 15;
        } else
        {
            return  $this->priceHour * round($time / 60);
        }
    }
}

class ServiceDriver implements iService
{

    public function getCost(int $distance, int $time)
    {
        return 100;
    }
}

abstract class Tariff implements iTarif
{
    public $distance;
    public $time;
    public $costDistance;
    public $costTime;
    public $services = array();
    public function __construct($distance, $time)
    {
        $this->distance = $distance;
        $this->time = $time;
    }
    public function getSum()
    {
       $sum = $this->costTime*$this->time + $this->costDistance* $this->distance;
       foreach ($this->services as $service)
       {
           $sum +=$service->getCost($this->distance, $this->time);
       }
       return $sum;
    }

    public function addService(iService $service)
    {
        $this->services[] = $service;
    }

    public function showMessage()
    {
        if ($this->services[0])
        {
            $str_d1 = "Услуга GPS";
        }
        if ($this->services[1])
        {
            $str_d2 = "Услуга доп водитель";
        }
        $str = "Тариф " . get_called_class() . ", пройдено " . $this->distance .'км '. 'за ' . $this->time . ' минут' . "<br>" . 'общая цена '. $this->getSum() . ' рулей' ."<br>" .
            'доп услуги: ' . $str_d1 . ' ' . $str_d2;
        return $str;
    }
}

class Basic extends Tariff
{
    public $costDistance = 10;
    public $costTime = 3;


}

class ForHour extends Tariff
{
    public $costDistance = 10;
    public $costTime = 3;

    public function getSum()
    {

        if (fmod($this->time,60) > 0)
        {
            $sum = 200*$this->time + ceil(fmod($this->time,60));
            return $sum;
        } else
        {
            $sum = $this->costTime*$this->time;
            return $sum;
        }
    }
}

class Student extends Tariff
{
    public $costDistance = 4;
    public $costTime = 1;
}

$sample = new Basic(0,50);
$sample->addService(new ServiceGPS());
$sample->addService(new ServiceDriver());
echo $sample->showMessage();
