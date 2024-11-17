<?php include 'includes/session.php'; ?>
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
                    GESTIÓN INASISTENCIAS
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                    <li class="active">Gestión Inasistencias</li>
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
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th class="hidden"></th>
                                        <th>Fecha</th>
                                        <th>Código Empleado</th>
                                        <th>Nombre</th>
                                        <th>Tipo de Inasistencia</th>
                                        <th>Días Acumulados</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "
                                        SELECT *,
                                        @row_number := IF(@current_employee = employee_id, @row_number + 1, 1) AS row_number,
                                        @current_employee := employee_id
                                        FROM (
                                            SELECT absences.*, employees.employee_id AS empid, employees.firstname, employees.lastname, absence_types.description AS absence_type,
                                            (SELECT COUNT(*) FROM absences WHERE absences.employee_id = employees.id) AS total_days
                                            FROM absences
                                            LEFT JOIN employees ON employees.id=absences.employee_id
                                            LEFT JOIN absence_types ON absence_types.id=absences.absence_type_id
                                            ORDER BY absences.employee_id, absences.date DESC
                                        ) AS subquery, (SELECT @row_number := 0, @current_employee := '') AS vars
                                        ";
                                        $query = $conn->query($sql);
                                        while ($row = $query->fetch_assoc()) {
                                            echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>" . date('M d, Y', strtotime($row['date'])) . "</td>
                          <td>" . $row['empid'] . "</td>
                          <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                          <td>" . $row['absence_type'] . "</td>
                                                 <td>" . ($row['row_number'] == 1 ? $row['total_days'] : '') . "</td>
                          <td>
                            <button class='btn btn-warning btn-sm btn-flat edit' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Editar</button>
                            <button class='btn btn-danger btn-sm btn-flat delete' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Eliminar</button>
                          </td>
                        </tr>
                      ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/modal_inasistencias.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>

    <!-- JavaScript to handle modals -->
    <script>
        $(function() {
            $('.edit').click(function(e) {
                e.preventDefault();
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'inasistencias_lis.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#datepicker_edit').val(response.date);
                    $('#edit_absence_type').val(response.absence_type_id);
                    $('#edit_reason').val(response.reason);
                    $('#id').val(response.id);
                    $('#del_id').val(response.id);
                    $('#del_employee_name').html(response.firstname + ' ' + response.lastname);
                }
            });
        }
    </script>
</body>

</html>