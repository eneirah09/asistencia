<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($user['photo'])) ? '../images/' . $user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">ADMINISTRACIÓN</li>
      <li class=""><a href="inicio.php"><i class="fa fa-dashboard"></i> <span>Panel de Control</span></a></li>
      <li class="header">GESTIÓN</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-calendar"></i>
          <span>Asistencia</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="asistencia.php"><i class="fa fa-calendar-check-o"></i> Asistencias</a></li>
          <li><a href="inasistencias.php"><i class="fa fa-calendar-times-o"></i> Inasistencias</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Empleados</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="empleado.php"><i class="fa fa-user"></i> Personal</a></li>
          <li><a href="horario.php"><i class="fa fa-clock-o"></i> Horarios</a></li>
          <li><a href="cargo.php"><i class="fa  fa-suitcase"></i> Cargos</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-credit-card-alt"></i>
          <span>PAGOS</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">

          <li><a href="deducciones.php"><i class="fa fa-minus"></i> Deducciones</a></li>
          <li><a href="bonos.php"><i class="fa fa-money"></i> Bonos</a></li>
          <li><a href="adelantosueldo.php"><i class="fa fa-money"></i> Adelanto Sueldo</a></li>
        </ul>
      </li>
      <li class="header">REPORTES</li>
      <li><a href="nomina.php"><i class="fa fa-files-o"></i> <span>Nómina</span></a></li>
      <li><a href="rhorarios.php"><i class="fa fa-clock-o"></i> <span>Horarios</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>