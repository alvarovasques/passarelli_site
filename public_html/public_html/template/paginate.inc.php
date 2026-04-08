<?php
	if ($this->last > 1) {
		$num_btn = 5;
		$inicio  = 1;
		$fim     = $num_btn;
		
		if ($this->page > 1) {
			$inicio = $this->page - floor($num_btn / 2); 
		}
		
		if ($inicio < 1) {
			$inicio = 1;
		}
		
		$fim = $inicio + ($num_btn - 1);
		
		if ($fim > $this->last) {
			$inicio -= $fim - $this->last;
			$fim     = $this->last;
		}
		
		if ($inicio < 1) {
			$inicio = 1;
		}
	?>    
    <ul class="pagi aRight">
        <li> <a class="menor ativo" href="<?php echo $this->previous(); ?>"> &lt; </a> </li>
    <?php
		for ($i = $inicio; $i <= $fim; $i++) {
		?>
		<li><a href="<?php echo $this->linkTo($i); ?>" <?php echo $this->page == $i ? 'class="ativo"' : ''; ?>><?php echo $i; ?></a></li>
    <?php
        }
        ?>
        <li> <a class="ativo maior" href="<?php echo $this->next(); ?>">  &gt;</a> </li>
    </ul>
 <?php
    }