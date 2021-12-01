<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
       
      <li class="nav-item">
      <a class="nav-link">
       US / New York :
        <?php  
          echo $currenttime = date('g:ia  l jS F Y');
        ?>
         </a>
      </li>
        <a class="nav-link"  href="<?php echo BASE_URL; ?>Users/logout">
          <i class="fas fa-sign-out-alt"></i>LogOut
        </a>
      </li>
    </ul>
    
  </nav>
   