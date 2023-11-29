<!DOCTYPE html>
<html lang="en">
    <?php 
    include __DIR__."/header.php";
    ?>
<body>
    <div class="site-container">
        <?php include __DIR__."/menu.php"; ?>
        <main>
            <?php include __DIR__."/levelBar.php"; ?>
            <div id = "content-window">
                <?php include $templatePath; ?>
            </div>
        </main>
    </div>
</body>
</html>