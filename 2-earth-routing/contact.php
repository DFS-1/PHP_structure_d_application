<?php require_once './src/config/config.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link rel="stylesheet" href=<?= ASSETS . "./css/contact/index.css" ?>>
    <script defer src=<?= ASSETS . "./js/main.js" ?>></script>
</head>

<body>
    <header>
        <?php include TEMPLATE_PARTS . '/nav.php' ?>
        <h1>CONTACT US</h1>
    </header>
    <main>
        <section id="contactFormSection">
            <h2>Get In Touch</h2>
            <form id="contactForm" action="">
                <div>
                    <input class="formControl" type="text" placeholder="Your Name">
                </div>
                <div>
                    <input class="formControl" type="tel" name="" id="" placeholder="Phone Number">
                </div>
                <div>
                    <input class="formControl" type="email" name="" id="" placeholder="Email">
                </div>
                <div>
                    <textarea class="formControl" rows="5" name="" id="" placeholder="Message"></textarea>
                </div>
                <button>SEND NOW</button>
            </form>
        </section>
    </main>
    <?php include TEMPLATE_PARTS . '/footer.php' ?>
</body>

</html>