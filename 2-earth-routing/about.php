<?php require_once './src/config/config.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link rel="stylesheet" href=<?= ASSETS . "./css/about/index.css" ?>>
    <script defer src=<?= ASSETS . "./js/main.js" ?>></script>
</head>

<body>
    <header>
        <?php include TEMPLATE_PARTS . '/nav.php' ?>
        <h1>WHO WE ARE</h1>
    </header>
    <main>
        <section class="sectionImgH2P column-reverse">
            <article>
                <h2>OUR MISSION</h2>
                <p>Hello, my name is Tyler Moore and with the help of many people I made this template. I made it so it
                    is super easy to update and so that it flows perfectly with my tutorials. Lots of love and hundreds
                    of hours went into making it. I hope you love it as much as I do.<br><br>
                    I wish you the best of luck with your business, enjoy the adventure.</p>
            </article>
            <article>
                <img src=<?= ASSETS . "./images/aboutUs.jpg" ?> alt="lake with mountains in the background">
            </article>
        </section>
        <section id="talkToUs">
            <h2>TALK TO US</h2>
            <p>Have any questions? We are always open to talk about your business,<br>new projects, creative
                opportunities
                and how we can help you.</p>
            <button>GET IN TOUCH</button>
        </section>
    </main>
    <?php include TEMPLATE_PARTS . '/footer.php' ?>
</body>

</html>