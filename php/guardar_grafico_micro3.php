<?php
if (isset($_POST['image'])) {
    $imageData = $_POST['image'];
    $imageData = str_replace("data:image/png;base64,", "", $imageData);
    $imageData = base64_decode($imageData);
    file_put_contents("grafico.png", $imageData);
    echo "success";
} else {
    echo "error";
}
