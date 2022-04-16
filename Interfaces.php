<?php

interface iTarif
{
    public function getSum();// считает сумму
    public function addService(iService $service);// покдлючение доп сервиса
}

interface iService
{
    public function getCost(int $distance, int $time); // доп услуги
}


