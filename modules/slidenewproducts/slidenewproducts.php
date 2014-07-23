<?php

class SlideNewProducts extends Module
{
	private $_html = '';
	private $_directory;
	private $_filename;
	private $_filename_http;
	private $_postErrors = array();

	function __construct()
	{
		$this->name = 'slidenewproducts';
		$this->tab = 'Tools';
		$this->version = 0.1;

		parent::__construct(); // The parent construct is required for translations

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Slide new products');
		$this->description = $this->l('Shows a slideshow of new products in your home page');
	}

	function install()
	{
		if (!Configuration::updateValue('NEW_PRODUCTS_NBR', 50) OR !parent::install() OR !$this->registerHook('home') OR !$this->registerHook('header'))
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitslidenewproducts'))
		{
			$nbr = intval(Tools::getValue('nbr'));
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of product');
			else
				Configuration::updateValue('NEW_PRODUCTS_NBR', $nbr);
			if (isset($errors) AND count($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$output = '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('Number of products to display').'</label>
				<div class="margin-form">
					<input type="text" size="5" name="nbr" value="'.Tools::getValue('nbr', Configuration::get('NEW_PRODUCTS_NBR')).'" />
					<p class="clear">'.$this->l('The number of products displayed on homepage (default: 10)').'</p>
					
				</div>
				<center><input type="submit" name="submitslidenewproducts" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		return $output;
	}

	function hookHome($params)
    {
		global $smarty;
		$currency = new Currency(intval($params['cookie']->id_currency));
		$newProducts = Product::getNewProducts(intval($params['cookie']->id_lang), 0, Configuration::get('NEW_PRODUCTS_NBR'));
		$new_products = array();
		if ($newProducts)
			foreach ($newProducts AS $newProduct)
				$new_products[] = $newProduct;

		$smarty->assign('new_products', $new_products);
		return $this->display(__FILE__, 'slidenewproducts.tpl');
	}
	
	function hookHeader($params)
	{
	 	global $smarty;
		
		ob_start();
		?>
        
		<link rel="stylesheet" href="<?php echo $this->_path;?>css/slidenewproducts.css" type="text/css" media="screen" charset="utf-8" />
		<script src="<?php echo $this->_path;?>js/startstop-slider.js" type="text/javascript"></script>
	
	<?php	
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}
