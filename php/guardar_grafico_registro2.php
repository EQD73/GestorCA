<?php
if (isset($_POST['image'])) {
    $imageData = $_POST['image'];
    $imageData = str_replace("data:image/png;base64,", "", $imageData);
    $imageData = base64_decode($imageData);
    file_put_contents("../images/graficos/graficor2.png", $imageData);
    echo "success";
} else {
    echo "error";
}
