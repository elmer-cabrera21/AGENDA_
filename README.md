# Agenda Personal de Contactos con Autenticación en PHP

## 🌐 URL Pública del Proyecto
La aplicación está desplegada y funcionando en internet en el siguiente enlace:
👉 **[https://agenda-elmer.infinityfreeapp.com](https://agenda-elmer.infinityfreeapp.com)**

## 📸 Capturas de Pantalla
*   ![Pantalla de Login](https://github.com/elmer-cabrera21/agenda-contactos/raw/main/login.png)

## 📝 Descripción del Proyecto
Aplicación web desarrollada en PHP y MySQL que permite a los usuarios registrarse, iniciar sesión y gestionar una agenda personal de contactos. El sistema garantiza la seguridad mediante la encriptación de contraseñas y el uso de sesiones, asegurando que cada usuario pueda visualizar, editar y eliminar **únicamente sus propios contactos**.

## 🚀 Mejoras Implementadas (Segunda Entrega)
Para esta versión se implementaron las siguientes mejoras solicitadas:
1.  **Búsqueda de contactos (Opción A):** Se agregó una barra de búsqueda en el panel principal que permite filtrar los contactos en tiempo real por **nombre, correo electrónico o ciudad**.
2.  **Ordenamiento de contactos (Opción B):** Se añadieron enlaces interactivos en los títulos de la tabla para ordenar los contactos de forma **ascendente o descendente** por nombre, teléfono, correo o ciudad.
3.  **Mejoras de Seguridad (Correcciones de la entrega anterior):**
    *   Se cambió la eliminación de contactos de método GET a **POST** para evitar ataques por manipulación de URL.
    *   Se agregó validación estricta del formato de correo electrónico en el servidor.
    *   Se muestra el correo del usuario autenticado en la barra superior del panel.

## 🛠️ Tecnologías Utilizadas
*   **PHP** (Lógica del servidor y manejo de sesiones)
*   **MySQL** (Base de datos relacional)
*   **PDO** (PHP Data Objects para consultas seguras y prevención de inyección SQL)
*   **HTML5 y CSS3** (Estructura y diseño responsivo de la interfaz)
*   **InfinityFree** (Hosting gratuito para el despliegue en producción)

## ⚙️ Funcionalidades Principales
*   **Registro de usuarios:** Validación de correo único y encriptación de contraseña con `password_hash()`.
*   **Inicio de sesión:** Verificación de credenciales con `password_verify()` y creación de variables de sesión (`$_SESSION`).
*   **CRUD de Contactos:** Crear, Leer, Actualizar (Editar) y Eliminar contactos.
*   **Seguridad:** Restricción de acceso a páginas si no hay sesión activa y filtrado de datos por ID de usuario.

## 📋 Requisitos para su Ejecución Local
*   Tener instalado un servidor local como **XAMPP**, WAMP o Laragon.
*   Un navegador web actualizado.
*   PHP 7.4 o superior.

## 🚀 Pasos para Instalar y Ejecutar Localmente
1. Clonar o descargar este repositorio y colocar la carpeta `agenda` dentro del directorio `htdocs` de tu servidor local (ej. `C:\xampp\htdocs\agenda`).
2. Abrir el panel de control de **XAMPP** e iniciar los módulos de **Apache** y **MySQL**.
3. Abrir **phpMyAdmin** en el navegador (`http://localhost/phpmyadmin`).
4. Crear una base de datos llamada **`agenda_contactos`** e importar el archivo **`agenda_contactos.sql`** (incluido en este repositorio) para generar las tablas.
5. Verificar el archivo **`config.php`**. Si tu MySQL local tiene contraseña, agrégala en la variable `$password`. (En XAMPP por defecto es usuario `root` y contraseña vacía `""`).
6. Abrir en el navegador: `http://localhost/agenda/registro.php`

## 👨‍💻 Autor
**Elmer Fernando Cabrera Sánchez**
*Proyecto académico para la materia de Desarrollo Web.*
