                <div class="col-lg-4 col-md-4">
                    <?php
                        $conn = new database();
                        $conn->select("categories", "*");
                        if($conn->on){ 
                        $result = $conn->sql;
                        if (mysqli_num_rows($result) > 0) {
                            
                        ?>
                        <!-- -->
                        <div class="sidebarblock">
                            <h3>Categorías</h3>
                            <div class="divline"></div>
                            <div class="blocktxt">
                                <ul class="cats">
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <li><a href="/category/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?><span class="badge pull-right"><?php echo $row['count']; ?></span></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } 
                        }?>

                        <!-- -->
                        <div class="sidebarblock">
                            <h3>Mis Publicaciones</h3>
                            <div class="divline"></div>
                            <div class="blocktxt">
                                <?php echo  $conn->getUserPost(); ?>
                            </div>
                        </div>


                    </div>