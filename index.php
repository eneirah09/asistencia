<?php session_start(); ?>
<!-- RUTA ORIGINAL CARPETA -->
<?php include 'admin/asistencia/header.php'; ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <p id="date"></p>
      <p id="time" class="bold"></p>
    </div>
    <div class="login-box-body">
      <h4 class="login-box-msg">INGRESE SU CÓDIGO</h4>
      <form id="attendance">
        <div class="form-group">
          <select class="form-control" name="status">
            <option value="in">ENTRADA</option>
            <option value="out">SALIDA</option>
          </select>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control input-lg" id="employee" name="employee" required>
          <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-info btn-block btn-flat" name="signin"></i> MARCAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="alert alert-success alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
    </div>
    <div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
    </div>
  </div>
  <?php include 'admin/asistencia/scripts.php' ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>


  <!-- RUTA ORIGINAL CARPETA -->
  <script type="text/javascript">
    $(function() {
      moment.locale('es');
      var interval = setInterval(function() {
        var momentNow = moment();
        var dateStr = momentNow.format('dddd - D MMMM - YYYY').toUpperCase();
        $('#date').html(dateStr);
        $('#time').html(momentNow.format('hh:mm:ss A'));
      }, 100);
      $('#attendance').submit(function(e) {
        e.preventDefault();
        var attendance = $(this).serialize();
        $.ajax({
          type: 'POST',
          url: 'admin/asistencia/asistencia.php',
          data: attendance,
          dataType: 'json',
          success: function(response) {
            if (response.error) {
              $('.alert').hide();
              $('.alert-danger').show();
              $('.message').html(response.message);
            } else {
              $('.alert').hide();
              $('.alert-success').show();
              $('.message').html(response.message);
              $('#employee').val('');
            }
          }
        });
      });
    });
  </script>
</body>

</html>