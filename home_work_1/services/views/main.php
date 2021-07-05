<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .string {
        display: flex;
        margin-bottom: 5px;
    }

    .pic {
        width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 5px;
    }

    .pic img {
        width: 100%;
        height: 100%;
    }
</style>
<body>
<?php if ($folder): ?>
    <div class="string">
        <a href="?path=.." class="string">
            <div class="pic">
                <img src="<?= $picFolder ?>" alt="">
            </div>
            <span> ... </span>
        </a>
        <?php if (isRootPath($currentPath)): ?>
            (достигнут верхний уровень)
        <?php endif; ?>
    </div>
    <?php foreach ($folder as $item): ?>
        <a href="?path=<?= $item['name'] ?>" class="string">
            <div class="pic">
                <img src="<?= $item['pic'] ?>" alt="">
            </div>
            <span>
            <?= $item['name'] ?>
            </span>
        </a>
    <?php endforeach; ?>
    <br>
    <a href="?session=clear">Вернуться в папку по умолчанию</a>
<?php endif; ?>
</body>
</html>