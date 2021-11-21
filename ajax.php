  
  <?php
  spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
  });
  // if (isset($_POST['action']) && !empty($_POST['action'])) {
  //     echo json_encode(array("blablabla" => $variable));
  // }
  $StokReq = new Stok();
  $id = $_REQUEST["id"];
  $myJSON = json_encode($StokReq->readById($id));
  echo $myJSON;
  ?>