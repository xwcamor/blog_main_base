  document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("toggle-darkmode");
    const icon = document.getElementById("theme-icon");

    // Aplica el modo guardado en localStorage al cargar
    const savedTheme = localStorage.getItem("adminlte-theme");
    if (savedTheme === "dark") {
      document.body.classList.add("dark-mode");
      icon.classList.replace("fa-moon", "fa-sun");
    }

    btn.addEventListener("click", function () {
      const isDark = document.body.classList.toggle("dark-mode");
      localStorage.setItem("adminlte-theme", isDark ? "dark" : "light");

      // Cambiar el icono
      icon.classList.toggle("fa-moon", !isDark);
      icon.classList.toggle("fa-sun", isDark);
    });
  });