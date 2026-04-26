<?php
function message($messege, $type) {

  $colorFondo = ($type === "success") ? "bg-green-100" : "bg-red-100";
  $colorTexto = ($type === "success") ? "text-green-700" : "text-red-700";
  return "
  <div class='p-4 {$colorFondo} {$colorTexto} rounded-xl font-bold mb-4'>
    {$messege}
  </div>
  ";
}
?>