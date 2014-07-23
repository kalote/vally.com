<?php

class SlideProducts extends Module
{
	private $_html = '';
	private $_directory;
	private $_filename;
	private $_filename_http;
	private $_postErrors = array();

	function __construct()
	{
		$this->name = 'slideproducts';
		$this->tab = 'Tools';
		$this->version = 0.2;

		parent::__construct(); // The parent construct is required for translations

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Slide featured products');
		$this->description = $this->l('Shows a slideshow of products in your home page');
	}

	function install()
	{
		if (!Configuration::updateValue('SLIDE_PRODUCTS_NBR', 50) OR !parent::install() OR !$this->registerHook('home') OR !$this->registerHook('header'))
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitslideproducts'))
		{
			$nbr = intval(Tools::getValue('nbr'));
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of product');
			else
				Configuration::updateValue('SLIDE_PRODUCTS_NBR', $nbr);
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
					<input type="text" size="5" name="nbr" value="'.Tools::getValue('nbr', Configuration::get('SLIDE_PRODUCTS_NBR')).'" />
					<p class="clear">'.$this->l('The number of products displayed on homepage (default: 10)').'</p>
					
				</div>
				<center><input type="submit" name="submitslideproducts" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		return $output;
	}

	function hookHome($params)
	{
		global $smarty;
		$category = new Category(1);
		$nb = intval(Configuration::get('SLIDE_PRODUCTS_NBR'));
		$products = $category->getProducts(intval($params['cookie']->id_lang), 1, ($nb ? $nb : 50));
		$smarty->assign(array(
			'category' => $category,
			'products' => $products,
			'currency' => new Currency(intval($params['cart']->id_currency)),
			'lang' => Language::getIsoById(intval($params['cookie']->id_lang)),
			'productNumber' => count($products)
		));
		return $this->display(__FILE__, 'slideproducts.tpl');
	}
	
	function hookHeader($params)
	{
	 	global $smarty;
		
		ob_start();
		?>
        
		<link rel="stylesheet" href="<?php echo $this->_path;?>css/slideproducts.css" type="text/css" media="screen" charset="utf-8" />
		<script src="<?php echo $this->_path;?>js/startstop-slider.js" type="text/javascript"></script>
	
	<?php	
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}
