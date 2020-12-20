<?php if($_SESSION["alerts"]): ?>
    <?php foreach($_SESSION["alerts"] as $alert): ?>
        <div class="alert alert-<?= $alert["type"] ?> alert-dismissible">
            <?= $alert["message"] ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endforeach; ?>
    <?php $_SESSION["alerts"] = []; ?>
<?php endif; ?>