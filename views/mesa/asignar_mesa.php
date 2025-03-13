<?php include __DIR__ . '/../header_vendedor.php'; ?>

<?php
$base_path = '/expo_v2';

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/papeleta.php';
require_once __DIR__ . '/../../models/mesa.php';

$db = new Database();
$pdo = $db->getConnection();
$papeletaModel = new Papeleta($pdo);
$mesaModel = new Mesa($pdo);

$idPapeleta = $_GET['id'] ?? null;
if (!$idPapeleta) {
    echo "No se especificó la papeleta.";
    exit();
}

$papeleta = $papeletaModel->getById($idPapeleta);
$mesas = $mesaModel->getAll();
?>

<div class="container mt-5" style="max-width: 600px;">
  <div class="card">
    <div class="card-header text-center">
      <h2 class="titulo-principal mb-0">Asignar Mesa</h2>
    </div>
    <div class="card-body">
      <!-- Mostrar mensajes -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
          ?>
        </div>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success">
          <?php 
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
          ?>
        </div>
      <?php endif; ?>

      <p>
        <strong>Folio:</strong> <?php echo $papeleta['folio_papeleta']; ?><br>
        <strong>ID Cliente:</strong> <?php echo $papeleta['id_cliente']; ?>
      </p>

      <form method="POST" action="<?php echo $base_path; ?>/vendedor/papeleta/mesas">
        <input type="hidden" name="id_papeleta" value="<?php echo $papeleta['id_papeleta']; ?>">
        
        <div class="form-group">
          <label for="id_mesa">Seleccionar Mesa:</label>
          <select name="id_mesa" id="id_mesa" class="form-control">
            <?php foreach ($mesas as $m): 
              $currentCount = $papeletaModel->countAsignacionesMesa($m['id_mesa']);
            ?>
              <option value="<?php echo $m['id_mesa']; ?>"
                data-current="<?php echo $currentCount; ?>"
                data-capacity="<?php echo $m['capacidad']; ?>">
                <?php echo $m['nombre_mesa']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Progress bar para estadística -->
        <div id="mesaProgress" class="mb-3" style="display: none;">
          <label>Estado de cupos:</label>
          <div class="progress">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" 
                 aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <small id="progressText"></small>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary mr-2">Asignar Mesa</button>
          <a href="<?php echo $base_path; ?>/vendedor/papeleta/mesa" class="btn btn-secondary">Regresar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Al cargar la página, inicializa el progress bar basado en los atributos data del option seleccionado
document.addEventListener('DOMContentLoaded', function() {
  const selectMesa = document.getElementById('id_mesa');
  const progressContainer = document.getElementById('mesaProgress');
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');

  function updateProgress() {
    const selectedOption = selectMesa.options[selectMesa.selectedIndex];
    const current = parseInt(selectedOption.getAttribute('data-current')) || 0;
    const capacity = parseInt(selectedOption.getAttribute('data-capacity')) || 1;
    const percent = (current / capacity) * 100;
    progressBar.style.width = percent + '%';
    progressBar.setAttribute('aria-valuenow', current);
    progressText.textContent = `${current} de ${capacity} cupos ocupados`;
    progressContainer.style.display = 'block';
  }

  // Inicializar el progress bar
  updateProgress();
  // Actualizar cada vez que se cambie la selección
  selectMesa.addEventListener('change', updateProgress);
});
</script>

<?php include __DIR__ . '/../footer_ventas.php'; ?>
