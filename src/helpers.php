<?php

// Chuyển hướng đến một trang khác
function redirect(string $location): void
{
    header('Location: ' . $location);
    exit();
}