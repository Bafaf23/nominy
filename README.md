# 🚀 Nominy - Sistema de Gestión de Nómina y Personal

Nominy es un sistema web de administración de personal y control de nóminas desarrollado bajo el patrón de arquitectura **MVC (Modelo-Vista-Controlador)** en PHP puro. Está diseñado con un enfoque modular, seguro y escalable para empresas que requieren procesar los pagos de sus trabajadores de forma organizada.

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP puro (Vanilla PHP) sin frameworks [themainframe/php-mvc-sample](https://github.com/themainframe/php-mvc-sample).
* **Manejador de Base de Datos:** MySQL utilizando la librería nativa de MySQLi con consultas preparadas.
* **Frontend:** HTML5, CSS3 maquetado con las utilidades de [Tailwind CSS](https://jsdelivr.net).
* **Interactividad:** JavaScript estándar (pestañas y toggle de contraseñas).
* **Iconografía:** Font Awesome (Sólidos y Regulares).

## 📁 Estructura del Proyecto

```text
nominy/
├── app/
│   ├── controllers/         # Lógica de las peticiones (Login, Register, Logout)
|   ├── sql/                 # Esquema de la base de datos. 
│   └── models/              # Interacción y consultas seguras con la BD
├── views/
│   ├── components/
│   │   ├── atom/            # Componentes minúsculos como mensajes de alerta
│   │   └── molecule/        # Componentes compuestos como el menú lateral (asider.php)
│   ├── dashboard/
│   │   ├── layout.php       # Plantilla base (Layout) para las páginas protegidas
│   │   ├── dashboard.php    # Vista principal con tarjetas de datos
│   │   └── personal.php     # Consulta de listado completo de trabajadores
│   └── index.php            # Pantalla pública de inicio de sesión
```

## ✨ Características Principales

1. **Arquitectura MVC Limpia:** División lógica e independiente entre el acceso a datos, plantillas visuales y las rutas de control.
2. **Sistema de Layout y Componentización:** Header y Footer compartidos para evitar la repetición de código (`DRY`).
3. **Seguridad Integrada:**
   * Almacenamiento de contraseñas mediante encriptación por hash irreversibles (`PASSWORD_BCRYPT`).
   * Prevención absoluta de inyecciones SQL mediante el uso de marcadores `?` y métodos `prepare()`.
4. **Manejo Dinámico de Sesión:** Destrucción y control de cookies seguro en el servidor y navegador.
5. **Filtro de Roles y Estados:** Restricción de acceso para que los usuarios no autorizados o inactivos no puedan ingresar.

## ⚙️ Instalación y Configuración

Para poner en marcha el proyecto de manera local, sigue los siguientes pasos:

1. **Clona o copia** la carpeta `nominy` dentro del directorio público de tu servidor local (Por ejemplo: `C:/xampp/htdocs/nominy` si usas XAMPP).
2. **Importa la base de datos:** Accede a `phpMyAdmin`, crea una base de datos llamada `roster_db` y ejecuta el script de tus tablas.
3. Asegúrate de tener al menos una cuenta en la tabla `users` con el campo `is_active` en valor `1`.
4. Abre tu navegador web y navega a la URL: `http://localhost/nominy/index.php`.

## 📜 Licencia

Este proyecto fue desarrollado por Bryant Facenda con fines educativos y de aprendizaje estructural.
