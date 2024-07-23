<nav>
    <div>
        <img src=<?= ASSETS . "./images/logo.png" ?> alt="">
    </div>
    <ul class="visible">
        <li><a href="./index.php?page=home">HOME</a></li>
        <li><a href="./index.php?page=about">ABOUT</a></li>
        <li><a href="./index.php?page=services">SERVICES</a></li>
        <li><a href="./index.php?page=contact">CONTACT</a></li>
    </ul>
    <button id="burger">
        <img class="burgerIcon burgerVisible" src=<?= ASSETS . "./images/burger.svg" ?> width="50" alt="">
        <img class="burgerIcon" src=<?= ASSETS . "./images/burger-cross.svg" ?> width="50" alt="">
    </button>
</nav>