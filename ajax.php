  
  <?php
  spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
  });
  // if (isset($_POST['action']) && !empty($_POST['action'])) {
  //     echo json_encode(array("blablabla" => $variable));
  // }
  $PenjualanReq = new Penjualan();
  $id = $_REQUEST["id"];
  $myJSON = json_encode($PenjualanReq->readById($id));
  echo $myJSON;
  ?>