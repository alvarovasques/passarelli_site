<?php
	if (!isset($breadcrumb)) {
		$breadcrumb = array(
			'Home' => HOME_URL
		);
	}
	?>
	<ul class="breadcrumb">
    <?php
		$i = 0;
        $c = count($breadcrumb);
		foreach ($breadcrumb as $label => $link) {
            $i++;
        ?>
        <li>
            <a href="<?php echo $link; ?>">
            <?php
                echo $label;
                
                if ($i != $c) {
                    echo ' »';
                }
                ?>
            </a>
        </li>
    <?php
		}
		?>
	</ul>