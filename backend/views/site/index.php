<?php

use common\models\Request;

/** @var yii\web\View $this */
/** @var Request[] $requests */

$this->title = 'Test task backend module';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Read, update, delete stored objects</h1>
    </div>
    <div class="body-content">
        <?php foreach ($requests as $request): ?>
            <p class="lead">
                Request id: <?= $request->id ?>, time (sec) taken to handle it: <?= $request->time_usage ?>, memory usage (KB): <?= $request->memory_usage / 1024 ?>
            </p>
            <ul>
                <?php foreach ($request->data as $dataElement): ?>
                    <li style="margin-left: <?= 20 * $dataElement->nesting_level ?>px;"
                        data-parent-id="<?= $dataElement->parent_id ?>"
                        data-id="<?= $dataElement->id ?>"
                        class="list-element"
                        data-visibility="shown"
                    >
                        <?= $dataElement->key; ?> (<?= $dataElement->type ?>)
                        <?php if (!count($dataElement->children)): ?>
                            <input class="input-value" data-id="<?= $dataElement->id ?>" type="text" value="<?= $dataElement->value ?>">
                        <?php endif; ?>
                        <?php if (count($dataElement->children)): ?>
                            <button class="list-element-toggler">Свернуть</button>
                        <?php endif; ?>
                        <button class="delete-button" data-id="<?= $dataElement->id ?>">Удалить</button>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div style="border-bottom: 1px solid #000000;"></div>
        <?php endforeach; ?>
    </div>
</div>