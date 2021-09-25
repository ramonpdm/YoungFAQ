<?php
require('../classes/dbLink.php');

if (isset($_GET["q"])) {
    $q = $_GET["q"];

    $topic = new Topic();
    if (strlen($q) > 0) {
        $topic->select("*", "topics", "title LIKE '%$q%'");
        $result = $topic->sql;

        if ($result->num_rows > 0) {
?>
            <h3>Resultados de búsqueda</h3>
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="divline"></div>
                <div class="blocktxt">
                    <a href="/forum?topic=<?php echo $row["id"]; ?>" target="_blank"><?php echo $row["title"]; ?></a>
                    <div class="pull-right" style="color: #989c9e;">
                        <?php echo date('d M Y', strtotime($row['date_created'])) . PHP_EOL; ?>
                    </div>
                </div>

            <?php
            }
        } else { ?>

            <div class="divline"></div>
            <div class="blocktxt posttext" style="width: 100%">
                No hay sugerencias para tu búsqueda. Intenta combinando otras palabras clave.
            </div>
<?php
        }
    }
}
?>