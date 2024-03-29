
<!-- Navbar-->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Moja stranica</a>
  <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
  <!-- Navbar Search-->
  <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
          <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
          <div class="input-group-append">
              <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
          </div>
      </div>
  </form>
  <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <?php
          if(isset($_SESSION['korisnikIdUid'])){
            $kor=$_SESSION['korisnikIdUid'];
            echo '
              <a class="dropdown-item" href="uredi_korisnik.php">Postavke</a>
              <a class="dropdown-item" href="#">Activity Log</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">Logout</a>';
            }
          else echo '
            <div id="example" role="application" style="float:left;width:49%; margin-right:2%">
            <a class="dropdown-item" href="novi_korisnik.php">Registriraj se</a>
            </div>
            <div id="example" role="application" style="float:right;width:49%; margin-right:2%">
            <a class="dropdown-item" href="login.php">Login</a>
            </div>';
          ?>
          </div>
      </li>
  </ul>
</nav>
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
              <div class="nav">
                  <div class="sb-sidenav-menu-heading">Doma</div>
                  <a class="nav-link" href="index.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                      Doma
                  </a>
                  <div class="sb-sidenav-menu-heading">Sučelje</div>
                  <a class="nav-link collapsed" href="forum.php" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                      <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                      Forum
                      <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                      <nav class="sb-sidenav-menu-nested nav">
                            <?php 
                                                        
                            # Dohvaćanje svih postojećih foruma
                            $poc_upit=("SELECT forum_id, forum_naziv FROM forum"); 
                            if($upit=$veza->prepare($poc_upit)){

                            $upit->bind_result($f_id, $f_naziv);

                            $upit->execute();
                            $upit->store_result();
                            
                            } else echo $veza->error;

                            if($upit->num_rows !==0){ // provjera da li forumi postoje
                                while($row = $upit->fetch()){
                                    echo '
                                    <a class="nav-link "href="forum.php?id='. $f_id .'">'. $f_naziv .'</a>';
                                }
                            }
                            ?>
                      </nav>
                  </div>
                  <a class="nav-link collapsed" href="view_post.php" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                      <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                      Postovi
                      <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                      <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                              Authentication
                              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>
                          <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                              <nav class="sb-sidenav-menu-nested nav">
                                  <a class="nav-link" href="login.html">Login</a>
                                  <a class="nav-link" href="register.html">Register</a>
                                  <a class="nav-link" href="password.html">Forgot Password</a>
                              </nav>
                          </div>
                          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                              Error
                              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>
                          <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                              <nav class="sb-sidenav-menu-nested nav">
                                  <a class="nav-link" href="../PFBC/401.html">401 Page</a>
                                  <a class="nav-link" href="../PFBC/404.html">404 Page</a>
                                  <a class="nav-link" href="../PFBC/500.html">500 Page</a>
                              </nav>
                          </div>
                      </nav>
                  </div>
                  <div class="sb-sidenav-menu-heading">Addons</div>
                  <a class="nav-link" href="uredi_korisnik.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                      Uredi profil
                  </a>
                  <a id="sviKor" class="nav-link" href="svi_korisnici.php">
                      <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                      Svi korisnici
                  </a>
              </div>
          </div>
          <div class="sb-sidenav-footer">
            <?php
            if(isset($kor)){
              echo'
              <div class="small">Logged in as:</div>'.$kor;
            }
            ?>
          </div>
      </nav>
  </div>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid">