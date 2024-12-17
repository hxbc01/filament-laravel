<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('components/head') ?>
</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <?= view('components/navbar') ?>
    </header>

    <main class="main">
        <?= view('components/section') ?>
    </main>

    <footer id="footer" class="footer">
        <?= view('components/footer') ?>
    </footer>
    <?= view('components/js') ?>

</body>

</html>
