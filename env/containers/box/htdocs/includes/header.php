<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box<?= isset($title) ? " - {$title}" : "" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Box</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/start">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/blog" disabled="true">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vault" disabled="true">Vault</a>
                    </li>
                    <?php
                        if(Session::isConnected() && Session::getUser()->hasRole("admin")) {
                            ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/" tabindex="-1" aria-disabled="true">Admin</a>
                    </li>
                            <?php
                        }
                    ?>
                </ul>
                <form class="form-inline d-flex" method="GET" action="/blog">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <form class="d-flex">
                    <?php if (Session::isConnected()) {
                        ?>
                    <a href="/user" class="btn btn-outline-success">User</a>
                    <a href="/logout" class="btn btn-outline-success">Logout</a>
                        <?php
                    } else {
                        ?>
                    <a href="/login" class="btn btn-outline-success">Login</a>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </nav>
    <div class="col-lg-8 mx-auto p-4 py-md-">
        <main>
            <? if (isset($title)) {?>
                <h1 class="text-body-emphasis"><?= $title ?></h1>
            <? }; ?>
