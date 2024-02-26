<?php
namespace Mvc\Framework\Kernel\Utils;
class Serializer{
       public function serialize(mixed $entity): array
       {
            $array = (array)$entity;
            $json = [];
                foreach ($array as  $key => $value)
                {
                    $key = str_replace("\0", "", $key);
                    $key = str_replace(get_class($entity), "", $key);
                    $json[$key] = $value;
                }
                return $json;
        }
    }