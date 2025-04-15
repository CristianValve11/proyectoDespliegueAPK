// Seleccionar los elementos relevantes del DOM
const textarea = document.getElementById('texto');
const btnEnviar = document.getElementById('btnEnviar');
const divResultado = document.getElementById('resultado');

// Asignar evento click al botón
btnEnviar.addEventListener('click', () => {
  // 1. Obtener el texto del textarea
  const texto = textarea.value;
  
  // 2. Enviar el texto al backend usando fetch
  const formData = new FormData();
  formData.append('texto', texto);
  
  fetch('http://localhost:8080/backend/procesar.php', {  
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      // Limpiar resultados previos
      divResultado.innerHTML = '';  
      if (data.error) {
        // Mostrar error con una alerta de Bootstrap
        divResultado.innerHTML = `<div class="alert alert-danger" role="alert">
          <strong>Error:</strong> ${data.error}
        </div>`;
      } else {
        // Construir la tabla con Bootstrap
        let tableHTML = `
          <table class="table table-bordered table-hover">
            <thead class="thead-dark">
              <tr>
                <th>Palabra</th>
                <th>Frecuencia</th>
              </tr>
            </thead>
            <tbody>`;
        data.forEach(item => {
          tableHTML += `
              <tr>
                <td>${item.palabra}</td>
                <td>${item.frecuencia}</td>
              </tr>`;
        });
        tableHTML += `
            </tbody>
          </table>`;
        divResultado.innerHTML = tableHTML;
      }
    })
    .catch(error => {
      console.error('Error en la petición:', error);
      divResultado.innerHTML = `<div class="alert alert-warning" role="alert">
        Ocurrió un error al procesar la solicitud.
      </div>`;
    });
});
