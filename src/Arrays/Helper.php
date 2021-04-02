<?php

namespace Drupal\vnd\Arrays;

class Helper
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