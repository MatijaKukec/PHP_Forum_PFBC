<?php 
echo '

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
<div class="container-fluid">
<!-- Brand -->
<a class="navbar-brand" href="index.php">Logo</a>

<ul class="nav navbar-nav navbar-right">
  <li>
    <div class="topnav-right">';
    if (isset($_SESSION['korisnikId'])){
      echo '<a class="nav-link" href="logout.php">Logout</a>';
    } 
    else if (!isset($_SESSION['korisnikId'])) {
      echo'<li>
            <a id="reg" class="nav-link" href="novi_korisnik.php">Novi korisnik</a> 
          </li>
          <li>
            <a id="login" class="nav-link" href="login.php">Login</a>
          </li>';
    }
    
echo'</div>
  </li>
</ul>
</div>

</nav>

<div class="container-fluid"> 
' ?>