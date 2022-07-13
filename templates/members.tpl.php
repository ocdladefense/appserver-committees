<h1 class="list-header">Committee Members</h1>



<ul>
    <?php foreach($members as $member) : ?>
        <li>
            <a href="/directory/members/<?php print $member["Id"]; ?>">
                <?php print $member["Name"] ." - ". $member["role"]; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>