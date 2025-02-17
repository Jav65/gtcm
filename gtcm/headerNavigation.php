<!-- ======= Header ======= -->
<section id="topbar" class="topbar">
  <div class="headerRow">
    <div class="contact-info">
      <a href="" id="anchorRole">
        <img
          src="https://www.freepnglogos.com/uploads/logo-garuda-png/garuda-buku-pembangunan-desa-kementrian-desa-pdtt-2.png"
          width="50px">
        <i class="ms-3 h7 font-weight-bold">GOVERNMENT TASK CONTROL MANAGEMENT</i>
      </a>
    </div>
    <script>
      role = "<?php echo $_SESSION['role']; ?>";
      if (role == "Superadmin") {
        document.getElementById("anchorRole").href = "superadminMainCMMAI.php";
      } else if (role == "Operator CMMAI") {
        document.getElementById("anchorRole").href = "operatorMainCMMAI.php";
      } else if (role == "Operator Ministry") {
        document.getElementById("anchorRole").href = "operator_ministryMain.php";
      } else if (role == "Observer CMMAI") {
        document.getElementById("anchorRole").href = "dashboardMainCMMAI.php";
      } else if (role == "Observer Ministry") {
        document.getElementById("anchorRole").href = "dashboardMainMinistry.php";
      }
    </script>
    <div class="social-links m-3">
      <a href="#" class="twitter">Welcome,
        <?php echo $_SESSION['name']; ?>
        <?php echo "(" . $_SESSION['role'] . ")"; ?>
      </a><br><br>
      <a class="d-flex justify-content-end" href="logout.php" class="twitter">LOGOUT</a><br><br>
    </div>
  </div>


  <div class="headerRowSmall d-flex justify-content-between">
    <div class="contact-info-new m-3 w-100">
      <a href="" id="anchorRole2">
        <img
          src="https://www.freepnglogos.com/uploads/logo-garuda-png/garuda-buku-pembangunan-desa-kementrian-desa-pdtt-2.png"
          width="40px">
        <i class="ms-3 font-weight-bold hrs-gtcm">GOVERNMENT TASK CONTROL MANAGEMENT</i>
        <br>

      </a>
      <script>
        role = "<?php echo $_SESSION['role']; ?>";
        if (role == "Superadmin") {
          document.getElementById("anchorRole2").href = "superadminMainCMMAI.php";
        } else if (role == "Operator CMMAI") {
          document.getElementById("anchorRole2").href = "operatorMainCMMAI.php";
        } else if (role == "Operator Ministry") {
          document.getElementById("anchorRole2").href = "operator_ministryMain.php";
        } else if (role == "Observer CMMAI") {
          document.getElementById("anchorRole2").href = "dashboardMainCMMAI.php";
        } else if (role == "Observer Ministry") {
          document.getElementById("anchorRole2").href = "dashboardMainMinistry.php";
        }
      </script>
      <div class="d-flex justify-content-between">
      <a href="#" style="color: gray !important" class="twitter">Welcome,
        <?php echo $_SESSION['name']; ?>
        <?php echo "(" . $_SESSION['role'] . ")"; ?>
      </a>
      <a style="color:gray" class="d-flex justify-content-end" href="logout.php" class="twitter">LOGOUT</a><br><br>
      </div>
      
    </div>
    <!-- <div class="headerNew m-3">
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div> -->
  </div>


</section>
<!-- End Top Bar -->


<!-- End Header -->