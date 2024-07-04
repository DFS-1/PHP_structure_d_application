<?php require_once './src/config/config.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link rel="stylesheet" href=<?= ASSETS . "./css/home/index.css" ?>>
    <script defer src=<?= ASSETS . "./js/main.js" ?>></script>
</head>

<body>
    <header>
        <?php include TEMPLATE_PARTS . '/nav.php' ?>
        <h1>EARTH</h1>
        <p>ENDLESS POTENTIAL</p>
        <button>EXPLORE</button>
    </header>
    <main>
        <section id="services">
            <article>
                <div>
                    <img src=<?= ASSETS . "./images/webDesign.jpg" ?> alt="">
                </div>
                <h2 class="servicesH2">Web Design</h2>
                <p>Custom web design for small businesses, we help you capture new audiences and
                    increase your sales.</p>
            </article>
            <article>
                <div>
                    <img src=<?= ASSETS . "./images/graphicDesign.jpg" ?> alt="">
                </div>
                <h2>Graphic Design</h2>
                <p>Logos, merchandise and more. Anyone can create nice graphics. We think it’s better to create
                    memorable ones.</p>
            </article>
            <article>
                <div>
                    <img src=<?= ASSETS . "./images/contentCreation.jpg" ?> alt="">
                </div>
                <h2>Content Creation</h2>
                <p>Want to attract people to your website? You have to have the best content in the world. That’s what
                    we do.</p>
            </article>
        </section>
        <section class="sectionImgH2P">
            <article>
                <h2>ABOUT US</h2>
                <p>I made it so it is super easy to update and so that it flows perfectly with my tutorials. Lots of
                    love and hundreds of hours went into making it. I hope you love it as much as I do. I wish you the
                    best of luck with your business, enjoy the adventure.</p>
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