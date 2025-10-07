# 🧠 AbrazaMente - Sistema de Gestión de Citas Psicológicas

<div align="center">

![Portada](./capturas/Portada.png)

**Sistema web para gestión de citas en consultorio psicológico**  
*Desarrollado por el Equipo 7 - 5CM51*

[![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Enabled-blue.svg)](https://docker.com)
[![MySQL](https://img.shields.io/badge/MySQL-MariaDB-orange.svg)](https://mariadb.org)

</div>

## 🚀 Características Principales

### 👥 Roles del Sistema
- **👨‍⚕️ Especialistas/Doctores**: Gestión de sesiones y citas
- **👤 Pacientes**: Reserva de citas y seguimiento
- **👑 Administradores**: Gestión completa del sistema

### 🛠️ Tecnologías
- **Backend**: PHP 7.4+ con Apache
- **Base de Datos**: MariaDB 10.5
- **Contenedores**: Docker & Docker Compose
- **Frontend**: HTML5, CSS3, JavaScript

## 📋 Diagramas del Sistema

### 🔄 Comportamiento Backend
El sistema utiliza un patrón de sesiones PHP con verificación de usuario y redirecciones seguras. Todas las páginas protegidas inician con `session_start()` y verifican `$_SESSION['user']` antes de permitir acceso.

### 🗺️ Flujo de Navegación
- **Público**: Login, Registro
- **Pacientes**: Dashboard, Especialistas, Sesiones, Reservas
- **Especialistas**: Dashboard, Citas, Sesiones
- **Administradores**: Dashboard, Gestión de Especialistas, Sesiones, Citas

## 🎯 Funcionalidades Clave

### 📅 Reserva de Citas
- Selección de especialistas por especialidad
- Control de cupos por sesión
- Confirmación inmediata de reservas
- Sistema de numeración automática

### 👨‍💼 Panel de Administración
- CRUD completo de especialistas
- Programación de sesiones terapéuticas
- Visualización de citas y estadísticas
- Gestión de pacientes

### 🏥 Especialidades Disponibles
46 especialidades psicológicas incluyendo:
- Terapia Cognitivo Conductual infantil
- Psiquiatría infantil
- Neuropsicología
- Manejo de alergias relacionadas con salud mental
- Soporte en cuidados perioperatorios

## 🐳 Instalación con Docker
https://docs.docker.com/engine/install

### Prerrequisitos
- Docker
- Docker Compose

### Ejecución
```bash
# Clonar repositorio
git clone https://github.com/J0VAN1/AbrazaMente.git
cd AbrazaMente

# Iniciar contenedores
docker-compose up -d
Acceso
Aplicación: http://localhost:8080

PHPMyAdmin: http://localhost:8081

Base de datos: MariaDB en puerto 3306

🔧 Configuración
Credenciales por Defecto
php
// Database connection
Host: db
Database: charmander
User: charmanderuser
Password: userpassword

// Usuarios de prueba
Admin: admin@edoc.com / 123
Doctor: doctor@edoc.com / 123  
Paciente: patient@edoc.com / 123
📊 Estructura de Base de Datos
Tablas Principales
patient - Información de pacientes

doctor - Especialistas y sus especialidades

appointment - Citas reservadas

schedule - Sesiones programadas

specialties - Catálogo de 46 especialidades

webuser - Control de usuarios y roles

👥 Equipo de Desarrollo
Equipo 7 - Sección 5CM51

Nombre	Rol
Cortés Reyes Samantha	Desarrollo Frontend
Mendoza Jacobo Erick Abner	Base de Datos
Nuñez Moguel Brayan	Backend PHP
Sarabia Avendaño Jovani	Arquitectura & Docker
Vásquez Salinas Alitzel Aimee	Diseño UI/UX
📸 Capturas del Sistema
Panel de Administración
https://./capturas/ejemploAdmin.png

Gestión de Base de Datos
https://./capturas/phpadmin.png

🚨 Notas de Seguridad
Sistema de autenticación por sesiones PHP

Validación de tipos de usuario

Protección contra acceso no autorizado

Prepared statements en consultas críticas

📄 Licencia
Este proyecto está bajo la Licencia MIT. Ver archivo LICENSE para más detalles.

<div align="center">
¿Preguntas o problemas?
Abre un issue en el repositorio o contacta al equipo de desarrollo.

</div> ```
