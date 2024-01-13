<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/global.css">

    <?php foreach ($cssNames as $value): ?>
        <link rel="stylesheet" href="<?= '../../public/css/'.$value.'.css'; ?>">
    <?php endforeach; ?>

    <?php foreach ($jsNames as $value): ?>
        <script defer src="<?= '../../public/scripts/'.$value.'.js'; ?>"></script>
    <?php endforeach; ?>

    <title><?= 'NQ '.ucfirst($template) ?></title>
</head>