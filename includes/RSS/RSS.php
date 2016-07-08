<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/07/2016
 * Time: 21:08
 */

namespace includes\RSS;


class RSS
{
    function removeNode($xml, $path, $multi='one')
    {
        $result = $xml->xpath($path);

        # for wrong $path
        if (!isset($result[0])) return false;

        switch ($multi) {
            case 'all':
                $errlevel = error_reporting(E_ALL & ~E_WARNING);
                foreach ($result as $r) unset ($r[0]);
                error_reporting($errlevel);
                return true;

            case 'child':
                unset($result[0][0]);
                return true;

            case 'one':
                if (count($result[0]->children()) == 0 && count($result) == 1) {
                    unset($result[0][0]);
                    return true;
                }

            default:
                return false;
        }
    }
    
        
}