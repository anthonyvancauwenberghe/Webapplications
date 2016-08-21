<?php

/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 20/06/2016
 * Time: 19:10
 */
class Rank
{
    const NONE = -1;
    const CUSTOMER=1;
    const EMPLOYEE = 5;
    const STOREMANAGER=10;
    const BUILDINGMANAGER =20;
    const OWNER = 30;

    public function getRank($rankName)
    {
        switch ($rankName) {
            case 'CUSTOMER':
                return Rank::CUSTOMER;
                break;
            case 'EMPLOYEE':
                return Rank::EMPLOYEE;
                break;
            case 'STOREMANAGER':
                return Rank::STOREMANAGER;
                break;
            case 'BUILDINGMANAGER':
                return Rank::BUILDINGMANAGER;
                break;
            case 'OWNER':
                return Rank::OWNER;
                break;
            default:
                return Rank::NONE;
                break;
        }
    }
}