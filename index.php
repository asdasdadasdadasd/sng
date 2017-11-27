<?php
include 'library/config.php';
include 'classes/class.users.php';
include 'classes/class.items.php';
include 'classes/class.auth.php';
include 'classes/class.brands.php';

$module = (isset($_GET['mod']) && $_GET['mod'] != '') ? $_GET['mod'] : '';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

$user = new Users();
$item = new Items();
$auth = new Auth();
$brand = new Brands();


/*
if(isset($_REQUEST['login'])){
  extract($_REQUEST);
  $login = $user->check_login($email,md5($password));
  if($login){
  header('location: index.php');
  }
  else{
  header('location: index.php?auth=error');
  } 
}
*/

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="John Carlo H. Octabio">
    <link rel="icon" href="../../favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" rel="stylesheet">

    <title>SleepNotGo</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    

    <!-- Custom styles for this template -->
    <link href="custom.scss" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div style="margin-left: 24px;">
            <a class="navbar-brand example6" href="index.php"></a>
          </div>
        </div>
        <div id="navbar" class="collapse navbar-collapse roboto">
          <ul class="nav navbar-nav navbar-right">
            <li class=<?php if($module==null){ echo "active";}else{ echo '';}?>><a href="index.php" class="uppercase"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;
            Home</a></li>
            <li class=<?php if($module=="shop"){ echo "active";}else{ echo '';}?>><a href="index.php?mod=shop" class="uppercase"><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;
            Shop</a></li>
            <?php
            if($user->get_session()){?>
              <li class="<?php if($module==cart){ echo "active";}else{ echo '';}?>">
                <a href="index.php?mod=cart"><span class="glyphicon glyphicon-shopping-cart"></span></a>
              </li>
              <li class="dropdown <?php if($module==profile){ echo "";}else{ echo '';}?>">
                <a class="dropdown-toggle" style="font-weight: 600;font-family: 'Roboto';font-size: 13px;" data-toggle="dropdown" href=""><span class="glyphicon glyphicon-user"></span>
                <span class="caret"></span></a>
                <ul class="dropdown-menu" style="background-color: #f7f7f7;">
                  <li class="dropdown-header" style="color: rgba(0,0,0,0.8); font-weight: 500; font-size: 14px;"><?php echo $_SESSION['usr_name'];?></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Account</li>
                  <li style=""><a href="index.php?mod=profile">My Profile</a></li>
                  <li><a id="btn-logout"  href="#">Logout</a></li>
                </ul>
              </li>
              
            <?php
            }else{?>
              <li><a class="uppercase" href="" data-toggle="modal" data-target="#myModal">Login</a></li>
            <?php
            }
            ?>
            
            
          </ul>
        </div><!--/.nav-collapse -->
        
      </div>
      <?php
      $url_str = substr($_SERVER['REQUEST_URI'], 5);
      if(isset($_GET['mod'])){
      ?>
      <div class="nav-helper">
        <div class="container-fluid">
          <a class="shop-directory" href="index.php?mod=<?php echo $_GET['mod'];?>">
            <?php echo ucfirst($_GET['mod']);?>
          </a> /
            <?php 
            if($_GET['mod'] == "shop"){
              if(isset($_GET['brand'])){?>
                <a class="shop-directory" href="index.php?mod=shop&brand=<?php echo $_GET['brand'];?>">
                <?php
                echo $item->get_item_brand($_GET['brand']);
                ?>
                </a>
                <?php
                if(isset($_GET['item'])&&isset($_GET['brand'])){?>
                  / <a class="shop-directory" href="<?php echo $url_str;?>">
                      <?php
                        $dir_name = $item->get_item_and_brand($_GET['item'],$_GET['brand']);
                        if($dir_name){
                          foreach($dir_name as $o);
                          echo $o['item_name'];
                        }
                      ?>
                  </a>
                <?php
                }
                ?>
              <?php
              }else{?>
                <a class="shop-directory" href="index.php?mod=shop">
                <?php
                  echo "All";
                ?>
                </a>
                <?php
                if(isset($_GET['item'])){?>
                  / <a class="shop-directory" href="<?php echo $url_str;?>">
                      <?php
                        echo $item->get_item_name($_GET['item']);
                      ?>
                  </a>
                <?php
                }
              }
            }
            ?>
        </div>
      </div>
      <?php
      }
      ?>
    </nav>
    <?php
    if($module == null){?>
      <div class="header-wrapper">
      <?php
      require_once 'modules/home/header.php';
      ?>
      </div>
    <?php
    }
    ?>
    <div class="main">
    <?php
      switch($module){
        case 'login':
          require_once 'modules/login/index.php';
          break;
        case 'shop':
          require_once 'modules/shop/index.php';
          break;
        case 'profile':
          require_once 'modules/profile/index.php';
          break;
        case 'register':
          require_once 'modules/register/index.php';
          break;
        case 'cart':
          require_once 'modules/cart/index.php';
          break;
        default:
          require_once 'modules/home/index.php';
          break;
      }
    ?>
    </div><!-- /.container -->
    <div class="footer">

    </div>

    <?php
    require_once 'modules/modals/login_modal.php';
    ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>