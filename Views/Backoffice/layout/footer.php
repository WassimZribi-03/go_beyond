      </div>
    </main>
  </div>

  <!--   Core JS Files   -->
  <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/core/popper.min.js"></script>
  <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/core/bootstrap.min.js"></script>
  <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/plugins/chartjs.min.js"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Control Center for Argon Dashboard -->
  <script src="https://demos.creative-tim.com/argon-dashboard/assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>
</html> 