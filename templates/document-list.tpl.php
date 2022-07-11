<link rel="stylesheet" type="text/css" href="<?php print module_path(); ?>/assets/list.css" />

<h1 class="list-header">Committee Documents</h1>

<div class="container">

    <div>

        <div class="table">
            <div class="table-row first">
                <p class="table-header">Shared By</p>
                <p class="table-header">Title</p>
                <p class="table-header">Type</p>
                <p class="table-header">Size</p>
                <p class="table-header">Download</p>
                <p class="table-header"></p>
            </div>



            <?php foreach($documents as $id => $doc): ?>
                
                <div class="table-row data">
                <p class="table-cell"><?php print $doc["targetNames"]; ?></p>
                    <p class="table-cell">
                        <a href="/file/download/<?php print $id; ?>"><?php print $doc["Title"]; ?></a>
                    </p>
                    <p class="table-cell"><?php print $doc["FileExtension"]; ?></p>
                    <p class="table-cell"><?php print $doc["fileSize"]; ?></p>
                    <p class="table-cell icon-cell">
                        <a href="/file/download/<?php print $doc["Id"]; ?>"><i class="fa-solid fa-download"></i></a>
                    </p>
                    <p class="table-cell"></p>

                </div>
            
            <?php endforeach; ?>

        </div>
    </div>
    
</div>

<style>
    .table-row p.table-cell,
    .table-row p.table-header {
        padding:7px;
        padding-left:13px;
        padding-right:13px;
    }
</style>


