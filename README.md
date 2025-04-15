# Proyecto Despliegue APK

[![GitHub last commit](https://img.shields.io/github/last-commit/CristianValve11/proyectoDespliegueAPK?style=flat-square)](https://github.com/CristianValve11/proyectoDespliegueAPK)
[![GitHub issues](https://img.shields.io/github/issues/CristianValve11/proyectoDespliegueAPK?style=flat-square)](https://github.com/CristianValve11/proyectoDespliegueAPK/issues)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)](LICENSE)

---

## Índice

- [Proyecto Despliegue APK](#proyecto-despliegue-apk)
  - [Índice](#índice)
  - [Descripción](#descripción)
  - [Características](#características)
  - [Tecnologías Utilizadas](#tecnologías-utilizadas)
  - [Estructura del Proyecto](#estructura-del-proyecto)

---

## Descripción

**Proyecto Despliegue APK** es una aplicación web interactiva que procesa textos para obtener estadísticas sobre la frecuencia de palabras. La aplicación filtra signos de puntuación y elimina *stop words*, permitiendo contar y ordenar las palabras de forma precisa.

Este proyecto integra componentes **frontend** (HTML, CSS, JavaScript con integración de Bootstrap) y **backend** (PHP) en un flujo de trabajo colaborativo basado en Git Flow. Es ideal para aprender y practicar buenas prácticas de desarrollo, integración y despliegue.

---

## Características

- **Procesamiento de Texto:** Limpia y normaliza el texto (convierte todo a minúsculas y elimina signos de puntuación).
- **Filtrado de Stop Words:** Excluye palabras comunes para obtener estadísticas útiles.
- **Conteo y Ordenación:** Calcula la frecuencia de cada palabra y las ordena de mayor a menor.
- **Interfaz Web Dinámica y Responsiva:** Permite al usuario introducir texto y ver los resultados sin recargar la página.
- **Integración con Bootstrap:** El diseño utiliza Bootstrap para un aspecto moderno y responsivo, con componentes estilizados.
- **Efecto Hover Personalizado:** La tabla de resultados muestra un efecto hover: al pasar el cursor sobre cada fila, la fuente se agranda para realzar la información.
- **Desarrollo Colaborativo con Git Flow:** Uso de ramas (main, develop, feature/*) para organizar el desarrollo.
- **Servidor PHP Integrado:** Ejecuta el proyecto localmente con `php -S localhost:8080`.

---

## Tecnologías Utilizadas

**Frontend:**
- **HTML5:** Estructura y semántica de la web.
- **CSS3:** Estilos, incluyendo reglas personalizadas para efecto hover.
- **JavaScript (ES6):** Manejo de peticiones asíncronas y manipulación del DOM.
- **Bootstrap 4:** Framework CSS para un diseño moderno, con componentes responsivos y estilos predefinidos.

**Backend:**
- **PHP:** Procesa el texto, elimina stop words y cuenta la frecuencia de cada palabra.

**Control de Versiones:**
- **Git & GitHub:** Uso de Git Flow para organizar el desarrollo en ramas (main, develop, feature/*).

**Otras Herramientas:**
- **Servidor PHP Integrado:** Utiliza `php -S localhost:8080` para desarrollar localmente en el puerto 8080.

---

## Estructura del Proyecto

```plaintext
proyectoDespliegueAPK/
├── frontend/
│   ├── index.html         # Página principal con formulario, textarea y contenedor para resultados
│   ├── style.css          # Estilos para la interfaz (incluye Bootstrap y efecto hover)
│   └── script.js          # Código JavaScript para enviar datos al backend y mostrar resultados en tabla
├── backend/
│   └── procesar.php       # Script PHP que procesa el texto, filtra y cuenta palabras
├── README.md              # Documentación y guías del proyecto
└── .gitignore             # Archivos y carpetas ignoradas en Git
