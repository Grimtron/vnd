<?php

namespace Drupal\vn;

class Arrays
{
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