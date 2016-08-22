<?php

define("ALWAYS", 1);
define("ALMOST_ALWAYS", 2);
define("VERY_COMMON", 3);
define("COMMON", 4);
define("UNCOMMON", 5);
define("NOT_THAT_RARE", 6);
define("RARE", 7);
define("LEGENDARY", 8);
define("LEGENDARY_2", 9);
define("LEGENDARY_3", 10);
define("LEGENDARY_4", 11);
define("LEGENDARY_5", 12);


class DropChance
{
    public static function convertRarityToId($rarity)
    {
        return constant($rarity);
    }
}