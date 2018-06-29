<br>

<div class="row justify-content-center">
    <?php echo $pagination ?>
</div>

<table class="table table-responsive-sm table-hover">
    <thead>

        <tr>
            <th colspan="3" class="text-center">Total encontrado: <?php echo $query->Total ?></th>
        </tr>

        <tr>
            <th data-align="left">ID</th>
            <th data-align="left">Nome</th>
            <th data-align="left">Username</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($query->result_array() as $row) {

            echo '<tr>';
                echo '<td>' . $row['ID'] . '</td>';
                echo '<td>' . $row['Nome'] . '</td>';
                echo '<td>' . $row['Username'] . '</td>';
            echo '</tr>';
        }

        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-center">Total encontrado: <?php echo $query->Total ?></th>
        </tr>
    </tfoot>
</table>

<div class="row justify-content-center">
    <?php echo $pagination ?>
</div>
