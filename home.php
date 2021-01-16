<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>

<div id="welcome">
    <h2>Welcome to PHP Motors!</h2>
    <div id="delorean-text">
        <h3>DMC Delorean</h3>
        <p>
            3 Cup holders<br>
            Superman doors<br>
            Fuzzy dice!
        </p>
    </div>
    <div id="img-container">
        <img src="./images/site/own_today.png" alt="Own Today button" id="img-button">
        <img src="./images/delorean.jpg" alt="Image of a DMC Delorean" id="img-car">
    </div>
</div>
<div id="content">
    <div id="upgrades">
        <h3>Delorean Upgrades</h3>
        <div id="fig-box">
            <figure>
                <img src="./images/upgrades/flux-cap.png" alt="flux capacitor">
                <figcaption><a href="#">Flux Capacitor</a></figcaption>
            </figure>
            <figure>
                <img src="./images/upgrades/flame.jpg" alt="flame Decals">
                <figcaption><a href="#">Flame Decals</a></figcaption>
            </figure>
            <figure>
                <img src="./images/upgrades/bumper_sticker.jpg" alt="Bumper Stickers">
                <figcaption><a href="#">Bumper Stickers</a></figcaption>
            </figure>
            <figure>
                <img src="./images/upgrades/hub-cap.jpg" alt="Hub Caps">
                <figcaption><a href="#">Hub Caps</a></figcaption>
            </figure>
        </div>
    </div>

    <div id="reviews">
        <h3>DMC Delorean Reviews</h3>
        <ul>
            <li>"So fast its almost like traveling in time." (4/5)</li>
            <li>"Coolest ride on the road." (4/5)</li>
            <li>"I'm feeling Marty McFly!" (5/5)</li>
            <li>"The most futuristic ride of our day." (4.5/5)</li>
            <li>"80's livin and I love it! (5/5)</li>
        </ul>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>