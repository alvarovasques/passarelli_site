    <h1>
    <?php
        echo $item->titulo;
        ?>
    </h1>
	
    <ul class="autor">
		<li>
			<span class="autor">
            <?php
                echo 'por ' . $item->autor . ' |  ' . date('d.m.Y',strtotime($item->data)) . ' | ';
                ?>
            </span>
		</li>
		<li>
			<!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
            </div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51ad01b339bb4c3f"></script>
			<!-- AddThis Button END -->
		</li>
	</ul>
	<hr class="space" />

	<div class="span-8 append-half">
    <?php
        $tem_img = !empty($item->imagens);
        exibeMidiaFancy(array_shift($item->imagens),'a','galeria');
        
        foreach ($item->imagens as $m) {
            echo '<a href="' . getMidiaLink($m) . '" class="gaFancyBox hide" rel="galeria"></a>';
        }
        
        if (!empty($item->video)) {
            if ($tem_img) {
        ?>
        <hr class="space" />
    <?php
            }
            
            exibeMidia($item->video[0],'',array(320,240));
        }
        ?>
	</div>
    	
<?php
    echo $item->texto;  
    ?>
	<div class="clear"></div>