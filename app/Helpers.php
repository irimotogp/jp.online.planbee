<?php


function checkPhone($validator, $label, $value) {
  if($value) {
      $value_filter = preg_replace('/-/', '', $value);
      if(!preg_match('/\A[0-9]+\z/', $value_filter) || (strlen($value_filter) != 10 && strlen($value_filter) != 11)) {
          $validator->errors()->add($label, '0~9までの半角10~11桁数字をハイフンを使って入力してください。');
      }
  }
}
function checkPhone11($validator, $label, $value) {
  if($value) {
      $value_filter = preg_replace('/-/', '', $value);
      if(!preg_match('/\A[0-9]+\z/', $value_filter) || (strlen($value_filter) != 11)) {
          $validator->errors()->add($label, '0~9までの半角11桁数字をハイフンを使って入力してください。');
      }
  }
}

function dataToPhoneType($value) {
  if($value) {
    $value_filter = " " . preg_replace('/-/', '', $value);
    $result = [];
    $result[] = substr($value_filter, 0, 4); 
    $result[] = substr($value_filter, 4, 4); 
    $result[] = substr($value_filter, 8, 4); 
    return implode("-", $result);
  } else {
    return "";
  }
}

function getTextOfProf($value) {
  $prefs_collection = collect(config('values.prefs'));
  $prefs = $prefs_collection->pluck('text', 'value')->all();
  return $prefs[$value];
}

function mapWithKeys($array) {
  return collect($array)->mapWithKeys(function($x){ return [ $x => $x ]; })->toArray();
}