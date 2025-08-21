<?php
class Controller {
    protected function view($path, $data = []) {
        extract($data);
        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/$path.php";
        include __DIR__ . "/../views/layout/footer.php";
    }
    protected function redirect($to) {
        header("Location: $to");
    }
}
