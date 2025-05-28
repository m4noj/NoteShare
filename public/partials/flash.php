<?php
if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])): ?>

    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3">

        <?php foreach ($_SESSION['flash_messages'] as $flash): ?>

        <div class="toast align-items-center text-bg-<?= $flash['type'] ?> border-0 mb-2 shadow-sm slide-in" role="alert" aria-live="polite" aria-atomic="true">
        
        <div class="d-flex">
          <!-- Icon Section -->
          <div class="toast-icon p-3">
            <?php if ($flash['type'] === 'success'): ?>
              <i class="bi bi-check-circle-fill text-white"></i>
            <?php elseif ($flash['type'] === 'danger'): ?>
              <i class="bi bi-exclamation-triangle-fill text-white"></i>
            <?php elseif ($flash['type'] === 'warning'): ?>
              <i class="bi bi-exclamation-circle-fill text-dark"></i>
            <?php elseif ($flash['type'] === 'info'): ?>
              <i class="bi bi-info-circle-fill text-white"></i>
            <?php endif; ?>
          </div>

          <!-- Message Section -->
          <div class="toast-body text-white">
            <?= $flash['message'] ?>
          </div>

          <!-- Close Button -->
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Clear Messages After Displaying -->
  <?php unset($_SESSION['flash_messages']); ?>

  <?php endif; ?>

  

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let toastContainer = document.getElementById("toast-container");
    let toasts = toastContainer.querySelectorAll(".toast");
    
    toasts.forEach(toast => {
      let bsToast = new bootstrap.Toast(toast);
      bsToast.show();

      // Slide out after 5 seconds
      setTimeout(() => {
        toast.classList.add("slide-out");
        setTimeout(() => toast.remove(), 500); // Remove from DOM
      }, 5000);
    });
  });
</script>


<style>
.toast {
display: flex;
  align-items: center;
  min-width: 250px;
  max-width: 400px;
  padding: 12px;
  font-size: 14px;
  transform: translateX(100%); /* Start off-screen */
  opacity: 0;
  transition: transform 0.5s ease-out, opacity 0.5s ease-in-out;
}

.toast.slide-in {
    transform: translateX(0); /* Slide into view */
    opacity: 1;
}

.toast.slide-out {
    transform: translateX(100%); /* Slide out */
    opacity: 0;
}

.toast-icon {
    font-size: 24px;
}

.toast-body {
  flex: 1;
  padding-left: 8px;
}

#toast-container {
  z-index: 1050;
}


</style>