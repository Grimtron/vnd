<?php

namespace Drupal\vnd;

/** @package Drupal\vnd */

/**
 * Hilfsfunktionen für Arrays
 */
class Arrays
{
     /**
      * Führt nicht-leere Werte, die komma-separiert übergeben werden können mit Hilfe eines Verbindungsstrings zusammen.
     * 
     * Intern wird implode verwendet, vorher werden alle leeren Werte aussortiert.
      *
      * @param string $glue
      * @param mixed ...$parameters
      * @return string
      */
    public static function ImplodeNonEmptyValues($glue, ...$parameters)
    {
        $data = [];
        foreach ($parameters as $parameter)
        {
            if ($parameter != '')
            {
                $data[] = $parameter;
            }
        }

        return implode($glue, $data);
    }
}

?>