<?php
class Paginate
{
    const NPP_NOT_ZERO = 'uhul';
    const ONLY_NUMBERS = 1;
    
    public $link;
    public $total;
    public $npp;
    public $page;
    public $start = 1;
    public $last;
    public $defaultLink = 'javascript:void(0)';

    public function __construct($total, $npp, $page = 1, $link = "?pagina=%d")
    {
        $this->total = (int) $total;
        $this->npp   = (int) $npp;
        if (!$this->npp) {
            die(Paginate::NPP_NOT_ZERO);
        }
        $this->last = ceil($this->total/$this->npp);
        $this->page = (int) $page;
        if ($this->page > $this->last || $this->page < $this->start) {
            $this->page = $this->start;
        }
        $this->link  = $link;
    }

    protected function numbers()
    {
        echo "<ul>";
        for ($i = $this->start, $n = ceil($this->total/$this->npp); $i < $n; $i++) {
            echo sprintf('<li><a href="%s" title="%s">%s</a></li>', $this->linkTo($i), $i, $i);
        }
        echo "<ul>";
    }
    
    public function previous($returnNull = false) 
    {
        return ($this->page > $this->start) ? $this->linkTo($this->page -1) : ($returnNull ? null : $this->defaultLink);
    }
    
    public function next($returnNull = false) 
    {
        return ($this->page < $this->last) ? $this->linkTo($this->page +1) : ($returnNull ? null : $this->defaultLink);
    }    
    
    public function render($file) 
    {
        if (is_integer($file)) {
            switch ($file) {
			
			}
        }
        ob_start();
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function linkTo($index)
    {
        return sprintf($this->link, $index);
    }
	
	public function getInitial()
	{
		return ($this->page - $this->start) * $this->npp;
	}
	
	public function getNpp()
	{
		return $this->npp;
	}
};