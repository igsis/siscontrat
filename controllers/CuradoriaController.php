<?php

if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class CuradoriaController extends MainModel
{

}
