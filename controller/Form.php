<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $form->set("id", "");
    $form->set("modelo", "");
    $form->set("marca", "");
    $form->set("motor", "");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["modelo"]) && isset($_POST["marca"]) && isset($_POST["motor"])) {
      try {
        $conexao = Transaction::get();
        $modelo = $conexao->quote($_POST["modelo"]);
        $marca = $conexao->quote($_POST["marca"]);
        $motor = $conexao->quote($_POST["motor"]);
        $crud = new Crud();
        if (empty($_POST["id"])) {
          $retorno = $crud->insert(
            "veiculo",
            "modelo,marca,motor",
            "{$modelo},{$marca},{$motor}"
          );
        } else {
          $id = $conexao->quote($_POST["id"]);
          $retorno = $crud->update(
            "veiculo",
            "modelo={$modelo}, marca={$marca}, motor={$motor}",
            "id={$id}"
          );
        }
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
