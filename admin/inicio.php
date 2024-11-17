<?php include 'includes/session.php'; ?>
<?php
include '../admin/asistencia/timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          PANEL DE CONTROL
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Panel de Control</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i>¡Proceso Exitoso!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM employees";
                $query = $conn->query($sql);

                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Total de Empleados</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-stalker"></i>
              </div>
              <a href="empleado.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">

                <?php
                $sql = "SELECT * FROM attendance";
                $query = $conn->query($sql);
                $total = $query->num_rows;
                if ($total > 0) {
                  $sql = "SELECT * FROM attendance WHERE status = 1";
                  $query = $conn->query($sql);
                  $early = $query->num_rows;
                  $percentage = ($early / $total) * 100;
                  echo "<h3>" . number_format($percentage, 2) . "<sup style='font-size: 20px'>%</sup></h3>";
                } else {
                  echo "<h3>0<sup style='font-size: 20px'>%</sup></h3>";
                }
                ?>

                <p>Empleados a Tiempo</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="asistencia.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM attendance WHERE date = '$today' AND status = 1";
                $query = $conn->query($sql);
                echo "<h3>" . $query->num_rows . "</h3>";
                ?>
                <p>A tiempo hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-clock"></i>
              </div>
              <a href="asistencia.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM attendance WHERE date = '$today' AND status = 0";
                $query = $conn->query($sql);

                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Tarde hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-alert-circled"></i>
              </div>
              <a href="asistencia.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <?php
                $sql = "SELECT COUNT(*) AS total_absences FROM absences";
                $query = $conn->query($sql);
                $row = $query->fetch_assoc();
                $total_absences = $row['total_absences'];
                echo "<h3>" . $total_absences . "</h3>";
                ?>
                <p>Total de Inasistencias</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="inasistencias.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Informe de asistencia mensual</h3>
                <div class="box-tools pull-right">
                  <form class="form-inline">
                    <div class="form-group">
                      <label>Seleccionar Año: </label>
                      <select class="form-control input-sm" id="select_year">
                        <?php
                        for ($i = 2015; $i <= 2065; $i++) {
                          $selected = ($i == $year) ? 'selected' : '';
                          echo "
                            <option value='" . $i . "' " . $selected . ">" . $i . "</option>
                          ";
                        }
                        ?>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <br>
                  <div id="legend" class="text-center"></div>
                  <canvas id="barChart" style="height:350px"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
    <?php include 'includes/footer.php'; ?>

  </div>
  <?php
  $and = 'AND YEAR(date) = ' . $year;
  $months = array();
  $ontime = array();
  $late = array();
  for ($m = 1; $m <= 12; $m++) {
    $sql = "SELECT * FROM attendance WHERE MONTH(date) = '$m' AND status = 1 $and";
    $oquery = $conn->query($sql);
    array_push($ontime, $oquery->num_rows);

    $sql = "SELECT * FROM attendance WHERE MONTH(date) = '$m' AND status = 0 $and";
    $lquery = $conn->query($sql);
    array_push($late, $lquery->num_rows);

    $num = str_pad($m, 2, '0', STR_PAD_LEFT);
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $late = json_encode($late);
  $ontime = json_encode($ontime);

  ?>
  <!-- End Chart Data -->
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      var barChartCanvas = $('#barChart').get(0).getContext('2d');
      var barChart = new Chart(barChartCanvas);
      var barChartData = {
        labels: <?php echo $months; ?>,
        datasets: [{
            label: 'Tarde',
            fillColor: 'rgba(210, 214, 222, 1)',
            strokeColor: 'rgba(210, 214, 222, 1)',
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: <?php echo $late; ?>
          },
          {
            label: 'A tiempo',
            fillColor: 'rgba(60,141,188,0.9)',
            strokeColor: 'rgba(60,141,188,0.8)',
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: <?php echo $ontime; ?>
          }
        ]
      }
      barChartData.datasets[1].fillColor = '#00a65a';
      barChartData.datasets[1].strokeColor = '#00a65a';
      barChartData.datasets[1].pointColor = '#00a65a';
      var barChartOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: 'rgba(0,0,0,.05)',
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        responsive: true,
        maintainAspectRatio: true
      }

      barChartOptions.datasetFill = false;
      var myChart = barChart.Bar(barChartData, barChartOptions);
      document.getElementById('legend').innerHTML = myChart.generateLegend();
    });
  </script>
  <script>
    $(function() {
      $('#select_year').change(function() {
        window.location.href = 'inicio.php?year=' + $(this).val();
      });
    });
  </script>
</body>

</html>