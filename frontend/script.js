// Seleccionar los elementos relevantes del DOM
const textarea = document.getElementById('texto');
const btnEnviar = document.getElementById('btnEnviar');
const divResultado = document.getElementById('resultado');

// Asignar evento click al botón
btnEnviar.addEventListener('click', () => {
  // 1. Obtener el texto del textarea
  const texto = textarea.value;
  
  // 2. Enviar el texto al backend usando fetch
  // Construir los datos en formato formulario
  const formData = new FormData();
  formData.append('texto', texto);
  
  fetch('http://localhost:8080/backend/procesar.php', {  // Asegúrate de usar el puerto correcto
    method: 'POST',
    body: formData
  })
    .then(response => response.json())    // 3. Parsear la respuesta JSON
    .then(data => {
      // 4. Mostrar resultados en la página
      divResultado.innerHTML = '';  // Limpiar resultados previos
      if (data.error) {
        // Si el backend retornó un error (por ejemplo, texto vacío)
        divResultado.innerHTML = `<p><b>Error:</b> ${data.error}</p>`;
      } else {
        // data es un array de objetos {palabra, frecuencia}
        let resultadoHTML = '<h3>Frecuencia de Palabras:</h3><ul>';
        data.forEach(item => {
          resultadoHTML += `<li>${item.palabra}: ${item.frecuencia}</li>`;
        });
        resultadoHTML += '</ul>';
        divResultado.innerHTML = resultadoHTML;
      }
    })
    .catch(error => {
      console.error('Error en la petición:', error);
      divResultado.innerHTML = `<p>Ocurrió un error al procesar la solicitud.</p>`;
    });
});

