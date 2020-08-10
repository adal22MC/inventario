<?php

function get_module($view, $data = []) {
  $view = $view.'.php';
  if(!is_file($view)) {
    return false;
  }

  $d = $data = json_decode(json_encode($data)); // conversión a objeto

  ob_start();
  require_once $view;
  $output = ob_get_clean();

  return $output;
}