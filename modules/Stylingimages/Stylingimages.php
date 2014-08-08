<?php
/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author VERSHA <Sarbjit.rvtech@gmail.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/



if (!defined('_PS_VERSION_'))
  exit;
 
class StylingImages extends Module
{
  private $_html = '';

    public function __construct()
  {
    $this->name = 'Stylingimages';
    $this->tab = 'Other_Modules';
    $this->version = '1.0';
    $this->author = 'Kshitiz';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
 
  $this->bootstrap = true;
    parent::__construct();
 
    $this->displayName = $this->l('Marketing Spots');
    $this->description = $this->l('Add images for Styling Mugs');
 
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
 if (!Configuration::get('STYLINGIMAGE_NAME'))      
      $this->warning = $this->l('No name provided');
  }

  public function install()
  {


  $query = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'marketingspots (
                                         id int(11) NOT NULL AUTO_INCREMENT,
                                          `image` varchar(255) NOT NULL,
                                          `image_name` varchar(255) NOT NULL,
                                          `image_description` varchar(255) NOT NULL,
                                          status int(1) NOT NULL,PRIMARY KEY (`id`) 
                                       )';


 
 if(!Db::getInstance()->Execute($query)){
     
 
  return false;
 }
    return parent::install() &&
    Configuration::updateValue('STYLINGIMAGE_NAME', 'Styling Image');
}

public function uninstall()
  {
     $query='DROP TABLE '._DB_PREFIX_.'marketingspots';
     Db::getInstance()->Execute($query);
    return (parent::uninstall()&& Configuration::deleteByName('STYLINGIMAGE_NAME'));
  }


public function getContent()
  {
    $this->_html = '<h2>'.$this->displayName.'</h2>';
    $this->_html .= '<br />';
   $this->_displaylinks();
   return $this->_html;
  }

   private function _displaylinks()
    {
    
    $module_link =  Tools::safeOutput($_SERVER['REQUEST_URI']);
    $path=_PS_ROOT_DIR_."/modules/Stylingimages/images/";



    if(isset($_GET['deact'])){
      $id=$_GET['deact'];
        $query="update   "._DB_PREFIX_."marketingspots set status='0' where id='".$id."'" ; 
     Db::getInstance()->Execute($query);
    }

    if(isset($_GET['act'])){
        $id=$_GET['act'];
        $query="update   "._DB_PREFIX_."marketingspots set status='1' where id='".$id."'" ;
        
     Db::getInstance()->Execute($query);
    }
    if(isset($_GET['delete_item'])){
      $id=$_GET['delete_item'];
      $query="delete from    "._DB_PREFIX_."marketingspots  where id='".$id."'" ;
      Db::getInstance()->Execute($query);
    }

    
    if(isset($_POST['save'])){
      extract($_REQUEST);
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $_FILES["image_name"]["name"]);
      $extension = end($temp);
      if($name_file==''){
        $error="Please Fill All Field...";



      }
      else if ((($_FILES["image_name"]["type"] == "image/gif")
      || ($_FILES["image_name"]["type"] == "image/jpeg")
      || ($_FILES["image_name"]["type"] == "image/jpg")
      || ($_FILES["image_name"]["type"] == "image/pjpeg")
      || ($_FILES["image_name"]["type"] == "image/x-png")
      || ($_FILES["image_name"]["type"] == "image/png"))
      && ($_FILES["image_name"]["size"] < 200000)
      && in_array($extension, $allowedExts)) {
      move_uploaded_file($_FILES["image_name"]["tmp_name"],$path . $_FILES["image_name"]["name"]);
      $file_name=$_FILES["image_name"]["name"];
      $image_description=Tools::getValue('image_desc');
      //echo "<pre>"; print_r($_POST); die;
      $sql="insert into  " ._DB_PREFIX_."marketingspots values('','$file_name','$name_file','$image_description','1')" ; 
      if(Db::getInstance()->Execute($sql)){
        $error='Data Saved Sucessfully';
      }
        else
      {
        $error="Data insertion Failed ,Try Again !";
      }

    }else{

      $error="invalid File";
    }
        $this->_html.=$error."<br>";

    }

   
      $this->_html .="<style> 
                        table{
                              margin: auto;
                             }  
                      </style> 
    <table class='spot_table'>
    <form action='".$module_link ."&idss=1' method='post' enctype='multipart/form-data'> 
        <tr>
            <td>Upload File</td>
            <td><input type='file' name='image_name'/> </td> 
        </tr> 
        <tr>
            <td>Image Name</td>
            <td><input type='text' name='name_file'/> </td> 
        </tr>
        <tr>
            <td>Image Description</td>
            <td><input type='text' name='image_desc'/> </td> 
        </tr>
         <tr>
             <td colspan='2'><input type='submit' name='save' value='Save'/> </td> 
        </tr> 
    </form> 
    </table> ";
    $this->display_data($id,$module_link); 
}


private function display_data($id,$module_link){

 $path=$this->_path."images/";
 $display_content="<table border='2'class='spot_display' >
    <tr>
    <th>Name</th>
    <th>Image</th>
    <th>Status</th>
    <th>Delete</th>
  ";
  $sql = 'SELECT * FROM '._DB_PREFIX_.'marketingspots order by id desc limit 3';
  if ($results = Db::getInstance()->ExecuteS($sql))
    foreach ($results as $row){ 
     if($row['status']==1){
      $status="<a href='".$module_link."&idss=1&deact=".$row['id']."' title='Click to Deactivate'>Deactivate</a>";
     } else{ 
        $status="<a href='".$module_link."&idss=1&act=".$row['id']."' title='Click to Activate'>Activate</a>";          
     } 
    $display_content_inside.="<tr><td>".$row['image_name']."</td><td><img height='100px' width='150px' src='".$path.$row['image']."'></td>
    <td>".$status."</td>
    <td><a href='".$module_link."&idss=1&delete_item=".$row['id']."'>Delete</a></td> 
    <tr>";
    }
    $display_content.=$display_content_inside."</table>";
    $this->_html.=$display_content;
}    


}
?>