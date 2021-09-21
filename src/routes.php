<?php

function getRoutes()
{
    return array(
        "/menu"             => "menu.php"
        ,"/users"           => "users.php"
        ,"/documents"       => "documents.php"
        ,"/edit/user"       => "editUser.php"
        ,"/edit/document"   => "editDocument.php"
        ,"/delete/document" => "deleteDocument.php"
        ,"/delete/user"     => "deleteUser.php"
    );
}