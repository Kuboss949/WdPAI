<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../public/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/global.css">

    <?php foreach ($cssNames as $value): ?>
        <link rel="stylesheet" href="<?= '../../public/css/' . $value . '.css'; ?>">
    <?php endforeach; ?>

    <script defer src="../../public/scripts/logout.js"></script>

    <?php foreach ($jsNames as $value): ?>
        <?php
        $isModuleScript = preg_match('/^module\.[a-zA-Z0-9_]+$/', $value);
        $isExternalLink = strpos($value, 'https://') === 0 || strpos($value, 'http://') === 0;

        if ($isExternalLink) {
            $scriptType = 'module';
            $scriptPath = $value;
        } else {
            $scriptType = $isModuleScript ? 'module' : 'text/javascript';
            $scriptPath = $isModuleScript ? '../../public/scripts/' . substr($value, 7) . '.js' : '../../public/scripts/' . $value . '.js';
        }
        ?>
        <script defer type="<?= $scriptType ?>" src="<?= $scriptPath ?>"></script>
    <?php endforeach; ?>
    <title><?= 'NQ ' . ucfirst($template) ?></title>
</head>