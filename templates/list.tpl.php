
<h1>OCDLA Committees</h1>

<br />

<div class="container">
    <?php foreach ($committees as $committee) : ?>

        <h3>
            <a href="<?php print $committee["URL"]; ?>"><?php print $committee["Name"]; ?></a>
        </h3>

    <?php endforeach; ?>
</div>