    <h1>
    <?php
        echo $pagina->titulo;
        ?>
    </h1>
    
<?php
    echo $pagina->texto;
    ?>

	<hr class="space" />
<?php
    foreach ($itens as $item_list) {
        $item_list->link = seo_link($siteConfig->modulo,$item_list);
    ?>
    <h2 class="margin-bottom0">
        <a href="<?php echo $item_list->link; ?>">
        <?php
            echo $item_list->titulo;
            ?>
        </a>
    </h2>
    <p>
        <a href="<?php echo $item_list->link; ?>">
        <?php
            echo $item_list->resumo;
            ?>
        </a>
    </p>
<?php
    }
    ?>
    <div class="clear"></div>