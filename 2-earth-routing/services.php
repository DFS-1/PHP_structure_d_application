<?php require_once './src/config/config.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link rel="stylesheet" href=<?= ASSETS . "./css/services/index.css" ?>>
    <script defer src=<?= ASSETS . "./js/main.js" ?>></script>
</head>

<body>
    <header>
        <?php include TEMPLATE_PARTS . '/nav.php' ?>
        <h1>SERVICES</h1>
    </header>
    <main>
        <section class="sectionImgH2P">
            <article>
                <h2>Web Design</h2>
                <p>We create custom web design for small businesses, this will help you capture new audiences and
                    increase your sales. Contact us by calling, emailing or filling out our form. You will receive a
                    free quote by email within 24 hours.</p>
            </article>
            <article>
                <img src=<?= ASSETS . "./images/servicesWebDesign.jpg" ?> alt="trees with mountains in the background">
            </article>
        </section>
        <section class="sectionImgH2P column-reverse">
            <article>
                <h2>Graphic Design</h2>
                <p>We specialize in logos, merchandise and more. Anyone can create nice graphics but it’s much better to
                    create memorable ones. Contact us by calling, emailing or filling out our form. You will receive a
                    free quote by email within 24 hours.</p>
            </article>
            <article>
                <img src=<?= ASSETS . "./images/servicesGraphicDesign.jpg" ?> alt="river with mountains in the background">
            </article>
        </section>
        <section class="sectionImgH2P">
            <article>
                <h2>Content Writing</h2>
                <p>Want to attract people to your website? You have to have the best content in the world. Our content
                    writers will create award willing content for you. Contact us by calling, emailing or filling out
                    our form. You will receive a free quote by email within 24 hours.</p>
            </article>
            <article>
                <img src=<?= ASSETS . "./images/servicesContentWriting.jpg" ?> alt="hills with mountains in the background">
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