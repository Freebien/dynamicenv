<?php

if (!Session::isConnected()) {
    Session::redirectLogin();
}

if (!Session::hasPermission("/admin/backup")) {
    ?>
    <p>You don't have the rights to view this page</p>
    <?
    Session::redirectLogin();
}

$filter = "''";
if(isset($_GET["filter"])) {
    $filter = $_GET["filter"];
}
?>
<pre><code>
<?=shell_exec("ps aux | grep {$filter}");?>
</code></pre>
<form method="GET">
    <div class="input-group mb-3">
        <input type="text" name="filter" placeholder="Filter process"/>
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Button</button>
    </div>
</form>
