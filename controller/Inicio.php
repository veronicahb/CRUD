<?php
class Inicio
{
  public function controller()
  {
    $inicio = new Template("view/inicio.html");
    $inicio->set("nome", "Ana Clara e Verônica");
    $retorno["msg"] = $inicio->saida();
    return $retorno;
  }
}
