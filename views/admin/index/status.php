<?php 

head(array('title' => 'CsvImport', 'bodyclass' => 'primary', 'content_class' => 'horizontal-nav'));

?>
<h1>CsvImport</h1>
<ul id="section-nav" class="navigation">
    <li class="">
        <a href="<?php echo uri('csv-import') ?>">Import Items</a>
    </li>
    <li class="current">
        <a href="<?php echo uri('csv-import/index/status') ?>">Status</a>
    </li>
</ul>

<div id="primary">
    <h2>Status</h2>
    <?php echo flash(); ?>
    <form id="csvimport" name="csvimport" method="post">
        <?php
            if (!empty($err)) {
                echo '<p class="error">' . $err . '</p>';
            }
        ?>
        <table class="simple" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Import Date</th>
                    <th>Csv File</th>
                    <th>Item Count</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($csvImports as $csvImport): ?>
                <tr>
                    <td><?php echo $csvImport->added; ?></td>
                    <td><?php echo $csvImport->csv_file_name; ?></td>
                    <td><? echo $csvImport->getImportedItemCount(); ?> / <?php echo $csvImport->getItemCount(); ?></td>
                    <td><? echo $csvImport->status; ?></td>
                    <?php
                    if ( $csvImport->status == CsvImport_Import::STATUS_COMPLETED_IMPORT ||
                         $csvImport->status == CsvImport_Import::STATUS_IMPORT_ERROR_INVALID_FILE_DOWNLOAD) {
                        echo '<td><a onclick=" return csvConfirmUndoImport();" href="' . uri('csv-import/index/undo-import/id/' . $csvImport->id) . '">Undo Import</a></td>';
                    } else if ($csvImport->status == CsvImport_Import::STATUS_COMPLETED_UNDO_IMPORT || 
                               $csvImport->status == CsvImport_Import::STATUS_IMPORT_ERROR_INVALID_CSV_FILE) {
                        echo '<td><a href="' . uri('csv-import/index/clear-history/id/' . $csvImport->id) . '">Clear History</a></td>';
                    } else {
                        echo '<td></td>';
                    }
                    ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>

<?php foot(); ?>