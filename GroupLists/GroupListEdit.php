<?php

require("GroupList.class.php");
if ($_POST['method'] == 'save') {
    $controller = new GroupList();

    $controller->list_name = $_POST['list_name'];
    $controller->active    = $_POST['active'];
    if ($save = $controller->save()) {
        $data = array('list_name'=>$controller->list_name,'list_id'=>$controller->id);
        echo json_encode($data);
    } else {
        echo "No";
}
} else {
    echo "no";
}

?>