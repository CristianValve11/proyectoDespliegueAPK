ANGY AND CRISTIAN'S PROJECT
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
  - [Instalación y Ejecución](#instalación-y-ejecución)
  - [Pruebas Unitarias (PHPUnit)](#pruebas-unitarias-phpunit)
    - [Separación en Funciones](#separación-en-funciones)
    - [Métodos Probados Individualmente](#métodos-probados-individualmente)
    - [Cobertura de Código (Coverage)](#cobertura-de-código-coverage)
  - [Git Flow y Hooks](#git-flow-y-hooks)

---

## Descripción

**Proyecto Despliegue APK** es una aplicación web interactiva que procesa textos para obtener estadísticas sobre la frecuencia de palabras. La aplicación filtra signos de puntuación, elimina *stop words* y normaliza tildes, permitiendo contar y ordenar las palabras de forma precisa.

Integra componentes **frontend** (HTML, CSS, JavaScript con Bootstrap) y **backend** (PHP) en un flujo colaborativo con Git Flow, incluyendo pruebas unitarias con PHPUnit y un hook de pre-push que asegura calidad antes de subir código.

---

## Características

* **Procesamiento de Texto Modular:** Cada paso (quitar tildes, normalizar, limpiar, tokenizar, filtrar, contar) está separado en funciones reutilizables.
* **Filtrado de Stop Words y Tildes:** Stop words configurables; tildes convertidas antes de filtrar.
* **Conteo y Ordenación:** Frecuencia de palabras calculada y ordenada de mayor a menor.
* **Interfaz Dinámica y Responsiva:** Frontend construido con Bootstrap 4.
* **Efecto Hover en Tabla:** Al pasar cursor la fila se resalta.
* **Servidor PHP Integrado:** `php -S localhost:8080`.
* **Pruebas Unitarias con PHPUnit:** Métodos testados de forma independiente.
* **Cobertura:** 100% de coverage en backend.
* **Git Flow y Hooks:** Ramas `main`, `develop`, `feature/*`, `pruebas` y hook `pre-push` en PHP.

---

## Tecnologías Utilizadas

**Frontend:**

* HTML5, CSS3, JavaScript (ES6)
* Bootstrap 4

**Backend:**

* PHP 8.2+
* PHPUnit 9.5 (dev)

**Control de Versiones:**

* Git, GitHub

**Otras:**

* Composer (autoload, dependencias)
* Hook pre-push en PHP para bloquear pushes si pruebas fallan

---

## Estructura del Proyecto

```plaintext
proyectoDespliegueAPK/
├── backend/
│   ├── ProcesadorTexto.php   # Clase con funciones separadas
│   └── procesar.php          # Endpoint JSON
├── frontend/
│   ├── estilos.css
│   ├── index.html            # Ahora en raíz tras movimiento si aplica
│   └── script.js
├── tests/
│   └── ProcesadorTextoTest.php # Pruebas PHPUnit
├── composer.json
├── phpunit.xml              # Configuración de PHPUnit
├── .gitignore
└── README.md
```

---

## Instalación y Ejecución

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/CristianValve11/proyectoDespliegueAPK.git
   cd proyectoDespliegueAPK
   ```
2. Instalar dependencias:

   ```bash
   composer install
   ```
3. Levantar servidor PHP:

   ```bash
   php -S localhost:8080
   ```
4. Abrir en navegador:

   ```
   http://localhost:8080/index.html
   ```

---

## Pruebas Unitarias (PHPUnit)

Se mantienen pruebas independientes para cada función de **ProcesadorTexto**, permitiendo su reutilización.

### Separación en Funciones

* `quitarTildes(string): string`
* `normalizar(string): string`
* `limpiar(string): string`
* `tokenizar(string): array`
* `filtrar(array): array`
* `contar(array): array`
* `procesar(string): array` (pipeline completo)

### Métodos Probados Individualmente

Ejecuta cada prueba por separado:

```
vendor/bin/phpunit --filter test_quitarTildes
vendor/bin/phpunit --filter test_normalizar
vendor/bin/phpunit --filter test_limpiar
vendor/bin/phpunit --filter test_tokenizar
vendor/bin/phpunit --filter test_filtrar
vendor/bin/phpunit --filter test_contar
vendor/bin/phpunit --filter test_pipelineCompleto
```

### Cobertura de Código (Coverage)

* Se alcanza **100%** de cobertura en `backend/`.
* Mide con:

  ```bash
  vendor/bin/phpunit --coverage-text
  ```

---

## Git Flow y Hooks

* **Ramas principales:** `main`, `develop`.
* **Ramas de característica:** `feature/<nombre>` y `pruebas` para añadir tests incrementales.
* **Hook `pre-push`:** en `.git/hooks/pre-push`, bloquea push si PHPUnit falla.

```bash
# Instalación del hook (una vez):
cd .git/hooks
cat > pre-push << 'EOF'
#!/usr/bin/env php
<?php
exec('php vendor/bin/phpunit --stop-on-failure --colors=always', \$out, \$code);
if (\$code !== 0 && !preg_grep('/No tests executed/', \$out)) {
  echo "ERROR: Tests fallidos. Push cancelado.\n";
  exit(1);
}
exit(0);
?>
EOF
chmod +x pre-push
```

---

*¡Gracias por contribuir! Sigue las buenas prácticas de Git y PHPUnit para mantener la calidad del proyecto.*
