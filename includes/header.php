<?php
echo '<img frameborder="0" border="0" src="images/site/logo.png" onmouseover="this.src=\'images/site/logo_hover.png\';" onmouseout="this.src=\'images/site/logo.png\';"></img><br><body background="images/site/background.png"></body>';
echo '<a name="top"></a><a href="?page=Index"><img frameborder="0" border="0" src="images/buttons/btn_hd_index.png" onmouseover="this.src=\'images/buttons/btn_hd_index_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_index.png\';"></img></a><a href="?page=News"><img frameborder="0" border="0" src="images/buttons/btn_hd_news.png" onmouseover="this.src=\'images/buttons/btn_hd_news_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_news.png\';"></img></a><a href="?page=Posts"><img frameborder="0" border="0" src="images/buttons/btn_hd_posts.png" onmouseover="this.src=\'images/buttons/btn_hd_posts_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_posts.png\';"></img></a><a href="?page=Downloads"><img frameborder="0" border="0" src="images/buttons/btn_hd_downloads.png" onmouseover="this.src=\'images/buttons/btn_hd_downloads_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_downloads.png\';"></img></a>';
require('config.php');
if(isset($_COOKIE[$cp.'_admin_id'])) { 
echo '<a href="?page=Administration"><img frameborder="0" border="0" src="images/buttons/btn_hd_adminpanel.png" onmouseover="this.src=\'images/buttons/btn_hd_adminpanel_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_adminpanel.png\';"></img></a>';
}
if(!isset($_COOKIE[$cp.'_user_id'])) {
echo '<a href="?page=Login"><img frameborder="0" border="0" src="images/buttons/btn_hd_login.png" onmouseover="this.src=\'images/buttons/btn_hd_login_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_login.png\';"></img></a><a href="?page=Register"><img frameborder="0" border="0" src="images/buttons/btn_hd_register.png" onmouseover="this.src=\'images/buttons/btn_hd_register_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_register.png\';"></img></a>';
}
else {
echo '<a href="?page=Hilfe"><img frameborder="0" border="0" src="images/buttons/btn_hd_help.png" onmouseover="this.src=\'images/buttons/btn_hd_help_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_help.png\';"></img></a><a href="?page=Login&ID=logout"><img frameborder="0" border="0" src="images/buttons/btn_hd_logout.png" onmouseover="this.src=\'images/buttons/btn_hd_logout_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_logout.png\';"></img></a>';
}
echo '<a href="?page=Impressum"><img frameborder="0" border="0" src="images/buttons/btn_hd_impress.png" onmouseover="this.src=\'images/buttons/btn_hd_impress_hover.png\';" onmouseout="this.src=\'images/buttons/btn_hd_impress.png\';"></img></a><hr>';
?>