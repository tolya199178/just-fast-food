<div id="alertMessage" class="error"></div>
<div id="header">
  <div id="account_info">
    <div class="setting" title="Profile Setting"><b><i class="fa fa-user"></i></b>  <b class="red">Admin</b>
      <a href="setting"><img src="images/gear.png" class="gear" alt="Profile Setting"></a>
    </div>
    <div class="logout" title="Disconnect"><b>Logout</b>
      <img src="images/connect.png" name="connect" class="disconnect" alt="disconnect">
    </div>
  </div>
</div>
<!--// header -->
<?php

$PARTNER = "";
$PID = "";
$editURL = '';
if(isset($_SESSION['ADMIN_PARTNER'])){
  $PARTNER = "true";
  $PID = getPId($_SESSION['ADMIN_PARTNER']);
  $editURL = '&id='.$PID;
}

?>
<div id="left_menu">
  <ul id="main_menu" class="main_menu">
    <?php if($PARTNER == "") { ?>
      <li class="limenu"><a rel="dashboard" href="dashboard"><span class="ico gray shadow home" ></span><b>Dashboard</b></a></li>
      <li class="limenu"><a rel="members"  href="members"><span class="ico gray shadow group" ></span><b>Members</b></a></li>
    <?php } ?>
    <li class="limenu"><a rel="#" href="#" class="NotFoundURL"><span class="ico gray shadow clipboard" ></span><b>Restaurants</b></a>
      <ul>
        <li><a href="menu-type">Menu Type</a></li>
        <li><a href="categories">Categories</a></li>
        <li><a href="items">Items</a></li>
        <li><a href="subitem">SubItems</a></li>
        <li><a href="meal-items">Meal Items</a></li>
      </ul>
    </li>
    <li class="limenu"><a rel="location"  href="location"><span class="ico gray shadow location" ></span><b>Menu Locations</b></a></li>
    <li class="limenu"><a rel="orders" href="orders<?php echo str_replace('&','?',$editURL);?>"><span class="ico gray shadow money_bag" ></span><b>Orders</b></a>
      <ul>
        <li><a href="orders?type=complete<?php echo $editURL;?>">Completed</a></li>
        <li><a href="orders?type=pending<?php echo $editURL;?>">Pending</a></li>
        <li><a href="orders?type=assign<?php echo $editURL;?>">Assign</a></li>
        <li><a href="orders?type=cancel<?php echo $editURL;?>">Cancel</a></li>
      </ul>
    </li>
    <?php if($PARTNER == "") { ?>
      <li class="limenu"><a rel="home-slider"  href="home-slider"><span class="ico gray shadow home" ></span><b>Home Page Sider</b></a></li>
      <li class="limenu"><a rel="staff"  href="staff"><span class="ico gray shadow administrator" ></span><b>Manage Staff</b></a></li>
      <li class="limenu"><a rel="feedback"  href="feedback"><span class="ico gray shadow eye" ></span><b>Feedback</b></a>
        <ul>
          <li><a href="feedback?type=posted">Posted</a></li>
          <li><a href="feedback?type=pending">Pending</a></li>
        </ul>
      </li>
      <li class="limenu"><a rel="own-restaurant"  href="own-restaurant"><span class="ico gray shadow clipboard" ></span><b>Join Restaurants</b></a>
        <ul>
          <li><a href="own-restaurant?type=active">Posted</a></li>
          <li><a href="own-restaurant?type=pending">Pending</a></li>
        </ul>
      </li>
      <li class="limenu"><a rel="setting"  href="setting"><span class="ico gray shadow lock" ></span><b>Settings</b></a></li>
    <?php } ?>
  </ul>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var pageName = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
    if(pageName == 'menu-type' || pageName == 'categories' || pageName == 'items'){
      $('#main_menu .NotFoundURL').parent().addClass('select');
      return false;
    }

    $('#main_menu li').each(function(){
      if($(this).find(':first-child').attr('rel') == pageName){
        $(this).addClass('select');
      }
    });
  });
</script>