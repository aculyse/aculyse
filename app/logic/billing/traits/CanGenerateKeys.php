<?php

namespace Aculyse\Billing\Traits;

use Illuminate\Support\Collection;
use Aculyse\Models\Licenses;


trait CanGenerateKeys{

  private $pin;
  private $licence_key;


  private function generate(){
    $this->pin();
    $this->licence();
    return Collection::make(["pin"=>$this->pin,"licence_key"=>$this->licence_key]);
  }


  public function saveNewKey($plan_id=0,$duration=NULL)
  {
    $keys = $this->generate();

    $licence = new  Licenses();
    $licence->pin = $this->pin;
    $licence->key = $this->licence_key;
    $licence->duration = $duration;
    $licence->plan_id= $plan_id;

    return $licence->save();
  }

  public function saveManyKeys($plan_id,$duration,$quantity)
  {
    if ($quantity<=0 || is_numeric($quantity)==FALSE ) {
      return FALSE;
    }
    $i=0;
    while ($i <= $quantity) {
      if ($this->saveNewKey($plan_id,$duration)==FALSE) {
        return FALSE;
      };
      $i++;
    }
    return TRUE;
  }


  private function pin()
  {
    $this->pin=rand(1000,9999);
    return $this->pin;
  }

  private function licence()
  {
    $i=0;
    $this->licence_key="";

    while ($i <= 4) {
      $spacer = "-";
      if($i==0){
        $spacer = "";
      }
      $i++;

      $this->licence_key .= $spacer.$this->pin();
    }

    return $this->licence_key;
  }
}
