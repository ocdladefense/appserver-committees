<h1 class="list-header">Committee Members</h1>

<br />

<div>
    <?php foreach($members as $member) : ?>
        <p><?php print $member["Name"] ." - ". $member["role"]; ?></p>
    <?php endforeach; ?>
</div>