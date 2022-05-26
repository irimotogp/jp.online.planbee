<?php


function checkPhone1($validator, $label, $value) {
  if($value) {
      $value_filter = preg_replace('/-/', '', $value);
      if(!preg_match('/\A[0-9]+\z/', $value_filter) || strlen($value_filter) != 10) {
          $validator->errors()->add($label, '0~9までの半角10桁数字をハイフンを使って入力してください。');
      }
  }
}

function checkPhone2($validator, $label, $value) {
  if($value) {
      $value_filter = preg_replace('/-/', '', $value);
      if(!preg_match('/\A[0-9]+\z/', $value_filter) || strlen($value_filter) != 11) {
          $validator->errors()->add($label, '0~9までの半角11桁数字をハイフンを使って入力してください。');
      }
  }
}

function dataToPhoneType($value) {
  if($value) {
    $value_filter = " " . preg_replace('/-/', '', $value);
    $result = str_split($value_filter, 4);
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