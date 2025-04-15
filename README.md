ANGY AND CRISTIAN'S PROJECT
## Índice

- [Índice](#índice)
- [Descripción](#descripción)
- [Características](#características)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Estructura del Proyecto](#estructura-del-proyecto)

---

## Descripción

**Proyecto Despliegue APK** es una aplicación web interactiva que procesa textos para obtener estadísticas sobre la frecuencia de palabras. La aplicación filtra signos de puntuación y elimina *stop words*, permitiendo contar y ordenar las palabras de forma precisa.

Este proyecto integra componentes **frontend** (HTML, CSS, JavaScript) y **backend** (PHP) en un flujo de trabajo colaborativo basado en Git Flow. Es ideal para aprender y practicar buenas prácticas de desarrollo, integración y despliegue.

---

## Características

- **Procesamiento de Texto:** Limpia y normaliza texto (convierte todo a minúsculas, elimina puntuación).
- **Filtrado de Stop Words:** Excluye palabras comunes para obtener estadísticas útiles.
- **Conteo y Ordenación:** Mide la frecuencia de cada palabra y las ordena de mayor a menor.
- **Interfaz Web Dinámica:** Permite que el usuario introduzca texto y vea los resultados sin recargar la página.
- **Integración con Git Flow:** Desarrollo colaborativo usando ramas (main, develop, feature/*).
- **Desarrollo Local Fácil:** Incluye instrucciones para iniciar un servidor local con PHP.

---

## Tecnologías Utilizadas

**Frontend:**
- **HTML5:** Estructura la web.
- **CSS3:** Estilo y diseño moderno.
- **JavaScript (ES6):** Gestión de la interacción asíncrona entre el frontend y el backend.

**Backend:**
- **PHP:** Procesamiento del texto, eliminación de stop words y conteo de frecuencia.

**Control de Versiones:**
- **Git & GitHub:** Uso de Git Flow para organizar el desarrollo colaborativo.

**Otras Herramientas:**
- **Servidor PHP Integrado:** Ejecuta el proyecto en local con `php -S localhost:8000`.

---

## Estructura del Proyecto

```plaintext
proyectoDespliegueAPK/
├── frontend/
│   ├── index.html         # Página principal con formulario, textarea y contenedor para resultados
│   ├── style.css          # Estilos para una interfaz atractiva (opcional)
│   └── script.js          # Código JavaScript para enviar datos al backend y mostrar resultados
├── backend/
│   └── procesar.php       # Script PHP que procesa el texto, filtra y cuenta palabras
├── README.md              # Documentación y guías del proyecto
└── .gitignore             # Archivos y carpetas ignoradas en Git
