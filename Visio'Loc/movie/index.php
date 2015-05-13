<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

$page = filter_input(INPUT_GET, "page");

$maxPage = ceil(countAllMovies() / NB_PAGINATION);
//debug($maxPage);
?>
<!DOCTYPE html>
<html>
    <?php getHeaderHtml("Films"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <div class="container">
            <div class="center-block">
                <?php
                $newMovies = getPageMovie(1);
                if (count($newMovies) > 0) {
                    ?>
                    <h2><span class="glyphicon glyphicon-list"></span> Films</h2>
                    <h5>Liste des films</h5><hr/>
                    <div class="row">
                        <?php
                        foreach ($newMovies as $movie) {
                            getMovieItem($movie);
                        }
                        //debug(getNewMovies());
                        ?> 
                    </div><?php
                }
                ?>
                <nav>
                    <ul class="pagination">
                        <li class="<?php echo ($page <= 1) ? "disabled" : ""; ?>">
                            <a href="<?php echo "?page=".($page-1); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                        if ($maxPage <= MAX_BUTTON_PAGINATION) {
                            for ($i = 1; $i <= $maxPage; $i++) {
                                ?>
                                <li><a href="<?php echo "?page=$i" ?>"><?php echo $i;?></a></li>
                                <?php
                            }
                        }  else {
                            for ($i = 1; $i <= floor($maxPage / 2); $i++) {
                                ?>
                                <li><a href="<?php echo "?page=$i" ?>"><?php echo $i;?></a></li>
                                <?php
                            }
                            for ($i = $maxPage; $i <= $maxPage-floor($maxPage / 2); $i--) {
                                ?>
                                <li><a href="<?php echo "?page=$i" ?>"><?php echo $i;?></a></li>
                                <?php
                            }
                        }
                        ?>
                        <li class="<?php echo ($page == $maxPage) ? "disabled" : ""; ?>">
                            <a href="<?php echo "?page=".($page+1); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
<?php getFooter(); ?>
    </body>
</html>
