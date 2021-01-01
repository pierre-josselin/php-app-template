<?php
trait Hydration {
    public function hydrate(array $data) {
        foreach($data as $key => $value) {
            if($key === "_id") {
                $key = "id";
            }
            $method = "set" . ucfirst($key);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}